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

// Login route - Form submission
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        
        // Redirect berdasarkan role
        if (Auth::user()->role === 'admin') {
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->intended('/');
        }
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
});

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

// Product Detail page - bisa diakses tanpa login
Route::get('/product/{id}', function ($id) {
    return view('product-detail');
})->name('product.detail');

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

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard admin
    Route::get('/admin/dashboard', [ProductController::class, 'adminIndex'])
        ->name('admin.dashboard');

    // CRUD Produk
    Route::resource('/admin/products', ProductController::class);

    // Lihat daftar transaksi
    Route::get('/admin/transactions', [TransactionController::class, 'adminIndex']);

    // Manage Users
    Route::get('/admin/users', [ProfileController::class, 'listUsers']);
});

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

// Get single product detail
Route::get('/api/products/{id}', function ($id) {
    $product = \App\Models\Product::with('user:id,name')
        ->find($id);
    
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }
    
    $product->image_url = $product->image ? Storage::url($product->image) : null;
    $product->store_name = $product->user->name ?? 'Toko';
    $product->category = $product->description ?? '';
    
    return response()->json($product);
});

Route::get('/api/user', function () {
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    
    return response()->json(Auth::user());
});

// Update Profile (auth)
Route::post('/api/profile', function (Request $request) {
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        'address' => 'nullable|string',
        'password' => 'nullable|string|min:8',
        'photo' => 'nullable|image|max:2048',
        'remove_photo' => 'nullable|boolean',
    ]);

    $user = Auth::user();

    // Handle photo
    if ($request->boolean('remove_photo') && $user->photo) {
        Storage::disk('public')->delete($user->photo);
        $user->photo = null;
    }

    if ($request->hasFile('photo')) {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->photo = $request->file('photo')->store('profiles', 'public');
    }

    // Update user data
    $user->name = $validated['name'];
    $user->description = $validated['description'] ?? null;
    $user->phone = $validated['phone'] ?? null;
    $user->email = $validated['email'];
    $user->address = $validated['address'] ?? null;

    // Update password jika diisi
    if (!empty($validated['password'])) {
        $user->password = $validated['password']; // Model akan otomatis hash
    }

    $user->save();

    // Return updated user with photo_url
    $user->photo_url = $user->photo ? Storage::url($user->photo) : null;

    return response()->json(['message' => 'Profil berhasil diperbarui', 'user' => $user]);
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

        // Reload product untuk mendapatkan data terbaru
        $product->refresh();
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
        
        // Reload product untuk mendapatkan data terbaru
        $product->refresh();

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
        $cartItem = \App\Models\CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $validated['product_id'],
            'qty' => $validated['quantity'],
        ]);
    }
    
    // Return cart item dengan relasi untuk verifikasi
    $cartItem->load('product.user:id,name');
    
    return response()->json([
        'message' => 'Produk berhasil ditambahkan ke keranjang',
        'cart_item' => [
            'id' => $cartItem->id,
            'product_id' => $cartItem->product_id,
            'product_name' => $cartItem->product->name ?? 'Unknown',
            'qty' => $cartItem->qty,
        ]
    ]);
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

// Get cart items (auth)
Route::get('/api/cart', function () {
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    
    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    
    if (!$cart) {
        return response()->json(['items' => []]);
    }
    
    $items = \App\Models\CartItem::with('product.user:id,name')
        ->where('cart_id', $cart->id)
        ->get()
        ->map(function ($item) {
            if (!$item->product) {
                // Jika product tidak ditemukan, skip item ini
                return null;
            }
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name ?? 'Produk tidak ditemukan',
                'product_description' => $item->product->description ?? '',
                'price' => $item->product->price ?? 0,
                'qty' => $item->qty,
                'store_name' => $item->product->user->name ?? 'Toko',
                'image_url' => $item->product->image_url ?? null,
            ];
        })
        ->filter(); // Hapus null values
    
    return response()->json(['items' => $items]);
});

// Remove cart item (auth)
Route::delete('/api/cart/remove/{cartItem}', function (\App\Models\CartItem $cartItem) {
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    
    // Pastikan cart item milik user yang sedang login
    $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
    if (!$cart || $cartItem->cart_id !== $cart->id) {
        return response()->json(['message' => 'Forbidden'], 403);
    }
    
    $cartItem->delete();
    
    return response()->json(['message' => 'Item berhasil dihapus dari keranjang']);
});
