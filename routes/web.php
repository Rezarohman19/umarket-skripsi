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
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\VoucherController;
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
Route::get('/store/{user_id}', function (Request $request, $user_id) {
    \App\Models\StoreVisit::recordVisit($user_id, $request);
    return view('store');
})->name('store');

Route::get('/product/{id}', function (Request $request, $id) {
    $product = \App\Models\Product::find($id);
    if ($product && $product->user_id) {
        \App\Models\StoreVisit::recordVisit($product->user_id, $request);
    }
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
    
    // Redirect /admin/login ke /login untuk kompatibilitas
    Route::get('/admin/login', function () {
        return redirect('/login');
    });
});

// Forgot & Reset Password Routes (dapat diakses siapa pun yang memiliki token link, tanpa terhalang sesi login)
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Logout route (authenticated users only)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| EMAIL VERIFICATION ROUTES (Session-based)
|--------------------------------------------------------------------------
*/
// Link verifikasi email dari email (dapat diakses oleh user login maupun via browser eksternal di HP)
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    \Log::info('Verification request received for user ID or hash: ' . $id . ' / ' . $hash);
    
    // 1. Coba cari user berdasarkan ID terlebih dahulu
    $user = \App\Models\User::find($id);

    // 2. Jika ID tidak ditemukan (misal pengguna sempat mendaftar ulang sehingga ID berubah di database),
    // cari pengguna terbaru yang SHA1(email) cocok dengan hash verifikasi
    if (!$user) {
        $user = \App\Models\User::whereRaw('SHA1(email) = ?', [(string) $hash])->latest('id')->first();
    }

    // 3. Fallback jika ada parameter query email
    if (!$user && $request->filled('email')) {
        $user = \App\Models\User::where('email', $request->query('email'))->latest('id')->first();
    }

    if (!$user) {
        return redirect('/login')->withErrors(['email' => 'Akun tidak ditemukan. Silakan masuk atau daftar kembali.']);
    }

    // 4. Jika sudah terverifikasi sebelumnya
    if ($user->hasVerifiedEmail()) {
        if (!Auth::check() || Auth::id() != $user->id) {
            Auth::login($user);
        }
        return view('verify-success', ['user' => $user, 'already' => true]);
    }

    // 5. Validasi hash email kecocokan dengan email pemilik
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return redirect('/login')->withErrors(['email' => 'Tautan verifikasi email tidak valid. Silakan minta tautan baru.']);
    }

    // 6. Validasi waktu kedaluwarsa jika parameter expires ada
    // Beri toleransi 7 hari untuk kemudahan pengguna dan dosen, atau kirim ulang otomatis jika sudah terlalu lama
    if ($request->has('expires') && now()->timestamp > (int) $request->query('expires') + (7 * 86400)) {
        try {
            $user->sendEmailVerificationNotification();
            return redirect('/login')->withErrors(['email' => 'Tautan verifikasi telah kedaluwarsa. Tautan verifikasi baru telah otomatis dikirimkan ke ' . $user->email . '. Silakan periksa email Anda.']);
        } catch (\Throwable $e) {
            return redirect('/login')->withErrors(['email' => 'Tautan verifikasi telah kedaluwarsa. Silakan masuk untuk meminta tautan verifikasi baru.']);
        }
    }

    // 7. Tandai email terverifikasi
    $user->markEmailAsVerified();
    event(new \Illuminate\Auth\Events\Verified($user));
    \Log::info('Verification fulfilled successfully for user: ' . $user->id);

    // 8. Otomatis login-kan pengguna jika belum login atau login sebagai user lain
    Auth::login($user);

    return view('verify-success', ['user' => $user, 'already' => false]);
})->name('verification.verify');

// Kirim ulang email verifikasi publik (dapat diakses siapa pun tanpa harus login terlebih dahulu)
Route::post('/email/resend-public', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
    ], [
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'Alamat email ' . $request->email . ' belum terdaftar. Silakan registrasi terlebih dahulu.');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('success', 'Email ' . $user->email . ' sudah terverifikasi sebelumnya. Silakan masuk.');
    }

    try {
        $user->sendEmailVerificationNotification();
        return back()->with('success', 'Tautan verifikasi baru telah berhasil dikirim ke ' . $user->email . '! Silakan periksa Kotak Masuk (Inbox) atau folder Spam/Promosi email Anda.');
    } catch (\Throwable $e) {
        \Log::error('Gagal mengirim ulang email verifikasi publik: ' . $e->getMessage());
        return back()->with('error', 'Gagal mengirim email verifikasi: ' . $e->getMessage() . '. Silakan coba beberapa saat lagi.');
    }
})->middleware(['throttle:6,1'])->name('verification.resend.public');

