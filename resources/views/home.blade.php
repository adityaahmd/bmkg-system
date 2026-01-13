@extends('layouts.app')

@section('title', 'Beranda - BMKG Data Service')

@section('content')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
    
    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
    
    .cta-button-primary {
        background: linear-gradient(135deg, #1e40af 0%, #1d3693 100%);
        transition: all 0.3s ease;
    }
    
    .cta-button-primary:hover {
        background: linear-gradient(135deg, #1d3693 0%, #1e3a8a 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }
    
    .cta-button-secondary {
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .cta-button-secondary:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-2px);
    }
    
    .section-divider {
        position: relative;
    }
    
    .section-divider::before {
        content: '';
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, transparent, #1e40af, transparent);
        border-radius: 2px;
    }
</style>

<div class="hero-gradient py-24">
    <div class="container mx-auto px-4 text-center">
        <span class="uppercase tracking-[0.3em] text-xs font-bold text-blue-600 mb-4 block">Portal Layanan Data Resmi</span>
        <h1 class="text-4xl md:text-6xl font-serif text-gray-800 mb-6 italic leading-tight">
            Meteorologi, Klimatologi, <br>& Geofisika
        </h1>
        <p class="max-w-2xl mx-auto text-lg text-gray-600 font-light leading-relaxed mb-12">
            Penyediaan dataset teknis yang akurat untuk mendukung riset, kebijakan publik, dan kebutuhan industri nasional.
        </p>
        
        <div class="max-w-2xl mx-auto mb-10">
            <form action="{{ route('search') }}" method="GET" class="relative group">
                <input type="text" name="q" placeholder="Cari dataset atau dokumen..." 
                       class="w-full pl-6 pr-36 py-4 bg-white border border-gray-300 rounded-lg shadow-sm search-input focus:bg-white focus:border-blue-500 transition-all outline-none italic font-serif text-base">
                <button type="submit" class="absolute right-2 top-2 bottom-2 cta-button-primary text-white px-8 rounded-lg text-sm font-bold uppercase tracking-widest">
                    Cari Dataset
                </button>
            </form>
        </div>
        
        <div class="flex justify-center space-x-8">
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-2 hover:text-blue-700 hover:border-blue-700 transition uppercase tracking-widest">
                Jelajahi Katalog Lengkap
            </a>
        </div>
    </div>
</div>

<div class="bg-white py-24">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 section-divider">
            <h2 class="text-3xl font-serif text-gray-800 mb-4">Klasifikasi Data BMKG</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan dataset yang sesuai dengan kebutuhan spesifik Anda melalui klasifikasi berdasarkan bidang ilmu</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
               class="category-card group p-8 bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl hover:bg-white transition-all duration-300 shadow-sm hover:shadow-md">
                <div class="text-5xl mb-6 text-blue-600 group-hover:text-blue-700 transition-colors duration-300">
                    {{ $category->icon }}
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-3 uppercase tracking-widest">{{ $category->name }}</h3>
                <p class="text-gray-600 text-base leading-relaxed mb-6 font-light">{{ $category->description }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-blue-600 font-semibold">
                        {{ $category->active_products_count }} Dataset Tersedia
                    </span>
                    <span class="text-blue-600 text-sm font-bold">→</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-gradient-to-r from-blue-50 to-indigo-50 py-24">
    <div class="container mx-auto px-4">
<div class="relative flex flex-col md:flex-row justify-between items-end mb-16 pb-8 border-b border-gray-100">
    <div class="absolute left-0 bottom-[-1px] h-[3px] w-24 bg-gradient-to-r from-[#003366] to-[#00A859]"></div>

    <div class="max-w-2xl">
        <div class="flex items-center gap-2 mb-4">
            <span class="h-[1px] w-8 bg-[#00A859]"></span>
            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[#00A859]">Premium Selection</span>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter uppercase leading-none">
            Produk <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#003366] to-blue-600">Unggulan</span> BMKG
        </h2>
        
        <p class="text-gray-500 mt-6 text-lg font-medium leading-relaxed opacity-80">
            Dataset premium dengan standar kalibrasi internasional untuk akurasi data meteorologi dan geofisika tertinggi.
        </p>
    </div>

    <div class="mt-8 md:mt-0">
        <a href="{{ route('products.index') }}" class="group relative inline-flex items-center gap-4 px-8 py-4 bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-500 hover:border-[#003366] hover:shadow-2xl hover:shadow-blue-900/10">
            <div class="absolute inset-0 w-0 bg-[#003366] transition-all duration-500 group-hover:w-full"></div>
            
            <span class="relative z-10 text-xs font-black uppercase tracking-widest text-gray-800 transition-colors duration-500 group-hover:text-white">
                Lihat Semua Produk
            </span>
            
            <div class="relative z-10 flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-[#003366] transition-all duration-500 group-hover:bg-white/20 group-hover:text-white group-hover:rotate-45">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </div>
        </a>
    </div>
</div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredProducts as $product)
            <div class="product-card flex flex-col h-full">
                <div class="aspect-[4/3] bg-white border border-gray-200 mb-6 overflow-hidden relative group rounded-xl">
                    <div class="absolute inset-0 flex items-center justify-center text-6xl text-gray-200 group-hover:text-gray-300 transition duration-500">
                        {{ $product->category->icon ?? '📊' }}
                    </div>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-widest">
                            {{ $product->category->name }}
                        </span>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-3 leading-snug hover:text-blue-600 transition">
                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                </h3>
                
                <p class="text-gray-600 text-base font-light mb-6 line-clamp-3 italic">
                    "{{ Str::limit($product->description, 120) }}"
                </p>
                
                <div class="mt-auto pt-4 border-t border-gray-200 flex items-center justify-between">
                    <div>
                        <span class="block text-xs text-gray-500 uppercase tracking-widest mb-1">Harga Layanan</span>
                        <span class="text-xl font-serif text-gray-800 font-bold">{{ $product->formattedPrice() }}</span>
                    </div>
                    <button onclick="addToCart({{ $product->id }})" 
                            class="cta-button-primary text-white px-5 py-2.5 text-sm font-bold uppercase tracking-widest rounded-lg">
                        Beli Data
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-white py-24">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-4xl mx-auto bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-12 md:p-16 text-white shadow-2xl">
            <h2 class="text-3xl md:text-4xl font-serif mb-6 italic">Mulai Mengakses Data Berkualitas</h2>
            <p class="text-blue-100 mb-10 font-light max-w-2xl mx-auto text-lg">
                Daftar sekarang untuk mendapatkan akses ke repositori data BMKG melalui skema lisensi resmi.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('register') }}" class="bg-white text-blue-700 px-10 py-4 text-sm font-bold uppercase tracking-widest hover:bg-blue-50 transition rounded-lg shadow-lg hover:shadow-xl">
                    Buat Akun Sekarang
                </a>
                <a href="{{ route('pricing.index') }}" class="border-2 border-white text-white px-10 py-4 text-sm font-bold uppercase tracking-widest hover:bg-white/10 transition rounded-lg">
                    Lihat Paket & Harga
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert('Dataset telah ditambahkan ke permohonan Anda.');
            if (typeof updateCartBadge === "function") updateCartBadge();
        }
    });
}
</script>
@endpush

