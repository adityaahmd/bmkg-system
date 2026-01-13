@extends('layouts.app')

@section('title', 'Checkout - BMKG Data Service')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <h2 class="font-bold text-xl mb-6">Informasi Pembeli</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Lengkap *</label>
                            <input type="text" name="customer_name" value="{{ Auth::user()->name }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900" required>
                            @error('customer_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Email *</label>
                                <input type="email" name="customer_email" value="{{ Auth::user()->email }}" 
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900" required>
                                @error('customer_email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold mb-2">No. Telepon *</label>
                                <input type="tel" name="customer_phone" value="{{ Auth::user()->profile->phone }}" 
                                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900" required>
                                @error('customer_phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold mb-2">Alamat</label>
                            <textarea name="customer_address" rows="3" 
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900">{{ Auth::user()->profile->address }}</textarea>
                            @error('customer_address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="2" 
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900" 
                                      placeholder="Tambahkan catatan khusus untuk pesanan Anda"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="card p-6">
                    <h2 class="font-bold text-xl mb-6">Metode Pembayaran</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="transfer" checked class="mr-4">
                            <div class="flex-1">
                                <div class="font-semibold">Transfer Bank</div>
                                <div class="text-sm text-gray-600">Transfer manual ke rekening bank</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="credit_card" class="mr-4">
                            <div class="flex-1">
                                <div class="font-semibold">Kartu Kredit/Debit</div>
                                <div class="text-sm text-gray-600">Pembayaran dengan kartu kredit atau debit</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="ewallet" class="mr-4">
                            <div class="flex-1">
                                <div class="font-semibold">E-Wallet</div>
                                <div class="text-sm text-gray-600">OVO, Dana, GoPay, LinkAja</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="card p-6 sticky top-24">
                    <h3 class="font-bold text-xl mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                            <span class="font-semibold">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        
                        <hr class="my-4">
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Admin</span>
                            <span class="font-semibold">Rp {{ number_format($summary['adminFee'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pajak (PPN 10%)</span>
                            <span class="font-semibold">Rp {{ number_format($summary['tax'], 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="flex justify-between text-lg">
                            <span class="font-bold">Total</span>
                            <span class="font-bold text-blue-900">Rp {{ number_format($summary['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full text-center">
                        Konfirmasi & Bayar
                    </button>
                    
                    <a href="{{ route('cart.index') }}" class="block text-center text-gray-700 hover:text-blue-900 font-semibold mt-3">
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection