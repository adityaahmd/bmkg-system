@extends('layouts.app')

@section('title', 'Keranjang - BMKG Data Service')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Keranjang Belanja</h1>
    
    @if($cartItems->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-700 mb-2">Keranjang Masih Kosong</h2>
            <p class="text-gray-500 mb-8">Yuk, cari dataset yang Anda butuhkan dan tambahkan ke sini!</p>
            <a href="{{ route('products.index') }}" class="bg-blue-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-800 transition shadow-lg">
                Mulai Berbelanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                @foreach($cartItems as $item)
                <div class="bg-white rounded-2xl p-6 mb-4 flex flex-col sm:flex-row items-center shadow-sm border border-gray-100 transition hover:shadow-md">
                    <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden mb-4 sm:mb-0 sm:mr-6 shrink-0 shadow-sm border border-gray-100">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center">
                                <span class="text-4xl">{{ $item->product->category->icon }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="font-bold text-lg text-gray-800">{{ $item->product->name }}</h3>
                        <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-1">{{ $item->product->category->name }}</p>
                        <p class="text-gray-900 font-extrabold text-lg">{{ $item->product->formattedPrice() }}</p>
                    </div>
                    
                    <div class="flex items-center mt-4 sm:mt-0 space-x-6">
                        <div class="flex items-center border-2 border-gray-100 rounded-xl overflow-hidden bg-gray-50">
                            <button onclick="updateQuantity({{ $item->id }}, -1)" class="px-3 py-2 hover:bg-white hover:text-blue-900 transition font-bold text-gray-500">-</button>
                            {{-- Atribut data-cart-id sangat penting untuk script di bawah --}}
                            <span data-cart-id="{{ $item->id }}" class="px-4 py-2 bg-white font-bold text-gray-800 border-x-2 border-gray-100 min-w-[45px] text-center">
                                {{ $item->quantity }}
                            </span>
                            <button onclick="updateQuantity({{ $item->id }}, 1)" class="px-3 py-2 hover:bg-white hover:text-blue-900 transition font-bold text-gray-500">+</button>
                        </div>
                        
                        <button onclick="removeItem({{ $item->id }})" class="text-gray-300 hover:text-red-600 transition-colors p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 sticky top-24 shadow-xl border border-blue-50">
                    <h3 class="font-bold text-xl mb-6 text-gray-800 border-b pb-4">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Layanan</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($summary['adminFee'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>PPN (11%)</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($summary['tax'], 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-4 border-t-2 border-dashed border-gray-100 flex justify-between items-center">
                            <span class="font-bold text-gray-800 text-lg">Total Tagihan</span>
                            <span class="font-black text-2xl text-blue-900">Rp {{ number_format($summary['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-900 text-white text-center py-4 rounded-xl font-extrabold hover:bg-blue-800 transition shadow-lg shadow-blue-900/20 active:scale-95">
                            Lanjut ke Pembayaran
                        </a>
                        <a href="{{ route('products.index') }}" class="block text-center text-gray-500 hover:text-blue-900 font-bold text-sm transition">
                            &larr; Tambah Produk Lain
                        </a>
                    </div>

                    <div class="mt-6 flex items-center justify-center gap-2 text-[10px] text-gray-400 uppercase tracking-widest font-bold">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        Secure Checkout
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
/**
 * Update kuantitas item di keranjang
 */
function updateQuantity(cartId, delta) {
    const qtyElement = document.querySelector(`[data-cart-id="${cartId}"]`);
    if (!qtyElement) return;

    const currentQty = parseInt(qtyElement.textContent);
    const newQty = currentQty + delta;
    
    // Jangan izinkan kurang dari 1
    if(newQty < 1) return;
    
    // Tampilkan loading state sederhana jika perlu
    qtyElement.classList.add('opacity-50');
    
    fetch(`/cart/${cartId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: newQty })
    })
    .then(response => {
        if(response.ok) {
            window.location.reload();
        } else {
            alert('Gagal memperbarui kuantitas.');
            qtyElement.classList.remove('opacity-50');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.location.reload();
    });
}

/**
 * Hapus item dari keranjang
 */
function removeItem(cartId) {
    if(!confirm('Apakah Anda yakin ingin menghapus data ini dari keranjang?')) return;
    
    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if(response.ok) {
            window.location.reload();
        } else {
            alert('Gagal menghapus item.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.location.reload();
    });
}
</script>
@endpush
@endsection