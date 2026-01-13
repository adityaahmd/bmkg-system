<nav class="bg-white shadow-md relative z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('img/bmkg.png') }}" alt="Logo BMKG" class="h-12 w-auto transition-transform group-hover:scale-105">
                    <div class="flex flex-col">
                        <span class="text-xl font-bold leading-none" style="color: #003366">BMKG DATA SERVICE</span>
                        <span class="text-[10px] font-medium tracking-widest uppercase opacity-70">Official Data Portal</span>
                    </div>
                </a>
                
                <div class="hidden md:flex space-x-6 border-l pl-8 border-gray-100">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-900 font-medium transition">Beranda</a>
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-blue-900 font-medium transition">Layanan</a>
                    <a href="{{ route('pricing.index') }}" class="text-gray-600 hover:text-blue-900 font-medium transition">Pricing</a>
                </div>
            </div>
            
            <div class="flex items-center space-x-5">
                <button onclick="toggleSearch()" class="text-gray-500 hover:text-blue-900 transition p-2 hover:bg-gray-50 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                
                <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-blue-900 transition p-2 hover:bg-gray-50 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span id="cart-badge" class="absolute top-0 right-0 bg-red-600 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white shadow-sm" style="display: none;">0</span>
                </a>
                
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 text-gray-700 hover:text-blue-900 focus:outline-none p-1 pr-3 rounded-full hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                            <img src="{{ (Auth::user()->profile && Auth::user()->profile->avatar) ? Storage::url(Auth::user()->profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=003366&color=fff' }}" 
                                 alt="Avatar" class="w-8 h-8 rounded-full border shadow-sm object-cover">
                            <span class="hidden md:inline font-semibold text-sm">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-2xl py-2 border border-gray-100 overflow-hidden">
                            
                            <div class="px-4 py-2 bg-gray-50 border-bottom mb-2">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Status Login</p>
                                <p class="text-xs font-bold text-blue-900 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-900">Dashboard Utama</a>
                            <a href="{{ route('dashboard.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-900">Pesanan Saya</a>
                            <a href="{{ route('dashboard.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-900">Profil Saya</a>
                            
                            @if(Auth::user()->isAdmin())
                                <div class="border-t border-gray-50 my-2"></div>
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-blue-700 bg-blue-50 hover:bg-blue-100 font-bold">Admin Panel</a>
                            @endif
                            
                            <div class="border-t border-gray-50 my-2"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition">
                                    Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-900 font-semibold px-4 py-2 transition text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-blue-900 text-white px-5 py-2.5 rounded-xl hover:bg-blue-800 transition text-sm font-bold shadow-lg shadow-blue-900/20 active:scale-95">Daftar Sekarang</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    
    <div id="search-bar" class="hidden bg-white border-t border-gray-100 shadow-inner">
        <div class="container mx-auto px-4 py-6">
            <form action="{{ route('search') }}" method="GET" class="flex relative max-w-4xl mx-auto">
                <input type="text" name="q" placeholder="Cari data cuaca, iklim, geofisika, atau dataset lainnya..." 
                       class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-900 transition-all text-gray-700 shadow-sm">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="absolute right-2 top-2 bottom-2 bg-blue-900 text-white px-8 rounded-xl hover:bg-blue-800 transition font-bold shadow-md">Cari Data</button>
            </form>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // Toggle Search Bar
    function toggleSearch() {
        const searchBar = document.getElementById('search-bar');
        searchBar.classList.toggle('hidden');
        if(!searchBar.classList.contains('hidden')) {
            searchBar.querySelector('input').focus();
        }
    }
    
    // Update Cart Badge
    function updateCartBadge() {
        fetch('/api/cart/count')
            .then(res => res.ok ? res.json() : {count: 0})
            .then(data => {
                const badge = document.getElementById('cart-badge');
                if(badge) {
                    const count = data.count || 0;
                    badge.textContent = count;
                    // Sembunyikan badge jika 0 agar lebih bersih
                    badge.style.setProperty('display', (count > 0) ? 'flex' : 'none', 'important');
                }
            })
            .catch(() => console.log('Cart API not ready yet'));
    }
    
    document.addEventListener('DOMContentLoaded', updateCartBadge);
</script>
@endpush