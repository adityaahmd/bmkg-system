<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
// Import class untuk Middleware Laravel 12
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware secara statis (Standar Laravel 12)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:admin'),
        ];
    }

    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('order_status') && $request->order_status != '') {
            $query->where('order_status', $request->order_status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,verified,failed'
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
            'paid_at' => $request->payment_status === 'verified' ? now() : null
        ]);

        return back()->with('success', 'Status pembayaran diperbarui');
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:new,processing,completed,cancelled'
        ]);

        $order->update([
            'order_status' => $request->order_status
        ]);

        return back()->with('success', 'Status pesanan diperbarui');
    }
}