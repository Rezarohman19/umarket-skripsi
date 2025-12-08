<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

<<<<<<< HEAD
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Halaman login & register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Routes untuk Pengguna yang sudah login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard berdasarkan role
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    /*
    |--------------------------------------------------------------------------
    | Produk (User hanya bisa lihat)
    |--------------------------------------------------------------------------
    */
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | Cart Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{product_id}', [CartController::class, 'add']);
    Route::post('/cart/remove/{item_id}', [CartController::class, 'remove']);

    /*
    |--------------------------------------------------------------------------
    | Transactions Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);
});

=======
// Landing page - Halaman utama untuk role pengguna (bisa diakses tanpa login)
Route::get('/', function () {
    // Jika admin sudah login, redirect ke dashboard
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect('/dashboard');
    }
    return view('landing');
});

// Login page - Frontend only, tidak mengubah backend
Route::get('/login', function () {
    // Jika sudah login, redirect berdasarkan role
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/dashboard');
        } else {
            return redirect('/');
        }
    }
    return view('login');
})->name('login');
>>>>>>> b767d72ace30c1e275eb6ee93cda34db91678434

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

<<<<<<< HEAD
    // Dashboard admin
    Route::get('/admin/dashboard', [ProductController::class, 'adminIndex'])
        ->name('admin.dashboard');
=======
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        
        // Redirect berdasarkan role
        if (Auth::user()->role === 'admin') {
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->intended('/');
        }
    }
>>>>>>> b767d72ace30c1e275eb6ee93cda34db91678434

    // CRUD Produk
    Route::resource('/admin/products', ProductController::class);

    // Lihat daftar transaksi
    Route::get('/admin/transactions', [TransactionController::class, 'adminIndex']);

    // Manage Users
    Route::get('/admin/users', [ProfileController::class, 'listUsers']);
});
<<<<<<< HEAD
=======

// Register page - Frontend only, tidak mengubah backend
Route::get('/register', function () {
    // Jika sudah login, redirect ke dashboard atau home
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('register');
})->name('register');

// Register route - Form submission tradisional Laravel (langsung ke database)
Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Buat user baru dengan role default 'pengguna'
    // Note: Password akan otomatis di-hash oleh User model (casts: 'password' => 'hashed')
    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'], // Tidak perlu bcrypt(), model sudah handle
        'role' => 'pengguna',
    ]);

    // Redirect ke halaman login dengan pesan sukses
    return redirect('/login?registered=success');
});

// Orders page - membutuhkan login
Route::get('/orders', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('orders');
})->name('orders');

// Open Shop page - membutuhkan login
Route::get('/open-shop', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('open-shop');
})->name('open-shop');

// Cart page - membutuhkan login
Route::get('/cart', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('cart');
})->name('cart');

// Profile page - membutuhkan login
Route::get('/profile', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('profile');
})->name('profile');

// Dashboard - sementara menggunakan blade, nanti bisa diganti dengan halaman dashboard Vue.js
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    return view('dashboard');
})->name('dashboard');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Route untuk logout via GET (untuk memudahkan testing)
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// API Routes untuk Landing Page
Route::get('/api/products', function () {
    $products = \App\Models\Product::with('user:id,name')
        ->where('stock', '>', 0)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($p) {
            $p->image_url = $p->image ? Storage::url($p->image) : null;
            return $p;
        });

    return response()->json($products);
});

Route::get('/api/user', function () {
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    
    return response()->json(Auth::user());
});

// Produk milik penjual (auth)
Route::middleware('auth')->group(function () {
    Route::get('/api/my-products', function () {
        $products = \App\Models\Product::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($p) {
                $p->image_url = $p->image ? Storage::url($p->image) : null;
                return $p;
            });

        return response()->json($products);
    });

    Route::post('/api/products', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = \App\Models\Product::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['category'] ?? '',
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        $product->image_url = $imagePath ? Storage::url($imagePath) : null;

        return response()->json($product, 201);
    });

    Route::post('/api/products/{product}', function (Request $request, \App\Models\Product $product) {
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);

        // Handle image
        if (!empty($validated['remove_image'])) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['category'] ?? '',
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        $product->image_url = $product->image ? Storage::url($product->image) : null;

        return response()->json($product);
    });

    Route::delete('/api/products/{product}', function (\App\Models\Product $product) {
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Deleted']);
    });
});

Route::post('/api/cart/add', function (Request $request) {
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);
    
    $product = \App\Models\Product::findOrFail($validated['product_id']);
    
    if ($product->stock < $validated['quantity']) {
        return response()->json(['message' => 'Stok tidak mencukupi'], 400);
    }
    
    // Cek apakah user sudah punya cart
    $cart = \App\Models\Cart::firstOrCreate([
        'user_id' => Auth::id()
    ]);
    
    // Cek apakah product sudah ada di cart
    $cartItem = \App\Models\CartItem::where('cart_id', $cart->id)
        ->where('product_id', $validated['product_id'])
        ->first();
    
    if ($cartItem) {
        $cartItem->qty += $validated['quantity'];
        $cartItem->save();
    } else {
        \App\Models\CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $validated['product_id'],
            'qty' => $validated['quantity'],
        ]);
    }
    
    return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
});

Route::get('/api/cart/count', function () {
    if (!Auth::check()) {
        return response()->json(['count' => 0]);
    }
    
    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    
    if (!$cart) {
        return response()->json(['count' => 0]);
    }
    
    $count = \App\Models\CartItem::where('cart_id', $cart->id)->sum('qty');
    
    return response()->json(['count' => $count]);
});
>>>>>>> b767d72ace30c1e275eb6ee93cda34db91678434
