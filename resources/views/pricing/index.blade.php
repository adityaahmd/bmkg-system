@extends('layouts.app')

@section('title', 'Paket Layanan - BMKG Data Service')

@section('content')
<style>
    .pricing-hero {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e2e8f0;
        padding-top: 4rem;
        padding-bottom: 4rem;
    }
    
    .pricing-section {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding-top: 5rem;
        padding-bottom: 5rem;
    }
    
    .pricing-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 1.5rem;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .pricing-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.15);
        border-color: rgba(30, 64, 175, 0.25);
    }
    
    .popular-card {
        border-color: #1e40af !important;
        box-shadow: 0 12px 28px rgba(30, 64, 175, 0.25) !important;
        position: relative;
        z-index: 10;
        scale: 1.03;
    }
    
    .popular-badge {
        background: linear-gradient(135deg, #1e40af 0%, #1d3693 100%);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.4);
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    
    .btn-outline {
        border: 2px solid #1e40af;
        color: #1e40af;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 1rem;
    }
    
    .btn-outline:hover {
        background: linear-gradient(135deg, #1e40af 0%, #1d3693 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(30, 64, 175, 0.3);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #1e40af 0%, #1d3693 100%);
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 6px 16px rgba(30, 64, 175, 0.3);
        border-radius: 1rem;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #1d3693 0%, #1e3a8a 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.4);
    }
    
    .feature-item {
        transition: all 0.2s ease;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .feature-item:hover {
        color: #1e40af;
    }
    
    .price-highlight {
        background: linear-gradient(135deg, #1e40af 0%, #1d3693 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
    }
    
    .hero-title {
        font-weight: 800;
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

{{-- HERO --}}
<section class="pricing-hero">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center justify-center bg-blue-50 text-blue-700 text-sm font-semibold px-4 py-2 rounded-full mb-6 border border-blue-100">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Paket Layanan Resmi BMKG
        </div>
        <h1 class="hero-title text-4xl md:text-5xl mb-4">Paket Layanan Data Premium</h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
            Pilih paket yang paling sesuai dengan kebutuhan riset, industri, atau institusi Anda
        </p>
    </div>
</section>

{{-- PRICING --}}
<section class="pricing-section">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($plans as $plan)
            <div class="{{ $plan->is_popular ? 'popular-card' : '' }} pricing-card">
                {{-- BADGE POPULAR --}}
                @if($plan->is_popular)
                <span class="popular-badge absolute -top-3 -right-3 text-white text-xs font-bold px-4 py-2 rounded-full z-20 uppercase tracking-wider">
                    POPULER
                </span>
                @endif

                {{-- TITLE --}}
                <h3 class="text-xl font-bold text-gray-800 mb-3">
                    {{ $plan->name }}
                </h3>

                <p class="text-gray-600 text-sm mb-8 leading-relaxed">
                    {{ $plan->description }}
                </p>

                {{-- PRICE --}}
                <div class="mb-8">
                    @if($plan->isFree())
                        <div class="text-4xl font-extrabold text-gray-800">
                            Gratis
                        </div>
                        <div class="text-sm text-gray-500 mt-2">
                            Akses dasar selamanya
                        </div>
                    @else
                        <div class="text-4xl font-extrabold price-highlight">
                            Rp {{ number_format($plan->price_yearly, 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-gray-600 mt-2">
                            per tahun • Hemat {{ number_format(($plan->price_monthly * 12 - $plan->price_yearly) / ($plan->price_monthly * 12) * 100, 0) }}%
                        </div>
                    @endif
                </div>

                {{-- FEATURES --}}
                <ul class="space-y-4 text-sm mb-8 flex-grow">
                    @foreach($plan->features as $feature)
                    <li class="feature-item flex">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-700">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>

                {{-- BUTTON --}}
                <div class="mt-auto">
                    @if($plan->isFree())
                        <a href="{{ route('register') }}" class="btn-outline block w-full text-center py-3 font-semibold">
                            Mulai Gratis
                        </a>
                    @elseif($plan->is_popular)
                        <a href="{{ route('register') }}" class="btn-primary block w-full text-center py-3 font-semibold">
                            Pilih Startup
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-outline block w-full text-center py-3 font-semibold">
                            Pilih {{ $plan->name }}
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- FOOTER NOTE --}}
        <div class="text-center mt-16 max-w-3xl mx-auto">
            <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50">
                <p class="text-gray-600 text-base font-medium mb-3">
                    Semua paket mencakup akses ke API, dokumentasi lengkap, dan dukungan teknis dasar
                </p>
                <p class="text-gray-500 text-sm">
                    Butuh paket khusus untuk institusi? <a href="/contact" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">Hubungi kami</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

