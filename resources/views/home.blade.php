@extends('layouts.app')

@section('title', 'Beranda - BMKG Data Service')

@section('content')
<style>
    :root {
        --primary: #0056b3;
        --primary-dark: #003d82;
        --secondary: #00a859;
        --accent: #ff6b35;
        --dark: #1a1a2e;
        --gray: #6c757d;
        --light-gray: #f8f9fa;
        --white: #ffffff;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--dark);
        line-height: 1.6;
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Loading Screen */
    .loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--primary);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease;
    }

    .loading-screen.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .loader {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid var(--white);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, #0056b3 0%, #003d82 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://picsum.photos/seed/meteorology/1920/1080.jpg') center/cover;
        opacity: 0.1;
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: var(--white);
        text-align: center;
        padding: 60px 0;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        opacity: 0;
        transform: translateY(20px);
    }

    .hero-badge.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.6s ease;
    }

    .hero-badge::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        background: var(--secondary);
        border-radius: 50%;
        margin-right: 10px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .hero h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        opacity: 0;
        transform: translateY(30px);
    }

    .hero h1.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease 0.2s;
    }

    .hero-subtitle {
        font-size: clamp(1.1rem, 2vw, 1.4rem);
        max-width: 700px;
        margin: 0 auto 50px;
        opacity: 0.9;
        font-weight: 300;
        opacity: 0;
        transform: translateY(30px);
    }

    .hero-subtitle.animate {
        opacity: 0.9;
        transform: translateY(0);
        transition: all 0.8s ease 0.4s;
    }

    .search-container {
        max-width: 600px;
        margin: 0 auto 40px;
        position: relative;
        opacity: 0;
        transform: translateY(30px);
    }

    .search-container.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease 0.6s;
    }

    .search-form {
        display: flex;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 60px;
        overflow: hidden;
        box-shadow: var(--shadow);
        backdrop-filter: blur(10px);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .search-form:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .search-input {
        flex: 1;
        border: none;
        padding: 20px 30px;
        font-size: 16px;
        outline: none;
        background: transparent;
        color: var(--dark);
    }

    .search-input::placeholder {
        color: var(--gray);
    }

    .search-button {
        background: var(--secondary);
        color: var(--white);
        border: none;
        padding: 20px 35px;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: background 0.3s;
        text-transform: uppercase;
    }

    .search-button:hover {
        background: #008a4b;
    }
    
    .hero-links {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
        opacity: 0;
        transform: translateY(30px);
    }
    
    .hero-links.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease 0.8s;
    }
    
    .hero-link {
        color: var(--white);
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        position: relative;
    }

    .hero-link:hover {
        gap: 12px;
        color: var(--secondary);
    }

    /* Stats Section */
    .stats {
        padding: 80px 0;
        background: var(--white);
        position: relative;
        margin-top: -100px;
        z-index: 3;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
        background: var(--white);
        padding: 40px;
        border-radius: 20px;
        box-shadow: var(--shadow);
    }

    .stat-item {
        text-align: center;
        opacity: 0;
        transform: translateY(20px);
    }

    .stat-item.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.6s ease;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Categories Section */
    .categories {
        padding: 100px 0;
        background: var(--light-gray);
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
        opacity: 0;
        transform: translateY(20px);
    }

    .section-header.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease;
    }

    .section-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: var(--primary);
        border-radius: 2px;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 600px;
        margin: 30px auto 0;
        line-height: 1.8;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
    }

    .category-card {
        background: var(--white);
        border-radius: 20px;
        padding: 40px;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s;
        text-decoration: none;
        color: inherit;
        display: block;
        position: relative;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
    }

    .category-card.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.6s ease;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        transform: scaleX(0);
        transition: transform 0.4s;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow);
    }

    .category-card:hover::before {
        transform: scaleX(1);
    }

    .category-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 25px;
        transition: transform 0.3s;
    }

    .category-card:hover .category-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .category-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--dark);
    }

    .category-description {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .category-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .category-count {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
    }

    .category-arrow {
        width: 40px;
        height: 40px;
        background: var(--light-gray);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary);
        transition: all 0.3s;
    }

    .category-card:hover .category-arrow {
        background: var(--primary);
        color: var(--white);
        transform: translateX(5px);
    }

    /* Featured Products */
    .featured {
        padding: 100px 0;
        background: var(--white);
    }

    .featured-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 60px;
        flex-wrap: wrap;
        gap: 20px;
        opacity: 0;
        transform: translateY(20px);
    }

    .featured-header.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease;
    }

    .view-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--primary);
        color: var(--white);
        padding: 12px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: var(--shadow-sm);
    }

    .view-all-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: var(--white);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s;
        border: 1px solid #f0f0f0;
        opacity: 0;
        transform: translateY(30px);
    }

    .product-card.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.6s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow);
    }

    .product-image {
        height: 250px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 4rem;
        opacity: 0.3;
    }

    .product-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: var(--primary);
        color: var(--white);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-content {
        padding: 30px;
    }

    .product-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--dark);
    }

    .product-title a {
        text-decoration: none;
        color: inherit;
        transition: color 0.3s;
    }

    .product-title a:hover {
        color: var(--primary);
    }

    .product-description {
        color: var(--gray);
        line-height: 1.8;
        margin-bottom: 25px;
        font-style: italic;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    .product-price-label {
        font-size: 0.8rem;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 5px;
    }

    .add-to-cart-btn {
        background: var(--secondary);
        color: var(--white);
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .add-to-cart-btn:hover {
        background: #008a4b;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 168, 89, 0.3);
    }

    /* CTA Section */
.cta {
    padding: 100px 0;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    position: relative;
    overflow: hidden;
    margin-bottom: px; /* Tambahkan ini */
}

    .cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://picsum.photos/seed/data/1920/600.jpg') center/cover;
        opacity: 0.1;
    }

    .cta-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: var(--white);
        max-width: 800px;
        margin: 0 auto;
        opacity: 0;
        transform: translateY(20px);
    }

    .cta-content.animate {
        opacity: 1;
        transform: translateY(0);
        transition: all 0.8s ease;
    }

    .cta-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        margin-bottom: 25px;
    }

    .cta-description {
        font-size: 1.2rem;
        margin-bottom: 40px;
        opacity: 0.9;
        line-height: 1.8;
    }

    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .cta-btn {
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .cta-btn-primary {
        background: var(--white);
        color: var(--primary);
        box-shadow: var(--shadow);
    }

    .cta-btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .cta-btn-secondary {
        background: transparent;
        color: var(--white);
        border: 2px solid var(--white);
    }

    .cta-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
    }

    /* Floating Action Button */
    .fab {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: var(--shadow);
        cursor: pointer;
        transition: all 0.3s;
        z-index: 1000;
        opacity: 0;
        transform: scale(0);
    }

    .fab.show {
        opacity: 1;
        transform: scale(1);
    }

    .fab:hover {
        background: var(--primary-dark);
        transform: scale(1.1);
    }

    /* Toast Notification */
    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        transform: translateX(400px);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 9999;
    }

    .toast-notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--secondary);
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats {
            margin-top: -50px;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 30px 20px;
        }
        
        .categories-grid, .products-grid {
            grid-template-columns: 1fr;
        }
        
        .featured-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .hero-links {
            flex-direction: column;
            gap: 15px;
        }

        .fab {
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
        }

        .toast-notification {
            left: 20px;
            right: 20px;
            bottom: 20px;
        }
    }
