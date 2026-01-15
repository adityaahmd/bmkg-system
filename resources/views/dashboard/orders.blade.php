{{-- resources/views/dashboard/orders.blade.php --}}
@extends('layouts.app')

@section('title', 'Pesanan Saya - BMKG')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">Pesanan Saya</h1>
        <p class="text-gray-600">Riwayat semua pesanan Anda</p>
    </div>

    @if($orders->isEmpty())
        <div class="card p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Belum Ada Pesanan</h2>
            <p class="text-gray-600 mb-6">Anda belum melakukan pemesanan apapun</p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="card p-6">
                <div class="flex flex-wrap items-center justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-lg">{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $order->payment_status === 'verified' ? 'bg-green-100 text-green-800' : 
                               ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $order->order_status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($order->order_status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h4 class="font-semibold mb-2">Item:</h4>
                    <ul class="space-y-2">
                        @foreach($order->items as $item)
                        <li class="flex justify-between text-sm">
                            <span>{{ $item->product_name }} ({{ $item->quantity }}x)</span>
                            <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="border-t mt-4 pt-4 flex justify-between items-center">
                    <div>
                        <span class="text-gray-600">Total:</span>
                        <span class="text-xl font-bold text-blue-900 ml-2">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="space-x-2">
                        @if($order->payment_status === 'pending')
                            <span class="text-sm text-gray-600">Menunggu pembayaran...</span>
                        @elseif($order->payment_status === 'verified')
                            <a href="{{ route('dashboard.downloads') }}" class="btn-primary text-sm">
                                Download Data
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection