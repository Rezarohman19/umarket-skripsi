<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC AUTH
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK (WAJIB PUBLIC)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [TransactionController::class, 'notification']);

/*
|--------------------------------------------------------------------------
| PUBLIC DATA
|--------------------------------------------------------------------------
*/
Route::get('/categories', fn () => \App\Models\Category::all());
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED API (SANCTUM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // PROFILE
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile', [ProfileController::class, 'update']);

    // PRODUCT (SELLER)
    Route::apiResource('/products', ProductController::class)->except(['index', 'show']);

    // CART
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{product_id}', [CartController::class, 'add']);
    Route::post('/cart/remove/{item_id}', [CartController::class, 'remove']);

    // TRANSACTION
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'deleteExpiredTransaction']);

    // SELLER ORDERS
    Route::get('/seller/orders', [TransactionController::class, 'sellerOrders']);

    // UPDATE STATUS BY SELLER
    Route::post('/seller/orders/{id}/status', [TransactionController::class, 'updateSellerOrderStatus']);

});
