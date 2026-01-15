<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Products & Pricing
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Member)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // --- Bagian Cart ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store'); 
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart-clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/api/cart/count', [CartController::class, 'getCount']);

    // --- Checkout ---
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // --- DASHBOARD MEMBER ---
    // Gunakan 'dashboard.' (dengan titik) agar sub-route menjadi dashboard.index, dashboard.profile, dll.
// --- DASHBOARD MEMBER ---
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index'); 
        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        
        // --- TAMBAHKAN BARIS INI (Penting untuk mengatasi error tadi) ---
        Route::get('/orders/{order}', [DashboardController::class, 'showOrder'])->name('orders.show');
        
        Route::get('/downloads', [DashboardController::class, 'downloads'])->name('downloads');
        // Route untuk proses download file asli
        Route::get('/downloads/{orderItem}', [DashboardController::class, 'downloadFile'])->name('downloads.process');
        
        // Profile
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    });
    
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Hanya untuk Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Management Resources
    Route::resource('products', Admin\ProductController::class);
    Route::resource('users', Admin\UserController::class);
    Route::resource('pricing-plans', Admin\PricingPlanController::class);
    Route::resource('categories', Admin\CategoryController::class);
    
    // Order Management
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/payment', [Admin\OrderController::class, 'updatePaymentStatus'])->name('orders.payment');
    Route::patch('/orders/{order}/status', [Admin\OrderController::class, 'updateOrderStatus'])->name('orders.status');
    
    // Reports
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');
});

Route::get('/send-email', [MailController::class, 'sendEmail']);

require __DIR__.'/auth.php';