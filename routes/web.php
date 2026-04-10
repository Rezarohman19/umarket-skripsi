<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/terms-and-conditions', function () {
    return view('terms-and-conditions');
})->name('terms');

Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us');
Route::post('/contact-us', [ContactController::class, 'store']);

// Halaman toko (public)
Route::get('/store/{user_id}', function () {
    return view('store');
})->name('store');

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
| AUTH ROUTES - UNIFIED (ADMIN + USER)
|--------------------------------------------------------------------------
*/
// Login routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    
    // Redirect /admin/login ke /login untuk kompatibilitas
    Route::get('/admin/login', function () {
        return redirect('/login');
    });
});

// Logout route (authenticated users only)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| EMAIL VERIFICATION ROUTES (Session-based)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Halaman notice verifikasi
    Route::get('/email/verify', function () {
        return view('verify-email');
    })->name('verification.notice');

    // Link verifikasi email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        \Log::info('Verification request received for user: ' . $request->route('id'));
        try {
            $request->fulfill();
            \Log::info('Verification fulfilled successfully.');
        } catch (\Exception $e) {
            \Log::error('Verification failed: ' . $e->getMessage());
        }
        return redirect('/')->with('success', 'Email Anda telah terverifikasi.');
    })->middleware(['signed'])->name('verification.verify');

    // Resend verification email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Link verifikasi telah dikirim ulang.');
    })->middleware(['throttle:6,1'])->name('verification.send');

    // Dev-only: langsung verifikasi tanpa email (hanya environment local)
    Route::post('/email/verify/dev', function (Request $request) {
        if (config('app.env') !== 'local') {
            abort(403);
        }
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();
        }
        return redirect('/')->with('success', 'Email Anda telah terverifikasi (dev).');
    })->name('verification.dev');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER WEB PAGES (Session-based)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {



    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |---------- Shopping Pages ----------
    */
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');

    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');

    Route::get('/order-confirmation/{id?}', function ($id = null) {
        return view('order-confirmation');
    })->name('order-confirmation');

    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');

    /*
    |---------- Seller Pages ----------
    */
    Route::get('/open-shop', function () {
        return view('open-shop');
    })->name('open-shop');

});

/*
|--------------------------------------------------------------------------
| ADMIN WEB PAGES (Session-based, Protected by Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\Admin::class])->group(function () {
    
    /*
    |---------- Admin Pages ----------
    */
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin-dashboard');
        })->name('admin.dashboard');

        Route::get('/profile', function () {
            return view('admin-profile');
        })->name('admin.profile');

        Route::get('/products', function () {
            return view('admin-products');
        })->name('admin.products');

        Route::get('/transactions', function () {
            return view('admin-sales');
        })->name('admin.sales');

        Route::get('/users', function () {
            return view('admin-users');
        })->name('admin.users');
    });

});

