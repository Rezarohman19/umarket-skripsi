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
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect('/dashboard');
    }
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTES UNTUK USER (BUTUH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // Produk
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show']);

    // Cart (Blade)
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product_id}', [CartController::class, 'add']);
    Route::post('/cart/remove/{item_id}', [CartController::class, 'remove']);

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('/products', ProductController::class);
    Route::get('/transactions', [TransactionController::class, 'adminIndex']);
    Route::get('/users', [ProfileController::class, 'listUsers']);
});

/*
|--------------------------------------------------------------------------
| API ROUTES (PUBLIC & AUTH)
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
            'user' => $p->user
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

    return response()->json($product);
});

/*
|--------------------------------------------------------------------------
| API ROUTES — USER AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/api/user', fn() => response()->json(Auth::user()));

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
| API — CART (TANPA CONTROLLER)
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

Route::get('/api/cart/count', function () {
    if (!Auth::check()) return response()->json(['count' => 0]);

    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    if (!$cart) return response()->json(['count' => 0]);

    $count = \App\Models\CartItem::where('cart_id', $cart->id)->sum('qty');
    return response()->json(['count' => $count]);
});

