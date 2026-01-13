@extends('layouts.admin')

@section('title', 'Admin Dashboard - BMKG')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">Dashboard Admin</h1>
    <p class="text-gray-600">Overview sistem pelayanan data BMKG</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 bg-gradient-to-br from-blue-500 to-blue-700 text-white">
        <div class="flex items-center justify-between mb-2">
            <span>Revenue Bulan Ini</span>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="text-3xl font-bold">Rp {{ number_format($stats['revenue_month'], 0, ',', '.') }}</div>
    </div>
    
    <div class="card p-6 bg-gradient-to-br from-green-500 to-green-700 text-white">
        <div class="flex items-center justify-between mb-2">
            <span>Orders Bulan Ini</span>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <div class="text-3xl font-bold">{{ $stats['orders_month'] }}</div>
    </div>
    
    <div class="card p-6 bg-gradient-to-br from-purple-500 to-purple-700 text-white">
        <div class="flex items-center justify-between mb-2">
            <span>Active Users</span>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div class="text-3xl font-bold">{{ $stats['active_users'] }}</div>
    </div>
    
    <div class="card p-6 bg-gradient-to-br from-orange-500 to-orange-700 text-white">
        <div class="flex items-center justify-between mb-2">
            <span>Total Products</span>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div class="text-3xl font-bold">{{ $stats['total_products'] }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card p-6">
        <h2 class="text-xl font-bold mb-4">Top Produk</h2>
        <div class="space-y-3">
            @foreach($topProducts as $product)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <div class="font-semibold">{{ $product->name }}</div>
                    <div class="text-sm text-gray-600">{{ $product->category->name }}</div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-blue-900">{{ $product->order_items_count }}</div>
                    <div class="text-xs text-gray-600">terjual</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="card p-6">
        <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.products.create') }}" class="btn-primary text-center py-4">
                + Tambah Produk
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary text-center py-4">
                Kelola Pesanan
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white text-center py-4 rounded-lg font-semibold">
                Kelola Users
            </a>
            <a href="{{ route('admin.reports.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white text-center py-4 rounded-lg font-semibold">
                Laporan
            </a>
        </div>
    </div>
</div>

<div class="card p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline font-semibold">Lihat Semua</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-3 px-4">Order ID</th>
                    <th class="text-left py-3 px-4">Customer</th>
                    <th class="text-left py-3 px-4">Items</th>
                    <th class="text-right py-3 px-4">Amount</th>
                    <th class="text-center py-3 px-4">Payment</th>
                    <th class="text-center py-3 px-4">Status</th>
                    <th class="text-center py-3 px-4">Date</th>
                    <th class="text-center py-3 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4 font-semibold">{{ $order->order_number }}</td>
                    <td class="py-3 px-4">
                        <div class="font-semibold">{{ $order->customer_name }}</div>
                        <div class="text-sm text-gray-600">{{ $order->customer_email }}</div>
                    </td>
                    <td class="py-3 px-4">{{ $order->items->count() }} item</td>
                    <td class="py-3 px-4 text-right font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $order->payment_status === 'verified' ? 'bg-green-100 text-green-800' : 
                               ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $order->order_status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($order->order_status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center text-sm">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline text-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection