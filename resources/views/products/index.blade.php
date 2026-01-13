@extends('layouts.app')

@section('title', 'Layanan - BMKG Data Service')

@section('content')
{{-- Header Halaman --}}
<div class="bg-white border-b border-gray-100 py-12">
    <div class="container mx-auto px-4">
        <nav class="text-sm text-gray-500 mb-4 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-blue-900 transition">Beranda</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="font-semibold text-blue-900">Layanan</span>
        </nav>
        
        <div class="max-w-2xl">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Layanan Data BMKG</h1>
            <p class="text-gray-600 leading-relaxed">Akses dataset meteorologi, klimatologi, dan geofisika resmi secara real-time maupun historis untuk kebutuhan riset dan operasional Anda.</p>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    {{-- Filter Kategori --}}
    <div class="flex flex-wrap gap-3 mb-10">
        <button onclick="filterCategory('all')" 
                class="filter-btn px-8 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 shadow-sm {{ !request('category') ? 'active' : '' }}">
            Semua Dataset
        </button>
        @foreach($categories as $category)
        <button onclick="filterCategory({{ $category->id }})" 
                class="filter-btn px-8 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 shadow-sm {{ request('category') == $category->id ? 'active' : '' }}">
            {{ $category->name }}
        </button>
        @endforeach
    </div>
    
    {{-- Grid Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($products as $product)
        <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 flex flex-col">
            {{-- Bagian Visual Produk --}}
            <div class="h-52 bg-gray-100 relative overflow-hidden">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center transition-transform duration-700 group-hover:scale-110">
                        <span class="text-6xl">{{ $product->category->icon }}</span>
                    </div>
                @endif
                
                {{-- Badge Tipe --}}
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 backdrop-blur-md text-blue-900 text-[10px] font-black uppercase px-3 py-1 rounded-full shadow-sm">
                        {{ $product->type }}
                    </span>
                </div>
            </div>

            {{-- Bagian Informasi --}}
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">{{ $product->category->name }}</span>
                    <div class="flex items-center text-yellow-500 bg-yellow-50 px-2 py-0.5 rounded-md">
                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <span class="ml-1 text-[11px] font-bold">{{ $product->rating ?? '5.0' }}</span>
                    </div>
                </div>
                
                <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-900 transition-colors line-clamp-1">{{ $product->name }}</h3>
                <p class="text-gray-500 text-sm mb-6 line-clamp-2 flex-1">{{ $product->description }}</p>
                
                <div class="flex items-center justify-between mb-6">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Mulai dari</span>
                        <span class="text-xl font-black text-blue-900">{{ $product->formattedPrice() }}</span>
                    </div>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('products.show', $product->slug) }}" 
                       class="text-center bg-gray-50 hover:bg-gray-100 text-gray-700 py-3 rounded-xl text-xs font-bold transition">
                        Detail
                    </a>
                    @if($product->type == 'gratis')
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="bg-emerald-600 hover:bg-emerald-700 text-white text-center py-3 rounded-xl text-xs font-bold transition shadow-lg shadow-emerald-200">
                            Gunakan
                        </a>
                    @else
                        <button onclick="addToCart({{ $product->id }})" 
                                class="bg-blue-900 hover:bg-blue-800 text-white text-center py-3 rounded-xl text-xs font-bold transition shadow-lg shadow-blue-900/20 active:scale-95">
                            Tambah
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <p class="text-gray-400 font-medium">Belum ada dataset yang tersedia untuk kategori ini.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-16">
        {{ $products->links() }}
    </div>
</div>

@push('scripts')
<script>
/**
 * Filter berdasarkan kategori
 */
function filterCategory(categoryId) {
    const url = categoryId === 'all' 
        ? '{{ route("products.index") }}'
        : '{{ route("products.index") }}?category=' + categoryId;
    window.location.href = url;
}

/**
 * Tambahkan produk ke keranjang via AJAX
 */
function addToCart(productId) {
    // Tampilkan loading jika diperlukan
    const btn = event.currentTarget;
    const originalText = btn.innerText;
    btn.innerText = '...';
    btn.disabled = true;

    fetch('{{ route("cart.store") }}', { // Pastikan route name sesuai di web.php
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ 
            product_id: productId,
            quantity: 1 
        })
    })
    .then(async response => {
        if (response.ok) {
            // Berhasil: Redirect ke halaman keranjang
            window.location.href = '{{ route("cart.index") }}';
        } else if (response.status === 401) {
            // Belum login: Redirect ke login
            window.location.href = '{{ route("login") }}';
        } else {
            const data = await response.json();
            alert(data.message || 'Gagal menambahkan produk ke keranjang.');
            btn.innerText = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.innerText = originalText;
        btn.disabled = false;
    });
}
</script>

<style>
/* Styling Tombol Filter */
.filter-btn {
    background: white;
    color: #6b7280;
    border: 1px solid #f3f4f6;
}
.filter-btn:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}
.filter-btn.active {
    background: #003366;
    color: white;
    border-color: #003366;
}

/* Custom shadow untuk card */
.card-hover:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 51, 102, 0.15);
}
</style>
@endpush
@endsection