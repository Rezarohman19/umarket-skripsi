<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
});


// Auth API
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public API
Route::get('/categories', function () {
    return \App\Models\Category::all();
});

// Public products (read-only)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// API dengan token sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Profile API
    Route::get('/profile', [AuthController::class, 'profile']);

    // PRODUCT API (write operations only)
    Route::apiResource('/products', ProductController::class)->except(['index', 'show']);

    // CART API
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{product_id}', [CartController::class, 'add']);
    Route::post('/cart/remove/{item_id}', [CartController::class, 'remove']);

    // TRANSACTIONS API
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'deleteExpiredTransaction']);
    
    // SELLER BALANCE & WITHDRAWAL API
    Route::get('/seller/balance', function () {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        // Hitung total dari penjualan (transaksi dengan status paid, processing, shipping, delivered)
        $totalSold = \App\Models\Transaction::where('user_id', '!=', $user->id)
            ->whereHas('items', function($query) use ($user) {
                $query->whereHas('product', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })
            ->whereIn('status', ['paid', 'processing', 'shipping', 'delivered', 'completed'])
            ->sum('total_price');

        // Kurangi dengan total penarikan yang sudah dikonfirmasi
        $totalWithdrawn = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $balance = max(0, $totalSold - $totalWithdrawn);

        return response()->json([
            'balance' => $balance,
            'total_sold' => $totalSold,
            'total_withdrawn' => $totalWithdrawn,
        ]);
    });

    // Get User Banks
    Route::get('/user/banks', function () {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $banks = \App\Models\BankAccount::where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();

        return response()->json($banks);
    });

    // Withdraw Balance
    Route::post('/seller/withdraw', function () {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request = request();
        $amount = $request->input('amount');
        $bankAccountId = $request->input('bank_account_id');

        // Validasi input
        if (!$amount || $amount < 50000) {
            return response()->json(['message' => 'Jumlah minimum penarikan adalah Rp 50.000'], 422);
        }

        if (!$bankAccountId) {
            return response()->json(['message' => 'Rekening tujuan harus dipilih'], 422);
        }

        // Validasi rekening milik user
        $bankAccount = \App\Models\BankAccount::where('id', $bankAccountId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$bankAccount) {
            return response()->json(['message' => 'Rekening tidak valid'], 422);
        }

        // Hitung saldo
        $totalSold = \App\Models\Transaction::where('user_id', '!=', Auth::id())
            ->whereHas('items', function($query) {
                $query->whereHas('product', function($q) {
                    $q->where('user_id', Auth::id());
                });
            })
            ->whereIn('status', ['paid', 'processing', 'shipping', 'delivered', 'completed'])
            ->sum('total_price');

        $totalWithdrawn = \App\Models\Withdrawal::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->sum('amount');

        $balance = max(0, $totalSold - $totalWithdrawn);

        if ($amount > $balance) {
            return response()->json(['message' => 'Saldo tidak cukup'], 422);
        }

        // Buat withdrawal request
        $withdrawal = \App\Models\Withdrawal::create([
            'user_id' => Auth::id(),
            'bank_account_id' => $bankAccountId,
            'amount' => $amount,
            'status' => 'pending',
            'notes' => null,
        ]);

        return response()->json([
            'message' => 'Permintaan penarikan berhasil dibuat',
            'withdrawal' => $withdrawal,
        ], 201);
    });
});

