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

        // Ambil semua transaksi user
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil semua product_id yang masih ada
        $existingProductIds = \App\Models\Product::pluck('id')->toArray();

        // Load items yang product_id-nya masih ada
        $transactions->load(['items' => function ($query) use ($existingProductIds) {
            if (!empty($existingProductIds)) {
                $query->whereIn('product_id', $existingProductIds);
            } else {
                // Jika tidak ada produk sama sekali, return empty
                $query->whereRaw('1 = 0');
            }
        }, 'items.product.user']);

        // Filter transactions yang masih punya items setelah filter
        $transactions = $transactions->filter(function ($transaction) {
            return $transaction->items->count() > 0;
        })->values();

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

            $cartItems = CartItem::with('product')
                ->where('cart_id', $cart->id)
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Cart is empty'], 400);
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

            // Buat transaksi (PENDING)
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => 'midtrans',
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
                    'order_id' => 'ORDER-' . $transaction->id,
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

            // Hapus cart
            CartItem::where('cart_id', $cart->id)->delete();

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
        $notif = new Notification();

        $orderId = $notif->order_id;
        $status = $notif->transaction_status;
        $paymentType = $notif->payment_type;

        $transactionId = str_replace('ORDER-', '', $orderId);
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if (in_array($status, ['capture', 'settlement'])) {
            $transaction->status = 'paid';
        } elseif ($status === 'pending') {
            $transaction->status = 'pending';
        } elseif (in_array($status, ['expire', 'cancel', 'deny'])) {
            $transaction->status = 'failed';
        }

        $transaction->payment_type = $paymentType;
        $transaction->save();

        return response()->json(['message' => 'Notification processed']);
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
