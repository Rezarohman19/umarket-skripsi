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
            'image'       => 'nullable|image|max:5120',
            'image_2'     => 'nullable|image|max:5120',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:5120',
            'availability'=> 'required|in:available,pre-order',
        ]);

        $hasAnyImage = $request->hasFile('image') || $request->hasFile('image_2') || $request->hasFile('images');
        if (!$hasAnyImage) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'images' => ['Minimal upload 1 foto produk.'],
                ],
            ], 422);
        }

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

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }
        if ($request->hasFile('image_2')) {
            $path2 = $request->file('image_2')->store('products', 'public');
            $validated['image_2'] = $path2;
        }

        $validated['user_id'] = Auth::id();

        $product = Product::create($validated);
        $this->syncProductImages($request, $product, false);
        $product->refresh();

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
            'image'       => 'nullable|image|max:5120',
            'image_2'     => 'nullable|image|max:5120',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:5120',
            'availability'=> 'required|in:available,pre-order',
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
        if ($request->hasFile('image_2')) {
            $path2 = $request->file('image_2')->store('products', 'public');
            $validated['image_2'] = $path2;
        }

        $product->update($validated);
        $this->syncProductImages($request, $product, true);
        $product->refresh();

        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Product deleted'
        ]);
    }

    private function syncProductImages(Request $request, Product $product, bool $isUpdate): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        if ($isUpdate) {
            foreach ($product->productImages as $oldImage) {
                Storage::disk('public')->delete($oldImage->path);
            }
            $product->productImages()->delete();
        }

        $savedPaths = [];
        foreach ($request->file('images', []) as $index => $file) {
            $path = $file->store('products', 'public');
            $savedPaths[] = $path;
            $product->productImages()->create([
                'path' => $path,
                'sort_order' => $index,
            ]);
        }

        if (!empty($savedPaths)) {
            $product->image = $savedPaths[0] ?? $product->image;
            $product->image_2 = $savedPaths[1] ?? null;
            $product->save();
        }
    }
}
