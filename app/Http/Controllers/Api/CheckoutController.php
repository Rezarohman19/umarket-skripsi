<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();

        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Cart kosong'
            ], 400);
        }

        $total = 0;
        foreach ($cart->items as $item) {
            $total += $item->qty * $item->product->price;
        }

        // Buat transaksi
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_price' => $total,
            'status' => 'pending'
        ]);

        // Simpan item transaksi
        foreach ($cart->items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->product->price
            ]);
        }

        // Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $total
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'message' => 'Checkout berhasil',
            'snap_token' => $snapToken,
            'transaction_id' => $transaction->id
        ]);
    }
}
