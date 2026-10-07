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
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNotificationMail;
use App\Services\WhatsAppService;

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

            // Ambil daftar item yang dipilih. Mendukung beberapa format input:
            // 1) cart_item_ids: [id, id]
            // 2) items: [{"id": 31, "qty": 2}, {"id": 35, "qty":1}]
            // 3) legacy items_id single value
            $selectedCartItemIds = [];
            $overrideQtys = []; // id => qty, tidak akan menimpa cart di DB

            if ($request->has('items') && is_array($request->input('items'))) {
                foreach ($request->input('items') as $it) {
                    if (!is_array($it) && !is_object($it)) continue;
                    $id = isset($it['id']) ? (int)$it['id'] : (isset($it->id) ? (int)$it->id : null);
                    if (!$id) continue;
                    $selectedCartItemIds[] = $id;
                    if (isset($it['qty']) || isset($it->qty)) {
                        $qty = isset($it['qty']) ? (int)$it['qty'] : (int)$it->qty;
                        if ($qty < 1) {
                            return response()->json(['message' => 'Invalid quantity for item ' . $id], 400);
                        }
                        $overrideQtys[$id] = $qty;
                    }
                }
            } else {
                $selectedCartItemIds = $request->input('cart_item_ids', []);
                if (empty($selectedCartItemIds) && $request->filled('items_id')) {
                    $selectedCartItemIds = [$request->input('items_id')];
                }
                if (empty($selectedCartItemIds)) {
                    $selectedCartItemIds = CartItem::where('cart_id', $cart->id)->pluck('id')->toArray();
                }
            }

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
                $requestedQty = $overrideQtys[$item->id] ?? $item->qty;
                $stock = $item->product->stock ?? 0;
                if ($requestedQty > $stock) {
                    return response()->json([
                        'message' => 'Stok produk tidak mencukupi untuk checkout',
                        'product' => $item->product->name,
                        'requested_qty' => $requestedQty,
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
            $voucherCode = $request->input('voucher_code');
            $voucher = null;

            // Validate voucher if provided
            if ($voucherCode) {
                $voucher = \App\Models\Voucher::where('code', strtoupper(trim($voucherCode)))->first();
                if (!$voucher || !$voucher->isValid() || !$voucher->canBeUsedBy($user->id)) {
                    $voucher = null; // Invalid voucher, ignore silently
                }
            }

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
                    $usedQty = $overrideQtys[$it->id] ?? $it->qty;
                    $subtotal = ($it->product->price ?? 0) * $usedQty;
                    $groupTotal += $subtotal;
                    $itemDetails[] = [
                        'id' => $it->product->id,
                        'price' => $it->product->price ?? 0,
                        'quantity' => $usedQty,
                        'name' => $it->product->name ?? 'Produk',
                    ];
                }

                // Apply voucher discount (if voucher is store-specific, only apply to that seller)
                $discountAmount = 0;
                if ($voucher) {
                    if ($voucher->user_id && $voucher->user_id != $sellerId) {
                        $discountAmount = 0;
                    } else {
                        $discountAmount = $voucher->calculateDiscount($groupTotal);
                    }
                    if ($discountAmount > 0) {
                        $itemDetails[] = [
                            'id' => 'DISCOUNT-' . $voucher->code,
                            'price' => -$discountAmount,
                            'quantity' => 1,
                            'name' => 'Diskon Voucher ' . $voucher->code,
                        ];
                    }
                }

                $finalTotal = max(0, $groupTotal - $discountAmount);

                // Buat transaksi per penjual
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'total_price' => $finalTotal,
                    'status' => 'pending',
                    'payment_method' => 'midtrans',
                    'shipping_name' => $shippingAddress['name'] ?? $user->name,
                    'shipping_phone' => $shippingAddress['phone'] ?? $user->phone,
                    'shipping_address' => $shippingAddress['address'] ?? $user->address,
                    'destination_lat' => $shippingAddress['destination_lat'] ?? $shippingAddress['lat'] ?? null,
                    'destination_lng' => $shippingAddress['destination_lng'] ?? $shippingAddress['lng'] ?? null,
                    'voucher_code' => $discountAmount > 0 ? $voucher->code : null,
                    'discount_amount' => $discountAmount,
                ]);

                foreach ($items as $it) {
                    $usedQty = $overrideQtys[$it->id] ?? $it->qty;
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $it->product_id,
                        'qty' => $usedQty,
                        'price' => $it->product->price ?? 0,
                    ]);
                }

                // Generate order_id unik per transaksi
                $orderId = 'ORDER-' . $transaction->id . '-' . time();
                $transaction->order_id = $orderId;
                $transaction->save();

                // Record voucher usage
                if ($voucher && $discountAmount > 0) {
                    $voucher->recordUsage($user->id, $transaction->id, $discountAmount);
                }

                // Siapkan parameter Midtrans untuk group ini
                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $finalTotal,
                    ],
                    'item_details' => $itemDetails,
                    'customer_details' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                    ],
                    'callbacks' => [
                        'finish' => url('/order-confirmation'),
                        'unfinish' => url('/orders'),
                        'error' => url('/orders'),
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

                // === NOTIFIKASI EMAIL KE PENJUAL (PESANAN MASUK BELUM DIBAYAR) ===
                try {
                    $firstItemForSeller = $items[0] ?? null;
                    $seller = $firstItemForSeller?->product?->user;
                    
                    if ($seller && $seller->email) {
                        Mail::to($seller->email)->send(new OrderNotificationMail($transaction, $seller, false));
                        Log::info("Email Order notification sent to seller: {$seller->name} ({$seller->email})");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send Email Order notification to seller: " . $e->getMessage());
                }

                // === NOTIFIKASI WHATSAPP KE PENJUAL (PESANAN BARU) ===
                try {
                    $wa = new WhatsAppService();
                    $firstItemForSeller = $firstItemForSeller ?? ($items[0] ?? null);
                    $seller = $seller ?? $firstItemForSeller?->product?->user;

                    if ($seller && $seller->phone && $wa->isEnabled()) {
                        $wa->notifySellerNewOrder(
                            $seller->phone,
                            $user->name,
                            $orderId,
                            $groupTotal
                        );
                        Log::info("WhatsApp notification sent to seller: {$seller->name} ({$seller->phone})");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send WhatsApp notification to seller: " . $e->getMessage());
                }

                $responseTransactions[] = [
                    'transaction' => $transaction,
                    'snap_token' => $snapToken,
                    'seller_id' => $sellerId,
                    'seller_name' => optional(optional($items[0])->product->user)->name,
                    'items' => collect($items)->map(function ($it) use ($overrideQtys) {
                        $usedQty = $overrideQtys[$it->id] ?? $it->qty;
                        return [
                            'product_id' => $it->product_id,
                            'name' => $it->product->name ?? 'Produk',
                            'qty' => $usedQty,
                            'price' => $it->product->price ?? 0,
                            'image_url' => $it->product->image ? \Illuminate\Support\Facades\Storage::url($it->product->image) : null,
                        ];
                    })->values(),
                    'total' => $finalTotal,
                    'subtotal' => $groupTotal,
                    'discount_amount' => $discountAmount,
                    'voucher_code' => $discountAmount > 0 && $voucher ? $voucher->code : null,
                    'status' => $transaction->status,
                ];
            }

            // Jika request meminta untuk mempertahankan item di keranjang (mis. untuk testing/dry-run),
            // maka jangan hapus cart items. Default: hapus.
            $preserve = $request->boolean('preserve_cart', false);
            if (!$preserve) {
                CartItem::whereIn('id', $selectedCartItemIds)->delete();
            }

            DB::commit();

            return response()->json([
                'message' => 'Checkout success',
                'transactions' => $responseTransactions,
                'snap_token' => $responseTransactions[0]['snap_token'] ?? null,
                'transaction' => $responseTransactions[0]['transaction'] ?? null,
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

            // === KIRIM NOTIFIKASI EMAIL KE PENJUAL ===
            if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                try {
                    $transaction->load(['items.product.user']);
                    $firstItem = $transaction->items->first();
                    $seller = $firstItem->product->user ?? null;

                    if ($seller && $seller->email) {
                        Mail::to($seller->email)->send(new OrderNotificationMail($transaction, $seller, true));
                        Log::info("Email Notification sent to seller (Paid): {$seller->name} ({$seller->email})");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send Email notification for paid order: " . $e->getMessage());
                }

                // === NOTIFIKASI WHATSAPP KE PENJUAL (PEMBAYARAN DITERIMA) ===
                try {
                    $wa = new WhatsAppService();
                    $transaction->load(['items.product.user', 'user']);
                    $firstItem = $firstItem ?? $transaction->items->first();
                    $seller = $seller ?? ($firstItem->product->user ?? null);
                    $buyer = $transaction->user;

                    if ($seller && $seller->phone && $wa->isEnabled()) {
                        $wa->notifySellerPaymentReceived(
                            $seller->phone,
                            $buyer->name ?? 'Pembeli',
                            $transaction->order_id,
                            $transaction->total_price
                        );
                        Log::info("WhatsApp payment notification sent to seller: {$seller->name}");
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to send WhatsApp payment notification: " . $e->getMessage());
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

        // === NOTIFIKASI WHATSAPP SAAT STATUS BERUBAH ===
        try {
            $wa = new WhatsAppService();
            if ($wa->isEnabled()) {
                $transaction->load(['items.product.user', 'user']);
                $buyer = $transaction->user;
                $firstItem = $transaction->items->first();
                $seller = $firstItem?->product?->user;

                // Notif ke buyer saat pesanan dikirim
                if ($request->status === 'shipping' && $oldStatus !== 'shipping' && $buyer && $buyer->phone) {
                    $wa->notifyBuyerOrderShipped(
                        $buyer->phone,
                        $transaction->order_id,
                        $seller->name ?? 'Penjual'
                    );
                    Log::info("WhatsApp shipping notification sent to buyer: {$buyer->name}");
                }

                // Notif ke buyer saat pesanan sampai
                if ($request->status === 'delivered' && $oldStatus !== 'delivered' && $buyer && $buyer->phone) {
                    $wa->notifyBuyerOrderDelivered(
                        $buyer->phone,
                        $transaction->order_id
                    );
                    Log::info("WhatsApp delivered notification sent to buyer: {$buyer->name}");
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp status notification: " . $e->getMessage());
        }

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

        // === NOTIFIKASI WHATSAPP KE SELLER (RETURN REQUEST) ===
        try {
            $wa = new WhatsAppService();
            if ($wa->isEnabled()) {
                $transaction->load(['items.product.user']);
                $firstItem = $transaction->items->first();
                $seller = $firstItem?->product?->user;

                if ($seller && $seller->phone) {
                    $wa->notifySellerReturnRequested(
                        $seller->phone,
                        $user->name,
                        $transaction->order_id
                    );
                    Log::info("WhatsApp return request notification sent to seller: {$seller->name}");
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp return notification: " . $e->getMessage());
        }

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

        // === NOTIFIKASI WHATSAPP KE BUYER (RETURN APPROVED) ===
        try {
            $wa = new WhatsAppService();
            if ($wa->isEnabled()) {
                $transaction->load('user');
                $buyer = $transaction->user;

                if ($buyer && $buyer->phone) {
                    $wa->notifyBuyerReturnApproved(
                        $buyer->phone,
                        $transaction->order_id
                    );
                    Log::info("WhatsApp return approved notification sent to buyer: {$buyer->name}");
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp return approved notification: " . $e->getMessage());
        }

        return response()->json(['message' => 'Pengembalian disetujui', 'transaction' => $transaction]);
    }

    public function getUnreadOrdersCount()
    {
        $seller = Auth::user();
        $productIds = \App\Models\Product::where('user_id', $seller->id)->pluck('id');

        $count = Transaction::whereHas('items', function ($q) use ($productIds) {
            $q->whereIn('product_id', $productIds);
        })
            ->whereIn('status', ['paid', 'processing']) // New orders are usually paid or started processing
            ->whereNull('seller_read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markOrdersAsRead()
    {
        $seller = Auth::user();
        $productIds = \App\Models\Product::where('user_id', $seller->id)->pluck('id');

        Transaction::whereHas('items', function ($q) use ($productIds) {
            $q->whereIn('product_id', $productIds);
        })
            ->whereNull('seller_read_at')
            ->update(['seller_read_at' => now()]);

        return response()->json(['message' => 'Orders marked as read']);
    }
}

