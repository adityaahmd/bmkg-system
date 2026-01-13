@extends('layouts.app')

@section('title', 'Pesanan Berhasil - BMKG Data Service')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto text-center">
        <div class="mb-8">
            <svg class="w-24 h-24 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="text-4xl font-bold text-green-600 mb-4">Pesanan Berhasil Dibuat!</h1>
        <p class="text-xl text-gray-600 mb-8">Terima kasih atas pesanan Anda</p>
        
        <div class="card p-8 text-left mb-8">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <span class="text-gray-600 text-sm">No. Pesanan</span>
                    <p class="font-bold text-lg">{{ $order->order_number }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Tanggal</span>
                    <p class="font-bold text-lg">{{ $order->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Total Pembayaran</span>
                    <p class="font-bold text-lg text-blue-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Metode Pembayaran</span>
                    <p class="font-bold text-lg capitalize">{{ $order->payment_method }}</p>
                </div>
            </div>
            
            @if($order->payment_method === 'transfer')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <h3 class="font-bold mb-3">Instruksi Pembayaran Transfer Bank</h3>
                <div class="space-y-2 text-sm">
                    <p><strong>Bank:</strong> Bank Mandiri</p>
                    <p><strong>No. Rekening:</strong> 1234567890</p>
                    <p><strong>Atas Nama:</strong> BMKG Data Service</p>
                    <p><strong>Jumlah Transfer:</strong> <span class="font-bold text-blue-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                    <p class="text-red-600 mt-3">* Harap transfer sesuai jumlah yang tertera untuk mempermudah verifikasi</p>
                </div>
            </div>
            @endif
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-900">
                    <strong>Estimasi Verifikasi:</strong> 1-2 jam setelah pembayaran diterima<br>
                    Anda akan menerima email konfirmasi setelah pembayaran terverifikasi.
                </p>
            </div>
        </div>
        
        <div class="flex justify-center space-x-4">
            <a href="{{ route('dashboard.orders') }}" class="btn-primary">
                Lihat Detail Pesanan
            </a>
            <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 px-8 py-4 rounded-lg font-semibold transition">
                Lanjut Belanja
            </a>
        </div>
    </div>
</div>
@endsection