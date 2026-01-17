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
use Midtrans\Config;
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
            // Hapus transaction items dulu
            \App\Models\TransactionItem::where('transaction_id', $transaction->id)->delete();
            // Hapus transaction
            $transaction->delete();
        }

        // Ambil semua transaksi user yang belum dihapus
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Load items dan relasi produknya
        // Menggunakan withDefault() pada relasi product di model TransactionItem lebih baik, 
        // tapi kita handle di sini dengan membiarkan product null jika terhapus.
        $transactions->load([
            'items.product' => function($query) {
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

            $totalPrice = 0;
            $itemDetails = [];

            foreach ($cartItems as $item) {
                $subtotal = $item->product->price * $item->qty;
                $totalPrice += $subtotal;

                $itemDetails[] = [
                    'id' => $item->product->id,
                    'price' => $item->product->price,
                    'quantity' => $item->qty,
                    'name' => $item->product->name,
                ];
            }

            // Ambil shipping address dari request jika ada
            $shippingAddress = $request->input('shipping_address', []);
            
            // Buat transaksi (PENDING)
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => 'midtrans',
                'shipping_name' => $shippingAddress['name'] ?? $user->name,
                'shipping_phone' => $shippingAddress['phone'] ?? $user->phone,
                'shipping_address' => $shippingAddress['address'] ?? $user->address,
            ]);

            foreach ($cartItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price,
                ]);
            }

            // =====================
            // MIDTRANS SNAP
            // =====================
            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $transaction->id . '-' . time(),
                    'gross_amount' => $totalPrice,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            // If enabled_payments configured, forward to Midtrans to limit displayed methods
            $enabledPayments = config('midtrans.enabled_payments');
            if ($enabledPayments && is_array($enabledPayments)) {
                $params['enabled_payments'] = $enabledPayments;
            }

            // Initialize Midtrans configuration from config/midtrans.php
            Config::$serverKey = config('midtrans.server_key');
            Config::$clientKey = config('midtrans.client_key');
            Config::$isProduction = config('midtrans.is_production') ? true : false;
            Config::$isSanitized = config('midtrans.is_sanitized') ?? true;
            Config::$is3ds = config('midtrans.is_3ds') ?? true;

            // If running in tests, avoid calling external Midtrans SDK
            if (app()->runningUnitTests() || app()->environment('testing')) {
                $snapToken = 'test-snap-token';
            } else {
                $snapToken = Snap::getSnapToken($params);
            }

            $transaction->snap_token = $snapToken;
            $transaction->save();

            // Hapus hanya cart items yang sudah di-checkout (yang dipilih user)
            CartItem::whereIn('id', $selectedCartItemIds)->delete();

            DB::commit();

            return response()->json([
                'message' => 'Checkout success',
                'snap_token' => $snapToken,
                'transaction' => $transaction
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
    Log::info('MIDTRANS NOTIFICATION MASUK', $request->all());

    // Inisialisasi Config agar Notification SDK bekerja
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');

    try {
        $notif = new Notification();
        $orderId = $notif->order_id; // "ORDER-17-17368291"
        $status  = $notif->transaction_status;

        // --- PROSES AMBIL ID ASLI ---
        // Pecah string berdasarkan tanda "-"
        $parts = explode('-', $orderId);
        
        // Ambil bagian index ke-1 (ini adalah angka ID transaksi Anda)
        $transactionId = isset($parts[1]) ? $parts[1] : null;

        if (!$transactionId) {
            Log::error('Format Order ID salah: ' . $orderId);
            return response()->json(['message' => 'Invalid ID format'], 400);
        }

        // Cari transaksi berdasarkan ID yang sudah bersih (angka saja)
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            Log::warning('Transaksi tidak ditemukan di database', ['id_mencari' => $transactionId]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // --- UPDATE STATUS ---
        if (in_array($status, ['capture', 'settlement'])) {
            $transaction->status = 'paid';
        } elseif ($status === 'pending') {
            $transaction->status = 'pending';
        } elseif (in_array($status, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        }

        $transaction->save();
        Log::info('STATUS UPDATE BERHASIL', ['id' => $transactionId, 'status' => $transaction->status]);

        return response()->json(['message' => 'OK'], 200);

    } catch (\Exception $e) {
        Log::error('ERROR NOTIFICATION: ' . $e->getMessage());
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

        // Hapus transaction items dulu
        \App\Models\TransactionItem::where('transaction_id', $transaction->id)->delete();
        // Hapus transaction
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
        $transaction->status = $request->status;
        $transaction->save();

        return response()->json([
            'message' => 'Status updated',
            'transaction' => $transaction
        ]);
    }
}
