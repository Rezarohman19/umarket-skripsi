<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // tampilkan keranjang user
   public function index(Request $request)
{
    $cart = Cart::with('items.product')
        ->where('user_id', $request->user()->id)
        ->first();

    return response()->json([
        'items' => $cart ? $cart->items : []
    ]);
}


    // tambah ke keranjang
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => $request->user()->id
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->qty += $request->qty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'qty' => $request->qty
            ]);
        }

        return response()->json([
            'message' => 'Product added to cart'
        ]);
    }
}
