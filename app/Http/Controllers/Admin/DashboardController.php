<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware; // Tambahkan ini
use Illuminate\Routing\Controllers\Middleware;    // Tambahkan ini

class DashboardController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware untuk Laravel 12.
     */
    public static function middleware(): array
    {
        return [
            // Memastikan hanya admin yang bisa mengakses controller ini
            new Middleware('auth'),
            new Middleware('role:admin'),
        ];
    }

    // Constructor lama dihapus karena menyebabkan error "undefined method middleware"

    public function index()
    {
        $stats = [
            'revenue_month' => Order::where('payment_status', 'verified')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('total_amount'),
            'orders_month' => Order::whereMonth('created_at', Carbon::now()->month)->count(),
            'active_users' => User::whereHas('orders')->count(),
            'total_products' => Product::where('status', 'published')->count()
        ];

        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(10)
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // Mengarah ke resources/views/admin/dashboard.blade.php
        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}