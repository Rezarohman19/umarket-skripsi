<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cart_id'    => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1'
        ]);

        $item = CartItem::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);

        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $item->update($request->all());
        return response()->json($item);
    }

    public function destroy($id)
    {
        CartItem::findOrFail($id)->delete();
        return response()->json(['message' => 'Cart item deleted']);
    }
}
