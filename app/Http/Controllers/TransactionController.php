<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;
use Midtrans\Notification;

class TransactionController extends Controller
{
    /**
     * =========================
     * USER TRANSACTIONS
     * =========================
     */
    public function index()
    {
        $user = Auth::user();

        // Hapus transaksi yang status pending dan sudah expired (> 24 jam)
        $expiredTime = now()->subHours(24);
        $expiredTransactions = Transaction::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'unpaid'])
            ->where('created_at', '<', $expiredTime)
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $transaction->status = 'expired';
            $transaction->save();
        }

        $transactions = Transaction::where('user_id', $user->id)
            ->where(function ($q) {
                $q->whereNull('transaction_type')->orWhere('transaction_type', '!=', 'parent');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Load items dan relasi produknya
        // Menggunakan withDefault() pada relasi product di model TransactionItem lebih baik, 
        // tapi kita handle di sini dengan membiarkan product null jika terhapus.
        $transactions->load([
            'items.product' => function ($query) {
                $query->select('id', 'name', 'description', 'price', 'image', 'user_id');
            },
            'items.product.user:id,name,phone'
        ]);

        return response()->json($transactions);
    }

    /**
     * =========================
     * CHECKOUT + MIDTRANS
     * =========================
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        DB::beginTransaction();
        try {
            $cart = Cart::where('user_id', $user->id)->first();
            if (!$cart) {
                return response()->json(['message' => 'Cart not found'], 404);
            }

            // Ambil cart_item_ids dari request (item yang dipilih user)
            $selectedCartItemIds = $request->input('cart_item_ids', []);

            if (empty($selectedCartItemIds)) {
                return response()->json(['message' => 'No items selected for checkout'], 400);
            }

            // Hanya ambil cart items yang dipilih oleh user
            $cartItems = CartItem::with('product')
                ->where('cart_id', $cart->id)
                ->whereIn('id', $selectedCartItemIds)
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Selected items not found in cart'], 400);
            }

            foreach ($cartItems as $item) {
                $stock = $item->product->stock ?? 0;
                if ($item->qty > $stock) {
                    return response()->json([
                        'message' => 'Stok produk tidak mencukupi untuk checkout',
                        'product' => $item->product->name,
                        'requested_qty' => $item->qty,
                        'available_stock' => $stock,
                    ], 422);
                }
            }

            // Kelompokkan cart items berdasarkan penjual (user_id pemilik produk)
            $groups = [];
            foreach ($cartItems as $item) {
                $sellerId = $item->product->user_id ?? 0;
                if (!isset($groups[$sellerId])) $groups[$sellerId] = [];
                $groups[$sellerId][] = $item;
            }

            $shippingAddress = $request->input('shipping_address', []);
            $responseTransactions = [];

            // Initialize Midtrans configuration once
            MidtransConfig::$serverKey = config('midtrans.server_key');
            MidtransConfig::$clientKey = config('midtrans.client_key');
            MidtransConfig::$isProduction = config('midtrans.is_production') ? true : false;
            MidtransConfig::$isSanitized = config('midtrans.is_sanitized') ?? true;
            MidtransConfig::$is3ds = config('midtrans.is_3ds') ?? true;

            foreach ($groups as $sellerId => $items) {
                $groupTotal = 0;
                $itemDetails = [];

                foreach ($items as $it) {
                    $subtotal = ($it->product->price ?? 0) * $it->qty;
                    $groupTotal += $subtotal;
                    $itemDetails[] = [
                        'id' => $it->product->id,
                        'price' => $it->product->price ?? 0,
                        'quantity' => $it->qty,
                        'name' => $it->product->name ?? 'Produk',
                    ];
                }

                // Buat transaksi per penjual
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'total_price' => $groupTotal,
                    'status' => 'pending',
                    'payment_method' => 'midtrans',
                    'shipping_name' => $shippingAddress['name'] ?? $user->name,
                    'shipping_phone' => $shippingAddress['phone'] ?? $user->phone,
                    'shipping_address' => $shippingAddress['address'] ?? $user->address,
                ]);

                foreach ($items as $it) {
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $it->product_id,
                        'qty' => $it->qty,
                        'price' => $it->product->price ?? 0,
                    ]);
                }

                // Generate order_id unik per transaksi
                $orderId = 'ORDER-' . $transaction->id . '-' . time();
                $transaction->order_id = $orderId;
                $transaction->save();

                // Siapkan parameter Midtrans untuk group ini
                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $groupTotal,
                    ],
                    'item_details' => $itemDetails,
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                    ],
                ];

                $enabledPayments = config('midtrans.enabled_payments');
                if ($enabledPayments && is_array($enabledPayments)) {
                    $params['enabled_payments'] = $enabledPayments;
                }

                // Dapatkan snap token
                if (app()->runningUnitTests() || app()->environment('testing')) {
                    $snapToken = 'test-snap-token';
                } else {
                    $snapToken = Snap::getSnapToken($params);
                }

                $transaction->snap_token = $snapToken;
                $transaction->save();

                $responseTransactions[] = [
                    'transaction' => $transaction,
                    'snap_token' => $snapToken,
                    'seller_id' => $sellerId,
                    'seller_name' => optional(optional($items[0])->product->user)->name,
                    'items' => collect($items)->map(function ($it) {
                        return [
                            'product_id' => $it->product_id,
                            'name' => $it->product->name ?? 'Produk',
                            'qty' => $it->qty,
                            'price' => $it->product->price ?? 0,
                            'image_url' => $it->product->image ? \Illuminate\Support\Facades\Storage::url($it->product->image) : null,
                        ];
                    })->values(),
                    'total' => $groupTotal,
                ];
            }

            // Hapus hanya cart items yang sudah di-checkout (yang dipilih user)
            CartItem::whereIn('id', $selectedCartItemIds)->delete();

            DB::commit();

            return response()->json([
                'message' => 'Checkout success',
                'transactions' => $responseTransactions,
            ]);
        } catch (\Exception $e) {
            // Log exception detail to laravel.log for easier debugging
            Log::error('Checkout exception: ' . $e->getMessage(), ['exception' => $e]);
            DB::rollBack();
            return response()->json([
                'message' => 'Checkout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * =========================
     * MIDTRANS NOTIFICATION
     * =========================
     */
    public function notification(Request $request)
    {
        Log::info('MIDTRANS NOTIFICATION MASUK', [
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
            'raw' => $request->getContent(),
        ]);

        // Inisialisasi Midtrans
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = (bool) config('midtrans.is_production');

        try {
            // Midtrans SDK akan parsing payload JSON otomatis
            // Namun di lingkungan testing, kita mungkin perlu manual jika SDK-nya bermasalah
            $notif = null;
            try {
                $notif = new Notification();
            } catch (\Exception $e) {
                // Ignore SDK failure in tests
            }

            $orderId = $notif->order_id ?? $request->input('order_id');
            if (!$orderId) {
                Log::error('MIDTRANS: order_id kosong', ['payload' => $request->all()]);
                return response()->json(['message' => 'Invalid payload: order_id missing'], 400);
            }

            // === VALIDASI SIGNATURE (PENTING) ===
            // Rumus: sha512(order_id + status_code + gross_amount + server_key)
            $statusCode   = (string) ($request->input('status_code') ?? $notif->status_code ?? '');
            $grossAmount  = (string) ($request->input('gross_amount') ?? $notif->gross_amount ?? '');
            $signatureKey = (string) ($request->input('signature_key') ?? $notif->signature_key ?? '');

            // Midtrans kadang kirim gross_amount "1111.00" — pastikan konsisten stringnya
            $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));

            if (!hash_equals($mySignature, $signatureKey)) {
                Log::warning('MIDTRANS: signature tidak valid', [
                    'order_id' => $orderId,
                    'expected' => $mySignature,
                    'got' => $signatureKey,
                    'status_code' => $statusCode,
                    'gross_amount' => $grossAmount,
                ]);
                return response()->json(['message' => 'Invalid signature'], 401);
            }

            $transaction = Transaction::where('order_id', $orderId)->first();
            if (!$transaction) {
                Log::warning('Transaksi tidak ditemukan di database (by order_id)', ['order_id' => $orderId]);
                return response()->json(['message' => 'Transaction not found: ' . $orderId], 404);
            }

            // Ambil field yang relevan dari payload (request lebih “langsung”)
            $txStatus        = $request->input('transaction_status'); // pending/settlement/expire/cancel/deny/capture
            $paymentType     = $request->input('payment_type');       // qris/bank_transfer/etc
            $txId            = $request->input('transaction_id');
            $merchantId      = $request->input('merchant_id');
            $transactionType = $request->input('transaction_type');
            $statusMessage   = $request->input('status_message');
            $fraudStatus     = $request->input('fraud_status');
            $transactionTime = $request->input('transaction_time');   // "2026-01-19 18:02:36"
            $expiryTime      = $request->input('expiry_time');        // "2026-01-19 18:17:36"
            $currency        = $request->input('currency');

            // Customer details (opsional)
            $customerName  = data_get($request->all(), 'customer_details.full_name');
            $customerEmail = data_get($request->all(), 'customer_details.email');

            // Mapping status midtrans -> status internal
            $oldStatus = $transaction->status;
            $newStatus = $transaction->status;

            if (in_array($txStatus, ['capture', 'settlement'], true)) {
                // capture biasanya kartu kredit; settlement umumnya final
                // Jika capture, fraud_status bisa "challenge" -> masih pending
                if ($txStatus === 'capture' && $fraudStatus === 'challenge') {
                    $newStatus = 'pending';
                } else {
                    $newStatus = 'paid';
                }
            } elseif ($txStatus === 'pending') {
                $newStatus = 'pending';
            } elseif (in_array($txStatus, ['cancel', 'deny'], true)) {
                $newStatus = 'failed';
            } elseif ($txStatus === 'expire') {
                $newStatus = 'expired'; // lebih spesifik daripada failed
            }

            $transaction->status = $newStatus;

            // Kurangi stok jika status berubah menjadi paid (dan sebelumnya bukan paid)
            if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                $transaction->reduceStock();
            }
            if ($paymentType) {
                $transaction->payment_method = $paymentType;
            }
            $transaction->midtrans_transaction_id = $txId;
            $transaction->merchant_id = $merchantId;
            $transaction->transaction_type = $transactionType ?: $transaction->transaction_type;
            $transaction->status_code = $statusCode;
            $transaction->status_message = $statusMessage;
            $transaction->fraud_status = $fraudStatus;
            $transaction->signature_key = $signatureKey;
            $transaction->currency = $currency;
            if ($transactionTime) $transaction->transaction_time = $transactionTime;
            if ($expiryTime) $transaction->expiry_time = $expiryTime;
            $transaction->midtrans_payload = $request->all();
            if ($customerName)  $transaction->customer_full_name = $customerName;
            if ($customerEmail) $transaction->customer_email = $customerEmail;
            if (is_numeric($grossAmount)) {
                $transaction->total_price = (float) $grossAmount;
            }
            $transaction->save();

            Log::info('MIDTRANS: STATUS UPDATE BERHASIL', [
                'transaction_id' => $transaction->id,
                'order_id' => $orderId,
                'midtrans_transaction_id' => $txId,
                'status' => $transaction->status,
            ]);

            // === KIRIM NOTIFIKASI WHATSAPP KE PENJUAL ===
            if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                try {
                    $transaction->load(['items.product.user']);
                    $firstItem = $transaction->items->first();
                    $seller = $firstItem->product->user ?? null;

                    if ($seller && $seller->phone) {
                        $waService = new \App\Services\WhatsAppService();
                        $message = "*PESANAN BARU MASUK!* 🚀\n\n" .
                            "Halo {$seller->name},\n" .
                            "Ada pesanan baru yang telah DIBAYAR.\n\n" .
                            "No. Pesanan: {$transaction->order_id}\n" .
                            "Total: Rp " . number_format($transaction->total_price, 0, ',', '.') . "\n" .
                            "Status: SUDAH DIBAYAR ✅\n\n" .
                            "Mohon segera proses pengiriman pesanan ini melalui dashboard U Market Anda.\n\n" .
                            "Terima kasih!";
                        
                        $waService->sendMessage($seller->phone, $message);
                        Log::info("WA Notification sent to seller: {$seller->name} ({$seller->phone})");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send WA notification: " . $e->getMessage());
                }
            }

            return response()->json(['message' => 'OK'], 200);
        } catch (\Throwable $e) {
            Log::error('ERROR MIDTRANS NOTIFICATION: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Error', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * =========================
     * SELLER ORDERS
     * =========================
     */
    public function sellerOrders()
    {
        $seller = Auth::user();

        $productIds = \App\Models\Product::where('user_id', $seller->id)->pluck('id');

        // Pastikan transaksi yang pending/unpaid > 24 jam otomatis jadi expired
        // supaya seller juga melihat "dibatalkan" di riwayat tanpa menunggu pembeli membuka halaman orders.
        $expiredTime = now()->subHours(24);
        Transaction::whereHas('items', function ($q) use ($productIds) {
            $q->whereIn('product_id', $productIds);
        })
            ->whereIn('status', ['pending', 'unpaid'])
            ->where('created_at', '<', $expiredTime)
            ->update(['status' => 'expired']);

        $transactions = Transaction::whereHas('items', function ($q) use ($productIds) {
            $q->whereIn('product_id', $productIds);
        })
            ->with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($transactions);
    }

    /**
     * =========================
     * DELETE EXPIRED TRANSACTION
     * =========================
     */
    public function deleteExpiredTransaction($id)
    {
        $user = Auth::user();
        $transaction = Transaction::findOrFail($id);

        // Hanya user yang membuat transaksi yang bisa menghapusnya
        if ($transaction->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Update status to expired instead of deleting items and keeping status update
        $transaction->status = 'expired';
        $transaction->save();


        return response()->json(['message' => 'Transaction deleted successfully']);
    }

    /**
     * =========================
     * UPDATE STATUS BY SELLER
     * =========================
     */
    public function updateSellerOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        $oldStatus = $transaction->status;
        $transaction->status = $request->status;

        // Kurangi stok jika status berubah menjadi paid secara manual
        if ($transaction->status === 'paid' && $oldStatus !== 'paid') {
            $transaction->reduceStock();
        }

        $transaction->save();

        return response()->json([
            'message' => 'Status updated',
            'transaction' => $transaction
        ]);
    }

    /**
     * =========================
     * RETURN REQUEST (BUYER)
     * =========================
     */
    public function requestReturn(Request $request, $id)
    {
        $user = Auth::user();
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($transaction->status !== 'shipping' && $transaction->status !== 'delivered') {
             return response()->json(['message' => 'Hanya pesanan yang dikirim atau diterima yang bisa diajukan pengembalian'], 400);
        }

        $transaction->status = 'return_requested';
        $transaction->save();

        return response()->json(['message' => 'Pengajuan pengembalian berhasil', 'transaction' => $transaction]);
    }

    /**
     * =========================
     * APPROVE RETURN (SELLER)
     * =========================
     */
    public function approveReturn(Request $request, $id)
    {
        $seller = Auth::user();
        $transaction = Transaction::findOrFail($id);

        // Verify ownership via product
        // In this simple multi-seller logic, checking if seller owns products in transaction
        // NOTE: This assumes transaction items belong to same seller (which current checkout ensures)

        $productIds = \App\Models\Product::where('user_id', $seller->id)->pluck('id');
        $isSeller = $transaction->items()->whereIn('product_id', $productIds)->exists();

        if (!$isSeller) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($transaction->status !== 'return_requested') {
            return response()->json(['message' => 'Status transaksi tidak valid untuk pengembalian'], 400);
        }

        $transaction->status = 'returned';
        $transaction->save();

        return response()->json(['message' => 'Pengembalian disetujui', 'transaction' => $transaction]);
    }
}