</style>

<!-- Loading Screen -->
<div class="loading-screen" id="loadingScreen">
    <div class="loader"></div>
</div>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">Portal Layanan Data Resmi</div>
            <h1>Meteorologi, Klimatologi & Geofisika</h1>
            <p class="hero-subtitle">Penyediaan dataset teknis yang akurat untuk mendukung riset, kebijakan publik, dan kebutuhan industri nasional</p>
            
            <div class="search-container">
                <form action="{{ route('search') }}" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Cari dataset atau dokumen..." class="search-input">
                    <button type="submit" class="search-button">Cari Dataset</button>
                </form>
            </div>
            
            <div class="hero-links">
                <a href="{{ route('products.index') }}" class="hero-link">
                    Jelajahi Katalog Lengkap
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#" class="hero-link">
                    Panduan Penggunaan
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4M12 8h.01"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats" style="margin-top: -30px;">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item" data-target="500">
                <div class="stat-number">0</div>
                <div class="stat-label">Dataset Tersedia</div>
            </div>
            <div class="stat-item" data-target="50000">
                <div class="stat-number">0</div>
                <div class="stat-label">Pengguna Aktif</div>
            </div>
            <div class="stat-item" data-target="24">
                <div class="stat-number">0</div>
                <div class="stat-label">Layanan Support</div>
            </div>
            <div class="stat-item" data-target="99.9">
                <div class="stat-number">0</div>
                <div class="stat-label">Uptime Server</div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Klasifikasi Data BMKG</h2>
            <p class="section-subtitle">Temukan dataset yang sesuai dengan kebutuhan spesifik Anda melalui klasifikasi berdasarkan bidang ilmu</p>
        </div>
        
        <div class="categories-grid">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="category-card">
                <div class="category-icon">{{ $category->icon }}</div>
                <h3 class="category-title">{{ $category->name }}</h3>
                <p class="category-description">{{ $category->description }}</p>
                <div class="category-footer">
                    <span class="category-count">{{ $category->active_products_count }} Dataset Tersedia</span>
                    <div class="category-arrow">→</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured">
    <div class="container">
        <div class="featured-header">
            <div>
                <h2 class="section-title">Produk Unggulan BMKG</h2>
                <p class="section-subtitle">Dataset premium dengan standar kalibrasi internasional</p>
            </div>
            <a href="{{ route('products.index') }}" class="view-all-btn">
                Lihat Semua Produk
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <div class="product-card">
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="product-icon">{{ $product->category->icon ?? '📊' }}</div>
                    @endif
                    <div class="product-badge">{{ $product->category->name }}</div>
                </div>
                
                <div class="product-content">
                    <h3 class="product-title">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    
                    <p class="product-description">{{ Str::limit($product->description, 120) }}</p>
                    
                    <div class="product-footer">
                        <div>
                            <span class="product-price-label">Harga Layanan</span>
                            <span class="product-price">{{ $product->formattedPrice() }}</span>
                        </div>
                        <button onclick="addToCart({{ $product->id }})" class="add-to-cart-btn">Beli Data</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Mulai Mengakses Data Berkualitas</h2>
            <p class="cta-description">Daftar sekarang untuk mendapatkan akses ke repositori data BMKG melalui skema lisensi resmi</p>
            
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="cta-btn cta-btn-primary">
                    Buat Akun Sekarang
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                </a>
                <a href="{{ route('pricing.index') }}" class="cta-btn cta-btn-secondary">
                    Lihat Paket & Harga
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Floating Action Button -->
<div class="fab" id="fab">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 2v20M17 7l-5-5-5 5M17 17l-5 5-5-5"/>
    </svg>
