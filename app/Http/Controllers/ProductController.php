<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(
            Product::with('user')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
            // Foto produk wajib saat tambah produk baru
            'image'       => 'required|image|max:5120',
        ]);

        // Kategori sekarang wajib, auto-create jika belum ada
        $catName = trim($request->input('category'));
        $categoryId = null;
        if ($catName) {
            $category = Category::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName)]
            );
            $categoryId = $category->id;
        }
        
        // Unset string category, set category_id
        unset($validated['category']);
        $validated['category_id'] = $categoryId;

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $validated['user_id'] = Auth::id();

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Produk berhasil disimpan',
            'product' => $product
        ], 201);
    }

    public function show($id)
    {
        return response()->json(
            Product::with('user')->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'category'    => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',
            // Foto produk opsional saat update (jika tidak diubah, pakai yang lama)
            'image'       => 'nullable|image|max:5120',
        ]);

        // Jika ada input kategori, auto-create jika belum ada
        if ($request->filled('category')) {
            $catName = trim($request->input('category'));
            if ($catName) {
                $category = Category::firstOrCreate(
                    ['name' => $catName],
                    ['slug' => Str::slug($catName)]
                );
                $validated['category_id'] = $category->id;
            }
        }
        
        // Unset string category
        unset($validated['category']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Product deleted'
        ]);
    }
}
