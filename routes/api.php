<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::middleware('auth:sanctum')->group(function () {
    // Cart API
    Route::get('/cart/count', [Api\CartController::class, 'count']);
    Route::get('/cart', [Api\CartController::class, 'index']);
    
    // Products API
    Route::get('/products', [Api\ProductController::class, 'index']);
    Route::get('/products/{slug}', [Api\ProductController::class, 'show']);
    
    // Orders API
    Route::get('/orders', [Api\OrderController::class, 'index']);
    Route::get('/orders/{order}', [Api\OrderController::class, 'show']);
});