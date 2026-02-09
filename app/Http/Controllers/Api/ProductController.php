<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // API daftar produk
    public function index()
    {
        $products = Product::with('user')->latest()->get();

        return response()->json([
            'message' => 'Product list retrieved successfully',
            'data' => $products
        ]);
    }

    // API detail produk
    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);

        return response()->json([
            'message' => 'Product detail retrieved successfully',
            'data' => $product
        ]);
    }

    public function search(Request $request)
{
    $query = \App\Models\Product::query();

    // DEBUG: lihat param masuk
    // dd($request->query());

    if ($request->has('name')) {
        $query->where('name', 'LIKE', '%' . trim($request->query('name')) . '%');
    }

    if ($request->has('category')) {
        $query->where('category_id', trim((string) $request->query('category')));
    }

    return response()->json([
        'query_param' => $request->query(),
        'data' => $query->get()
    ]);
}

}
