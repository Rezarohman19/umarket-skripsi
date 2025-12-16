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
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/login', function () {
    return view('admin-login');
})->name('admin.login');

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
    Route::middleware('auth')->post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

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
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin-dashboard');
    })->name('admin.dashboard');
    
    Route::resource('/products', ProductController::class);
    Route::get('/transactions', [TransactionController::class, 'adminIndex']);
    Route::get('/users', [ProfileController::class, 'listUsers']);
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

/*
|--------------------------------------------------------------------------
| API ROUTES — USER AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/api/user', function() {
        $user = Auth::user();
        $userData = $user->toArray();
        $userData['photo_url'] = $user->photo ? Storage::url($user->photo) : null;
        return response()->json($userData);
    });

    // Profile API (dipanggil dari frontend Vue)
    Route::get('/api/profile', [ProfileController::class, 'show']);
    Route::post('/api/profile', [ProfileController::class, 'update']);

    // Admin API endpoints
    Route::get('/api/admin/users', function () {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json(\App\Models\User::all());
    });

    Route::get('/api/admin/transactions', function () {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $transactions = \App\Models\Transaction::with('user')->get();
        return response()->json($transactions->map(fn($t) => [
            'id' => $t->id,
            'total' => $t->total_price,
            'status' => $t->status,
            'user' => $t->user,
        ]));
    });

    // Produk milik user
    Route::get('/api/my-products', function () {
        $products = \App\Models\Product::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'price' => $p->price,
                'stock' => $p->stock,
                'image_url' => $p->image ? Storage::url($p->image) : null,
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