// Halaman notice verifikasi (dapat diakses user yang sedang login atau guest yang membawa parameter email)
Route::get('/email/verify', function (Request $request) {
    if ($request->user() && $request->user()->hasVerifiedEmail()) {
        return redirect('/')->with('success', 'Email Anda sudah terverifikasi.');
    }
    return view('verify-email');
})->name('verification.notice');

Route::middleware(['auth'])->group(function () {

    // Resend verification email
    Route::post('/email/verification-notification', function (Request $request) {
        $user = $request->user();
        if ($user && $user->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Email Anda sudah terverifikasi.');
        }

        try {
            $user->sendEmailVerificationNotification();
            return back()->with('success', 'Tautan verifikasi baru telah berhasil dikirim ke ' . $user->email . '. Silakan periksa Kotak Masuk (Inbox) email Anda.');
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim ulang email verifikasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email verifikasi: ' . $e->getMessage() . '. Pastikan koneksi internet stabil.');
        }
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
Route::middleware(['auth', 'verified'])->group(function () {



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

    Route::get('/order-confirmation/{id?}', function (Request $request, $id = null) {
        $orderId = $request->query('order_id');
        $txStatus = $request->query('transaction_status');
        $statusCode = $request->query('status_code');

        if ($orderId && in_array($txStatus, ['settlement', 'capture']) && $statusCode == '200') {
            $transaction = \App\Models\Transaction::where('order_id', $orderId)->first();
            if ($transaction && $transaction->status !== 'paid') {
                $oldStatus = $transaction->status;
                $transaction->status = 'paid';
                $transaction->reduceStock();
                $transaction->save();

                // Kirim notifikasi WhatsApp ke seller bahwa pembayaran berhasil
                try {
                    $wa = new \App\Services\WhatsAppService();
                    if ($wa->isEnabled()) {
                        $transaction->load(['items.product.user', 'user']);
                        $firstItem = $transaction->items->first();
                        $seller = $firstItem?->product?->user;
                        $buyer = $transaction->user;
                        if ($seller && $seller->phone) {
                            $wa->notifySellerPaymentReceived(
                                $seller->phone,
                                $buyer->name ?? 'Pembeli',
                                $transaction->order_id,
                                $transaction->total_price
                            );
                        }
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('WA redirect error: ' . $e->getMessage());
                }
            }
        }
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
                'availability' => $p->availability,
                'image_url' => $p->image ? Storage::url($p->image) : null,
                'image_urls' => $p->image_urls,
                'user' => $p->user,
                'user_id' => $p->user_id,
                'store_name' => $p->user->name ?? 'Toko',
            ]);
        return response()->json($products);
    });

    Route::get('/categories', function () {
        return response()->json(\App\Models\Category::all());
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
                'availability' => $p->availability,
                'image_url' => $p->image ? Storage::url($p->image) : null,
                'image_urls' => $p->image_urls,
                'user' => $p->user,
                'user_id' => $p->user_id,
                'store_name' => $p->user->name ?? 'Toko',
            ]);
        return response()->json($products);
    });

    Route::get('/store/{user_id}', function (Request $request, $user_id) {
        $user = \App\Models\User::select('id', 'name', 'phone', 'email', 'description', 'photo')
            ->find($user_id);
        if (!$user) return response()->json(['message' => 'Store not found'], 404);

        // Tracker kunjungan toko
        try {
            \App\Models\StoreVisit::recordVisit($user->id, $request);
        } catch (\Exception $e) {
            // Abaikan jika gagal menyimpan
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

    Route::get('/products/{id}', function (Request $request, $id) {
        $product = \App\Models\Product::with('user:id,name,phone')->find($id);
        if (!$product) return response()->json(['message' => 'Not found'], 404);

        // Catat kunjungan ke toko pemilik produk
        if ($product->user_id) {
            try {
                \App\Models\StoreVisit::recordVisit($product->user_id, $request);
            } catch (\Exception $e) {
                // Abaikan
            }
        }

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

    Route::get('/check-reset-redirect', function (Request $request) {
        $email = $request->query('email');
        if (!$email) {
            return response()->json(['redirect' => false]);
        }
        $url = Cache::get('reset_redirect_' . md5($email));
        return response()->json([
            'redirect' => !empty($url),
            'url' => $url,
        ]);
    });

    /* ---------- PROTECTED API ROUTES ---------- */
    Route::middleware(['auth'])->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'apiLogout']);
        Route::get('/user', function () {
            $user = Auth::user()?->fresh();
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
                        'availability' => $item->product->availability,
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
        Route::delete('/transactions/{id}', [TransactionController::class, 'deleteExpiredTransaction']);
        
        Route::post('/transactions/{id}/mark-delivered', function (Request $request, $id) {
            $transaction = \App\Models\Transaction::findOrFail($id);
            if ($transaction->user_id !== Auth::id()) return response()->json(['message' => 'Unauthorized'], 403);
            if ($transaction->status !== 'shipping') return response()->json(['message' => 'Invalid status'], 400);
            $transaction->status = 'delivered';
            $transaction->save();
            return response()->json(['message' => 'Pesanan diterima']);
        });

        Route::get('/transactions/{id}/status', function ($id) {
            $transaction = \App\Models\Transaction::findOrFail($id);
            if ($transaction->user_id !== Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return response()->json([
                'id' => $transaction->id,
                'order_id' => $transaction->order_id,
                'status' => $transaction->status,
                'total_price' => $transaction->total_price,
                'discount_amount' => $transaction->discount_amount,
                'voucher_code' => $transaction->voucher_code,
            ]);
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

        /* ---------- ORDER TRACKING (Real-time Location) ---------- */
        Route::post('/tracking/{transaction_id}/start', [OrderTrackingController::class, 'startDelivery']);
        Route::post('/tracking/{transaction_id}/update', [OrderTrackingController::class, 'updateLocation']);
        Route::post('/tracking/{transaction_id}/complete', [OrderTrackingController::class, 'completeDelivery']);
        Route::post('/tracking/{transaction_id}/destination', [OrderTrackingController::class, 'updateDestination']);
        Route::get('/tracking/{transaction_id}', [OrderTrackingController::class, 'getLocation']);

        /* ---------- VOUCHERS ---------- */
        Route::get('/vouchers', [VoucherController::class, 'index']);
        Route::post('/vouchers/apply', [VoucherController::class, 'apply']);
        Route::get('/seller/vouchers', [VoucherController::class, 'sellerIndex']);
        Route::post('/seller/vouchers', [VoucherController::class, 'sellerStore']);
        Route::post('/seller/vouchers/{id}/toggle', [VoucherController::class, 'sellerToggle']);
        Route::delete('/seller/vouchers/{id}', [VoucherController::class, 'sellerDestroy']);

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
                if ($days < 1) $days = 30;

                $validStatuses = ['paid', 'processing', 'shipping', 'delivered', 'completed', 'settlement', 'capture'];
                $startDate = now()->subDays($days - 1)->startOfDay();

                $sales = \App\Models\Transaction::whereIn('status', $validStatuses)
                    ->where('created_at', '>=', $startDate)
                    ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
                    ->groupBy('date')
                    ->get()
                    ->pluck('total', 'date');

                $data = [];
                for ($i = 0; $i < $days; $i++) {
                    $date = now()->subDays($days - 1 - $i)->format('Y-m-d');
                    $data[] = [
                        'date' => $date,
                        'total' => (float) ($sales->get($date, 0)),
                    ];
                }

                return response()->json($data);
            });
            Route::get('/admin/popular-products', function () {
                return \App\Models\Product::withSum(['transactionItems' => function($q){ $q->whereHas('transaction', function($t){ $t->whereIn('status', ['paid','shipping','delivered']); }); }], 'qty')->orderByDesc('transaction_items_sum_qty')->take(10)->get();
            });

            /* ---------- ADMIN VOUCHERS ---------- */
            Route::get('/admin/vouchers', [VoucherController::class, 'adminIndex']);
            Route::post('/admin/vouchers', [VoucherController::class, 'store']);
            Route::post('/admin/vouchers/{id}/toggle', [VoucherController::class, 'toggle']);
            Route::delete('/admin/vouchers/{id}', [VoucherController::class, 'destroy']);
        });
    });
});