/*
|--------------------------------------------------------------------------
| UNIFIED API ENDPOINTS (Moved to Web for Session Support)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    
    /* ---------- PUBLIC API ENDPOINTS ---------- */
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
                'image_urls' => $p->image_urls,
                'user' => $p->user,
                'user_id' => $p->user_id,
                'store_name' => $p->user->name ?? 'Toko',
            ]);
        return response()->json($products);
    });

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
                'image_urls' => $p->image_urls,
                'user' => $p->user,
                'user_id' => $p->user_id,
                'store_name' => $p->user->name ?? 'Toko',
            ]);
        return response()->json($products);
    });

    Route::get('/store/{user_id}', function ($user_id) {
        $user = \App\Models\User::select('id', 'name', 'phone', 'email', 'description', 'photo')
            ->find($user_id);
        if (!$user) return response()->json(['message' => 'Store not found'], 404);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'description' => $user->description,
            'photo_url' => $user->photo ? Storage::url($user->photo) : null,
        ]);
    });

    Route::get('/products/{id}', function ($id) {
        $product = \App\Models\Product::with('user:id,name')->find($id);
        if (!$product) return response()->json(['message' => 'Not found'], 404);
        $product->image_url = $product->image ? Storage::url($product->image) : null;
        $product->store_name = $product->user->name ?? 'Toko';
        return response()->json($product);
    });

    Route::post('/midtrans/notification', [TransactionController::class, 'notification']);

    /* ---------- AUTHENTICATION ---------- */
    Route::post('/auth/login', [AuthController::class, 'apiLogin']);
    Route::post('/auth/register', [AuthController::class, 'apiRegister']);
    
    Route::get('/auth/check', function () {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'photo_url' => $user->photo ? Storage::url($user->photo) : null,
                    'email_verified_at' => $user->email_verified_at,
                ]
            ]);
        }
        return response()->json(['authenticated' => false]);
    });

    /* ---------- PROTECTED API ROUTES ---------- */
    Route::middleware(['auth'])->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'apiLogout']);
        Route::get('/user', function () {
            $user = Auth::user();
            $userData = $user ? json_decode(json_encode($user), true) : [];
            if ($user) $userData['photo_url'] = $user->photo ? Storage::url($user->photo) : null;
            return response()->json($userData);
        });

        Route::get('/profile', [ProfileController::class, 'show']);
        Route::post('/profile', [ProfileController::class, 'update']);

        Route::get('/seller-balance', [ProfileController::class, 'getBalance']);
        Route::get('/user-banks', [ProfileController::class, 'getBanks']);
        Route::post('/user-banks', [ProfileController::class, 'addBank']);
        Route::delete('/user-banks/{id}', [ProfileController::class, 'deleteBank']);
        Route::get('/user-withdrawals', [ProfileController::class, 'getWithdrawals']);
        Route::post('/seller-withdraw', [ProfileController::class, 'withdraw']);

        // Cart
        Route::get('/cart', function () {
            $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
            if (!$cart) return response()->json(['items' => []]);
            $items = \App\Models\CartItem::with(['product', 'product.user'])->where('cart_id', $cart->id)->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'product' => $item->product ? [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'description' => $item->product->description,
                        'price' => (float) $item->product->price,
                        'stock' => $item->product->stock,
                        'image_url' => $item->product->image ? Storage::url($item->product->image) : null,
                        'user' => $item->product->user ? ['id' => $item->product->user->id, 'name' => $item->product->user->name] : null,
                    ] : null,
                ];
            });
            return response()->json(['items' => $items]);
        });
        Route::post('/cart/add', function (Request $request) {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);
            $cart = \App\Models\Cart::firstOrCreate(['user_id' => Auth::id()]);
            $product = \App\Models\Product::find($validated['product_id']);
            if (!$product) return response()->json(['message' => 'Produk tidak ditemukan'], 404);
            $item = \App\Models\CartItem::firstOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $validated['product_id']],
                ['qty' => 0]
            );
            $newQty = $item->qty + $validated['quantity'];
            if ($newQty > $product->stock) return response()->json(['message' => 'Stok tidak mencukupi'], 422);
            $item->qty = $newQty;
            $item->save();
            return response()->json(['message' => 'Added to cart']);
        });
        Route::post('/cart/remove/{item_id}', function ($item_id) {
            $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
            if (!$cart) return response()->json(['message' => 'Cart not found'], 404);
            
            // Pastikan item yang dihapus memang milik keranjang user ini
            $deleted = \App\Models\CartItem::where('cart_id', $cart->id)
                ->where('id', $item_id)
                ->delete();
                
            if ($deleted) {
                return response()->json(['message' => 'Item removed from cart']);
            }
            return response()->json(['message' => 'Item not found in your cart'], 404);
        });
        Route::get('/cart/count', function () {
            $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
            if (!$cart) return response()->json(['count' => 0]);
            $count = \App\Models\CartItem::where('cart_id', $cart->id)->count();
            return response()->json(['count' => $count]);
        });
        Route::post('/cart/update', function (Request $request) {
            $validated = $request->validate([
                'item_id' => 'required',
                'qty' => 'required|integer|min:1',
            ]);
            $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
            if (!$cart) return response()->json(['message' => 'Cart not found'], 404);
            
            $item = \App\Models\CartItem::with('product')
                ->where('cart_id', $cart->id)
                ->where('id', $validated['item_id'])
                ->first();
                
            if (!$item) return response()->json(['message' => 'Item not found in your cart'], 404);
            
            if ($item->product && $validated['qty'] > $item->product->stock) {
                return response()->json(['message' => 'Stok tidak mencukupi'], 422);
            }
            
            $item->qty = $validated['qty'];
            $item->save();
            return response()->json(['message' => 'Item updated']);
        });

        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::post('/checkout', [TransactionController::class, 'checkout']);
        
        Route::post('/transactions/{id}/mark-delivered', function (Request $request, $id) {
            $transaction = \App\Models\Transaction::findOrFail($id);
            if ($transaction->user_id !== Auth::id()) return response()->json(['message' => 'Unauthorized'], 403);
            if ($transaction->status !== 'shipping') return response()->json(['message' => 'Invalid status'], 400);
            $transaction->status = 'delivered';
            $transaction->save();
            return response()->json(['message' => 'Pesanan diterima']);
        });

        Route::post('/transactions/{id}/request-return', [TransactionController::class, 'requestReturn']);
        Route::get('/seller/orders', [TransactionController::class, 'sellerOrders']);
        Route::get('/seller/unread-orders-count', [TransactionController::class, 'getUnreadOrdersCount']);
        Route::post('/seller/mark-orders-as-read', [TransactionController::class, 'markOrdersAsRead']);
        Route::post('/seller/orders/{id}/update-status', [TransactionController::class, 'updateSellerOrderStatus']);
        Route::post('/seller/orders/{id}/approve-return', [TransactionController::class, 'approveReturn']);
        Route::get('/my-products', function () {
            return \App\Models\Product::with(['category', 'productImages'])->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        });
        Route::post('/products', [ProductController::class, 'store']);
        Route::post('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        /* ---------- ADMIN ---------- */
        Route::middleware([\App\Http\Middleware\Admin::class])->group(function () {
            Route::get('/admin/users', function () {
                $users = \App\Models\User::withCount('products')->get();
                
                $data = $users->map(function($user) {
                    // Anggap online jika aktif dalam 5 menit terakhir
                    $isOnline = false;
                    if ($user->last_seen_at) {
                        $isOnline = $user->last_seen_at->gt(now()->subMinutes(5));
                    }
                    
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'products_count' => $user->products_count,
                        'status' => $isOnline ? 'online' : 'offline',
                        'is_current' => Auth::id() === $user->id
                    ];
                });

                return response()->json($data);
            });

            Route::post('/admin/users', function (Request $request) {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8',
                    'role' => 'required|in:admin,pengguna',
                ]);

                $user = \App\Models\User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => $validated['role'],
                    'email_verified_at' => now(),
                ]);

                return response()->json(['message' => 'User created successfully', 'user' => $user]);
            });

            Route::post('/admin/users/{id}', function (Request $request, $id) {
                $user = \App\Models\User::findOrFail($id);
                
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                    'password' => 'nullable|string|min:8',
                    'role' => 'required|in:admin,pengguna',
                ]);

                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->role = $validated['role'];

                if (!empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                }

                $user->save();

                return response()->json(['message' => 'User updated successfully', 'user' => $user]);
            });

            Route::delete('/admin/users/{id}', function ($id) {
                if (Auth::id() == $id) {
                    return response()->json(['message' => 'Tidak dapat menghapus diri sendiri'], 403);
                }

                $user = \App\Models\User::findOrFail($id);
                $user->delete();

                return response()->json(['message' => 'User deleted successfully']);
            });

            Route::get('/admin/transactions', function () {
                return \App\Models\Transaction::with(['user', 'items'])->orderBy('created_at', 'desc')->get();
            });

            Route::get('/admin/sales-data', function (Request $request) {
                $days = (int) ($request->query('days', 30));
                $sales = \App\Models\Transaction::where('status', 'paid')->where('created_at', '>=', now()->subDays($days))->selectRaw('DATE(created_at) as date, SUM(total_price) as total')->groupBy('date')->get()->pluck('total', 'date');
                $data = [];
                for ($i = 0; $i < $days; $i++) {
                    $date = now()->subDays($days - 1 - $i)->format('Y-m-d');
                    $data[] = ['date' => $date, 'total' => $sales->get($date, 0)];
                }
                return response()->json($data);
            });
            Route::get('/admin/popular-products', function () {
                return \App\Models\Product::withSum(['transactionItems' => function($q){ $q->whereHas('transaction', function($t){ $t->whereIn('status', ['paid','shipping','delivered']); }); }], 'qty')->orderByDesc('transaction_items_sum_qty')->take(10)->get();
            });
        });
    });
});