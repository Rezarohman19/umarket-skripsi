<?php

namespace App\Http\Controllers;

use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id'     => 'required|exists:products,id',
            'qty'            => 'required|integer|min:1',
            'price'          => 'required|numeric'
        ]);

        $item = TransactionItem::create($request->all());
        return response()->json($item, 201);
    }

    public function destroy($id)
    {
        TransactionItem::findOrFail($id)->delete();
        return response()->json(['message' => 'Transaction item deleted']);
    }
}
