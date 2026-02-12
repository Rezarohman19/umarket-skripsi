<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

// Get all products
Route::get('/products', function () {
    $products = \App\Models\Product::with('user:id,name')
        ->where('stock', '>', 0)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description,
            'category' => $p->category,
            'price' => $p->price,
            'stock' => $p->stock,
            'image_url' => $p->image ? Storage::url($p->image) : null,
            'user' => $p->user,
            'user_id' => $p->user_id,
            'store_name' => $p->user->name ?? 'Toko',
        ]);

    return response()->json($products);
});

// Get products by store (user_id)
Route::get('/store/{user_id}/products', function ($user_id) {
    $products = \App\Models\Product::with('user:id,name,phone')
        ->where('user_id', $user_id)
        ->where('stock', '>', 0)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description,
            'category' => $p->category,
            'price' => $p->price,
            'stock' => $p->stock,
            'image_url' => $p->image ? Storage::url($p->image) : null,
            'user' => $p->user,
            'user_id' => $p->user_id,
            'store_name' => $p->user->name ?? 'Toko',
        ]);

    return response()->json($products);
});

// Get store info (user info)
Route::get('/store/{user_id}', function ($user_id) {
    $user = \App\Models\User::select('id', 'name', 'phone', 'email', 'description', 'photo')
        ->find($user_id);

    if (!$user) {
        return response()->json(['message' => 'Store not found'], 404);
    }

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'phone' => $user->phone,
        'email' => $user->email,
        'description' => $user->description,
        'photo_url' => $user->photo ? Storage::url($user->photo) : null,
    ]);
});

