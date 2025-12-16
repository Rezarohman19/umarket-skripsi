<?php

use Illuminate\Support\Facades\Route;
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

// API dengan token sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Profile API
    Route::get('/profile', [AuthController::class, 'profile']);

    // PRODUCT API
    Route::apiResource('/products', ProductController::class);

    // CART API
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{product_id}', [CartController::class, 'add']);
    Route::post('/cart/remove/{item_id}', [CartController::class, 'remove']);

    // TRANSACTIONS API
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);
});