</div>

@endsection

@push('scripts')
<script>
// Loading Screen
window.addEventListener('load', () => {
    setTimeout(() => {
        document.getElementById('loadingScreen').classList.add('hidden');
        initializeAnimations();
    }, 800);
});

// Initialize animations
function initializeAnimations() {
    // Hero animations
    const heroBadge = document.querySelector('.hero-badge');
    const heroTitle = document.querySelector('.hero h1');
    const heroSubtitle = document.querySelector('.hero-subtitle');
    const searchContainer = document.querySelector('.search-container');
    const heroLinks = document.querySelector('.hero-links');
    
    if (heroBadge) heroBadge.classList.add('animate');
    if (heroTitle) heroTitle.classList.add('animate');
    if (heroSubtitle) heroSubtitle.classList.add('animate');
    if (searchContainer) searchContainer.classList.add('animate');
    if (heroLinks) heroLinks.classList.add('animate');
    
    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                
                // Count animation for stats
                if (entry.target.classList.contains('stat-item')) {
                    const target = parseFloat(entry.target.dataset.target);
                    const numberElement = entry.target.querySelector('.stat-number');
                    animateNumber(numberElement, target);
                }
            }
        });
    }, observerOptions);
    
    // Observe elements - MENAMBAHKAN .featured-header KE DAFTAR ELEMEN YANG DIAMATI
    document.querySelectorAll('.section-header, .featured-header, .category-card, .product-card, .stat-item, .cta-content').forEach(el => {
        observer.observe(el);
    });
}

// Number counting animation
function animateNumber(element, target) {
    const duration = 2000;
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        
        if (target === 99.9) {
            element.textContent = current.toFixed(1) + '%';
        } else if (target < 100) {
            element.textContent = Math.floor(current);
        } else {
            element.textContent = Math.floor(current).toLocaleString() + '+';
        }
    }, 16);
}

// Floating Action Button
const fab = document.getElementById('fab');

// Show/hide FAB on scroll
window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        fab.classList.add('show');
    } else {
        fab.classList.remove('show');
    }
});

// Scroll to top when FAB is clicked
fab.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Toast notification system
function showToast(message, type = 'success') {
    // Remove existing toast if any
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) {
        existingToast.remove();
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    
    // Set icon based on type
    let iconSvg = '';
    let color = '';
    
    if (type === 'success') {
        iconSvg = `
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        `;
        color = 'var(--secondary)';
    } else if (type === 'error') {
        iconSvg = `
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        `;
        color = 'var(--accent)';
    }
    
    toast.innerHTML = `
        <div class="toast-content" style="color: ${color}">
            ${iconSvg}
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Show toast with animation
    setTimeout(() => {
        toast.classList.add('show');
    }, 100);
    
    // Hide and remove toast after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Add to cart function
function addToCart(productId) {
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Menambahkan...';
    button.disabled = true;
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
        if(data.success) {
            showToast('Dataset telah ditambahkan ke permohonan Anda.', 'success');
            
            // Update cart badge if function exists
            if (typeof updateCartBadge === "function") {
                updateCartBadge();
            }
        } else {
            showToast(data.message || 'Terjadi kesalahan saat menambahkan dataset.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
    })
    .finally(() => {
        // Reset button state
        button.textContent = originalText;
        button.disabled = false;
    });
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endpush