// Get single product
Route::get('/products/{id}', function ($id) {
    $product = \App\Models\Product::with('user:id,name')->find($id);

    if (!$product) {
        return response()->json(['message' => 'Not found'], 404);
    }

    $product->image_url = $product->image ? Storage::url($product->image) : null;
    $product->store_name = $product->user->name ?? 'Toko';

    return response()->json($product);
});
/*
|--------------------------------------------------------------------------
| MIDTRANS WEBHOOK (PUBLIC - NO AUTH)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [TransactionController::class, 'notification']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER (SANCTUM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Admin API endpoints
    Route::get('/admin/users', function () {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $currentId = Auth::id();
        $users = \App\Models\User::withCount('products')->get()->map(function ($u) use ($currentId) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => $u->role,
                'status' => $u->last_seen_at && $u->last_seen_at > now()->subMinutes(5) ? 'online' : 'offline',
                'products_count' => $u->products_count ?? 0,
                'is_current' => $u->id === $currentId,
            ];
        });

        return response()->json($users);
    });

    Route::post('/admin/users', function (Request $request) {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'nullable|string',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'pengguna',
        ]);

        return response()->json($user, 201);
    });

    Route::post('/admin/users/{id}', function (Request $request, $id) {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'nullable|string',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'] ?? $user->role,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($updateData);

        return response()->json($user);
    });

    Route::delete('/admin/users/{id}', function ($id) {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (Auth::id() == $id) {
            return response()->json(['message' => 'Tidak dapat menghapus akun yang sedang digunakan'], 400);
        }

        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Pengguna berhasil dihapus']);
    });

    Route::get('/admin/transactions', function () {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $transactions = \App\Models\Transaction::with(['user', 'items'])->orderBy('created_at', 'desc')->get();
        return response()->json($transactions->map(fn($t) => [
            'id' => $t->id,
            'total' => $t->total_price,
            'status' => $t->status,
            'user' => $t->user,
            'products_sold' => $t->items->sum('qty'),
            'created_at' => $t->created_at,
        ]));
    });

    Route::get('/admin/sales-data', function (Request $request) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $days = (int) ($request->query('days', 30));
        $endDate = now()->endOfDay();
        $startDate = now()->subDays($days - 1)->startOfDay();

        // Ambil data penjualan X hari terakhir
        $sales = \App\Models\Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        // Buat range tanggal lengkap dan isi dengan 0 jika tidak ada data
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $date = now()->subDays($days - 1 - $i)->format('Y-m-d');
            $data[] = [
                'date' => $date,
                'total' => $sales->get($date, 0)
            ];
        }

        return response()->json($data);
    });

    Route::get('/admin/popular-products', function () {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $products = \App\Models\Product::withSum(['transactionItems' => function($query) {
            $query->whereHas('transaction', function($q) {
                $q->whereIn('status', ['paid', 'shipping', 'delivered']);
            });
        }], 'qty')
        ->orderByDesc('transaction_items_sum_qty')
        ->take(10)
        ->get()
        ->map(function ($p) {
            $p->image_url = $p->image ? Storage::url($p->image) : null;
            return $p;
        });

        return response()->json($products);
    });


    // Cleanup orphaned transaction items (items yang produknya sudah dihapus)
    Route::post('/admin/cleanup-orphaned-items', function () {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Cari transaction_items yang product_id-nya tidak ada di tabel products
        // Menggunakan left join untuk menemukan orphaned records
        $orphanedItems = \App\Models\TransactionItem::leftJoin('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereNull('products.id')
            ->select('transaction_items.*')
            ->get();

        $count = $orphanedItems->count();

        if ($count === 0) {
            return response()->json([
                'message' => 'Tidak ada transaction_items yang perlu dihapus',
                'deleted_count' => 0
            ]);
        }

        $ids = $orphanedItems->pluck('id')->toArray();
        $deleted = \App\Models\TransactionItem::whereIn('id', $ids)->delete();

        return response()->json([
            'message' => 'Cleanup berhasil',
            'deleted_count' => $deleted,
            'found_count' => $count
        ]);
    });

    Route::post('/cart/add', function (Request $request) {
    if (!Auth::check()) return response()->json(['message' => 'Unauthenticated'], 401);

    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $cart = \App\Models\Cart::firstOrCreate(['user_id' => Auth::id()]);

    $product = \App\Models\Product::find($validated['product_id']);
    if (!$product) {
        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }

    $item = \App\Models\CartItem::firstOrCreate(
        ['cart_id' => $cart->id, 'product_id' => $validated['product_id']],
        ['qty' => 0]
    );

    $currentQty = $item->qty;
    $newQty = $currentQty + $validated['quantity'];

    if ($newQty > $product->stock) {
        return response()->json([
            'message' => 'Stok tidak mencukupi. Sisa stok: ' . $product->stock . '. Anda sudah punya ' . $currentQty . ' di keranjang.'
        ], 422);
    }

    $item->qty = $newQty;
    $item->save();

    return response()->json(['message' => 'Added to cart']);
});

Route::post('/cart/remove/{item_id}', function ($item_id) {
    if (!Auth::check()) return response()->json(['message' => 'Unauthenticated'], 401);

    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    if (!$cart) return response()->json(['message' => 'Cart not found'], 404);

    $item = \App\Models\CartItem::where('cart_id', $cart->id)
        ->where('id', $item_id)
        ->first();

    if (!$item) return response()->json(['message' => 'Item not found'], 404);

    $item->delete();

    return response()->json(['message' => 'Item removed from cart']);
});

Route::get('/cart', function () {
    if (!Auth::check()) return response()->json(['items' => []], 401);

    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    if (!$cart) return response()->json(['items' => []]);

    $items = \App\Models\CartItem::with(['product.user'])
        ->where('cart_id', $cart->id)
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'quantity' => $item->qty,
                'price' => $item->product->price ?? 0,
                'store_name' => $item->product->user->name ?? 'Toko',
                'product' => [
                    'id' => $item->product->id ?? null,
                    'name' => $item->product->name ?? 'Produk',
                    'description' => $item->product->description ?? '',
                    'price' => $item->product->price ?? 0,
                    'stock' => $item->product->stock ?? 0,
                    'image_url' => $item->product->image ? Storage::url($item->product->image) : null,
                    'user' => $item->product->user ?? null,
                ],
            ];
        });

    return response()->json(['items' => $items]);
});

Route::get('/cart/count', function () {
    if (!Auth::check()) return response()->json(['count' => 0]);

    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    if (!$cart) return response()->json(['count' => 0]);

    // Hitung jumlah item (per produk)
    $count = \App\Models\CartItem::where('cart_id', $cart->id)->count();

    return response()->json(['count' => $count]);
});

Route::post('/cart/update', function (Request $request) {
    if (!Auth::check()) return response()->json(['message' => 'Unauthenticated'], 401);

    $validated = $request->validate([
        'item_id' => 'required|integer',
        'qty' => 'required|integer|min:1',
    ]);

    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    if (!$cart) return response()->json(['message' => 'Cart not found'], 404);

    $item = \App\Models\CartItem::with('product')
        ->where('cart_id', $cart->id)
        ->where('id', $validated['item_id'])
        ->first();

    if (!$item) return response()->json(['message' => 'Item not found'], 404);

    $stock = $item->product->stock ?? 0;
    if ($validated['qty'] > $stock) {
        return response()->json(['message' => 'Stock tidak mencukupi', 'stock' => $stock], 422);
    }

    $item->qty = $validated['qty'];
    $item->save();

    return response()->json([
        'message' => 'Item updated',
        'item' => [
            'id' => $item->id,
            'product_id' => $item->product_id,
            'qty' => $item->qty,
        ]
    ]);
});

    // Checkout API (menggunakan session auth)
Route::post('/checkout', [TransactionController::class, 'checkout'])->middleware('auth');

// Seller Orders API
Route::get('/seller/orders', [TransactionController::class, 'sellerOrders'])->middleware('auth');
Route::post('/seller/orders/{id}/update-status', [TransactionController::class, 'updateSellerOrderStatus'])->middleware('auth');

// Buyer Orders API - Update status to delivered
Route::post('/transactions/{id}/mark-delivered', function (Request $request, $id) {
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    $transaction = \App\Models\Transaction::findOrFail($id);

    // Validasi: hanya pembeli yang bisa update status menjadi delivered
    if ($transaction->user_id !== Auth::id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Validasi: hanya bisa update jika status adalah shipping
    if ($transaction->status !== 'shipping') {
        return response()->json(['message' => 'Hanya pesanan yang sedang dikirim yang bisa ditandai diterima'], 400);
    }

    $transaction->status = 'delivered';
    $transaction->save();

    return response()->json([
        'message' => 'Pesanan berhasil ditandai diterima',
        'transaction' => $transaction
    ]);
})->middleware('auth');

// Return Request API
Route::post('/transactions/{id}/request-return', [TransactionController::class, 'requestReturn'])->middleware('auth');
Route::post('/seller/orders/{id}/approve-return', [TransactionController::class, 'approveReturn'])->middleware('auth');


});