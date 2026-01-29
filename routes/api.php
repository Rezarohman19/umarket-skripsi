<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

// Public API
Route::get('/categories', function () {
    return \App\Models\Category::all();
});

// Public products (read-only)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/midtrans/notification', [TransactionController::class, 'notification']);

