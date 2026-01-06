<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - UNIFIED (ADMIN + USER)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Redirect /admin/login ke /login untuk kompatibilitas
Route::get('/admin/login', function () {
    return redirect('/login');
});

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTES UNTUK USER (BUTUH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile (Vue page)
   Route::middleware('auth')->get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Tambahkan: route untuk update profil via web (aksi edit profil)
    Route::middleware('auth')->post('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

    // Produk
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show']);

    // Cart (Vue page)
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');
    Route::post('/cart/add/{product_id}', [CartController::class, 'add']);
    Route::post('/cart/remove/{item_id}', [CartController::class, 'remove']);

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/api/transactions', [TransactionController::class, 'index']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);
    
    // Orders (Vue page)
    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');
    
    // Open Shop (Vue page)
    Route::get('/open-shop', function () {
        return view('open-shop');
    })->name('open-shop');
    
    // Checkout (Vue page)
    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');
    
    // Order Confirmation (Vue page)
    Route::get('/order-confirmation', function () {
        return view('order-confirmation');
    })->name('order-confirmation');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES - PROTECTED BY ADMIN MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\Admin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin-dashboard');
    })->name('admin.dashboard');

    // Halaman profil admin
    Route::get('/profile', function () {
        return view('admin-profile');
    })->name('admin.profile');

    // Halaman produk admin (SPA Vue)
    Route::get('/products', function () {
        return view('admin-products');
    })->name('admin.products');

    // Halaman penjualan admin (SPA Vue)
    Route::get('/transactions', function () {
        return view('admin-sales');
    })->name('admin.sales');

    // Halaman pengguna admin (SPA Vue)
    Route::get('/users', function () {
        return view('admin-users');
    })->name('admin.users');
});

/*
|--------------------------------------------------------------------------
| API ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/

// Get all products
Route::get('/api/products', function () {
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

// Get single product
Route::get('/api/products/{id}', function ($id) {
    $product = \App\Models\Product::with('user:id,name')->find($id);

    if (!$product) {
        return response()->json(['message' => 'Not found'], 404);
    }

    $product->image_url = $product->image ? Storage::url($product->image) : null;
    $product->store_name = $product->user->name ?? 'Toko';

    return response()->json($product);
});

// Product detail page (public - bisa diakses tanpa login)
Route::get('/product/{id}', function ($id) {
    return view('product-detail');
});

// Route untuk serve file storage (fallback jika symbolic link tidak bekerja)
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    // Security: pastikan path tidak keluar dari storage/app/public
    $realPath = realpath($filePath);
    $storagePath = realpath(storage_path('app/public'));
    
    if (!$realPath || strpos($realPath, $storagePath) !== 0) {
        abort(404);
    }
    
    if (!file_exists($realPath) || !is_file($realPath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($realPath);
    return response()->file($realPath, [
        'Content-Type' => $mimeType,
    ]);
})->where('path', '.*');

/*
|--------------------------------------------------------------------------
| API ROUTES — USER AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/api/user', function() {
        // Get current authenticated user
        $user = Auth::user();
        $userData = $user ? json_decode(json_encode($user), true) : [];
        
        // Generate photo_url (timestamp akan ditambahkan di frontend untuk cache busting)
        if ($user) {
            $userData['photo_url'] = $user->photo ? Storage::url($user->photo) : null;
        }
        
        return response()->json($userData);
    });

    // Profile API (dipanggil dari frontend Vue)
    Route::get('/api/profile', [ProfileController::class, 'show']);
    Route::post('/api/profile', [ProfileController::class, 'update']);

    // Admin API endpoints
    Route::get('/api/admin/users', function () {
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
                'status' => $u->id === $currentId ? 'online' : 'offline',
                'products_count' => $u->products_count ?? 0,
                'is_current' => $u->id === $currentId,
            ];
        });

        return response()->json($users);
    });

    Route::post('/api/admin/users', function (Request $request) {
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

    Route::post('/api/admin/users/{id}', function (Request $request, $id) {
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

    Route::delete('/api/admin/users/{id}', function ($id) {
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

    Route::get('/api/admin/transactions', function () {
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

    // Cleanup orphaned transaction items (items yang produknya sudah dihapus)
    Route::post('/api/admin/cleanup-orphaned-items', function () {
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

    // Produk milik user
    Route::get('/api/my-products', function () {
        $products = \App\Models\Product::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'price' => $p->price,
                'stock' => $p->stock,
                'image_url' => $p->image ? Storage::url($p->image) : null,
                'category' => $p->category ? ['id' => $p->category->id, 'name' => $p->category->name] : null,
            ]);

        return response()->json($products);
    });

    // CRUD Produk (API)
    Route::post('/api/products', [ProductController::class, 'store']);
    Route::post('/api/products/{product}', [ProductController::class, 'update']);
    Route::delete('/api/products/{product}', [ProductController::class, 'destroy']);

    // Cart API
    Route::post('/api/cart/add', [CartController::class, 'apiAdd']);
    Route::get('/api/cart/count', [CartController::class, 'count']);
});

/*
|--------------------------------------------------------------------------
| API — CART MANUAL
|--------------------------------------------------------------------------
*/
Route::post('/api/cart/add', function (Request $request) {
    if (!Auth::check()) return response()->json(['message' => 'Unauthenticated'], 401);

    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $cart = \App\Models\Cart::firstOrCreate(['user_id' => Auth::id()]);

    $item = \App\Models\CartItem::firstOrCreate(
        ['cart_id' => $cart->id, 'product_id' => $validated['product_id']],
        ['qty' => 0]
    );

    $item->qty += $validated['quantity'];
    $item->save();

    return response()->json(['message' => 'Added to cart']);
});

Route::post('/api/cart/remove/{item_id}', function ($item_id) {
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

Route::get('/api/cart', function () {
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
                    'image_url' => $item->product->image ? Storage::url($item->product->image) : null,
                    'user' => $item->product->user ?? null,
                ],
            ];
        });

    return response()->json(['items' => $items]);
});

Route::get('/api/cart/count', function () {
    if (!Auth::check()) return response()->json(['count' => 0]);

    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    if (!$cart) return response()->json(['count' => 0]);

    $count = \App\Models\CartItem::where('cart_id', $cart->id)->sum('qty');
    return response()->json(['count' => $count]);
});

// Checkout API (menggunakan session auth)
Route::post('/api/checkout', [TransactionController::class, 'checkout'])->middleware('auth');

// Seller Orders API
Route::get('/api/seller/orders', [TransactionController::class, 'sellerOrders'])->middleware('auth');
Route::post('/api/seller/orders/{id}/update-status', [TransactionController::class, 'updateSellerOrderStatus'])->middleware('auth');

Route::post('/api/midtrans/notification', [TransactionController::class, 'notification']);
