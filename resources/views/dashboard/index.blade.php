@extends('layouts.app')

@section('title', 'Dashboard - BMKG Data Service')

@section('content')
<style>
    .dashboard-gradient {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
    
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }
    
    .welcome-section {
        background: linear-gradient(135deg, #1e40af 0%, #1d3693 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 24px rgba(30, 64, 175, 0.2);
    }
    
    .table-row:hover {
        background-color: #f8fafc;
    }
    
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-primary-dashboard {
        background: linear-gradient(135deg, #1e40af 0%, #1d3693 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }
    
    .btn-primary-dashboard:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(30, 64, 175, 0.4);
        background: linear-gradient(135deg, #1d3693 0%, #1e3a8a 100%);
    }
    
    .card-container {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .section-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }
</style>

<div class="dashboard-gradient py-8">
    <div class="container mx-auto px-4">
        <!-- Welcome Section -->
        <div class="welcome-section mb-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Halo, {{ $user->name }}!</h1>
                    <p class="text-blue-100 text-lg">Selamat datang kembali di dashboard Anda</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn-primary-dashboard mt-4 md:mt-0">
                    Jelajahi Produk
                </a>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-6 rounded-xl bg-white">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-medium">Total Pesanan</span>
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-blue-700">{{ $stats['total_orders'] }}</div>
                <div class="h-1 w-full bg-blue-100 rounded-full mt-3">
                    <div class="h-1 bg-blue-500 rounded-full" style="width: {{ min(100, $stats['total_orders'] * 10) }}%"></div>
                </div>
            </div>
            
            <div class="stat-card p-6 rounded-xl bg-white">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-medium">Total Pengeluaran</span>
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-green-600">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</div>
                <div class="h-1 w-full bg-green-100 rounded-full mt-3">
                    <div class="h-1 bg-green-500 rounded-full" style="width: {{ min(100, ($stats['total_spent'] / 1000000) * 20) }}%"></div>
                </div>
            </div>
            
            <div class="stat-card p-6 rounded-xl bg-white">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-medium">Data Diunduh</span>
                    <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-purple-600">{{ $stats['downloads'] }}</div>
                <div class="h-1 w-full bg-purple-100 rounded-full mt-3">
                    <div class="h-1 bg-purple-500 rounded-full" style="width: {{ min(100, $stats['downloads'] * 5) }}%"></div>
                </div>
            </div>
            
            <div class="stat-card p-6 rounded-xl bg-white">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600 font-medium">Paket Aktif</span>
                    <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div class="text-xl font-bold text-orange-600 mb-2">{{ $stats['current_plan'] }}</div>
                <a href="{{ route('pricing.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                    Upgrade Paket →
                </a>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="card-container">
            <div class="flex items-center justify-between mb-6">
                <h2 class="section-title text-2xl">Riwayat Pesanan Terbaru</h2>
                <a href="{{ route('dashboard.orders') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                    Lihat Semua →
                </a>
            </div>
            
            @if($recentOrders->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada pesanan</p>
                    <p class="text-gray-400 text-sm mt-2">Mulai jelajahi katalog produk kami</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">No. Order</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Item</th>
                                <th class="text-right py-4 px-4 font-semibold text-gray-700">Total</th>
                                <th class="text-center py-4 px-4 font-semibold text-gray-700">Status</th>
                                <th class="text-center py-4 px-4 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr class="table-row border-b border-gray-100 last:border-b-0">
                                <td class="py-4 px-4 font-semibold text-gray-800">{{ $order->order_number }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="py-4 px-4 text-gray-600">{{ $order->items->count() }} item</td>
                                <td class="py-4 px-4 text-right font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="py-4 px-4 text-center">
                                    @if($order->payment_status === 'verified')
                                        <span class="status-badge bg-green-100 text-green-800">
                                            Terverifikasi
                                        </span>
                                    @elseif($order->payment_status === 'pending')
                                        <span class="status-badge bg-yellow-100 text-yellow-800">
                                            Menunggu
                                        </span>
                                    @else
                                        <span class="status-badge bg-gray-100 text-gray-800">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('dashboard.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

