<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - BMKG')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1d3693;
            --primary-darker: #1e3a8a;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --hover-bg: rgba(255, 255, 255, 0.1);
            --active-bg: rgba(255, 255, 255, 0.15);
            --border-color: rgba(255, 255, 255, 0.15);
        }
        
        .admin-sidebar {
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-darker) 100%);
            backdrop-filter: blur(10px);
        }
        
        .sidebar-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
        }
        
        .sidebar-item:hover {
            background-color: var(--hover-bg);
            transform: translateX(2px);
        }
        
        .sidebar-item.active {
            background-color: var(--active-bg);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
        }
        
        .topbar {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .content-container {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="admin-sidebar w-64 text-white flex-shrink-0">
            <div class="p-6 border-b border-white/15">
                <h2 class="text-xl font-bold tracking-tight">BMKG Admin</h2>
                <p class="text-xs text-blue-100 mt-1">Dashboard Panel</p>
            </div>
            
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="sidebar-item flex items-center px-4 py-3 {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="font-medium">Produk</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center px-4 py-3 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="font-medium">Pesanan</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-medium">Users</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="sidebar-item flex items-center px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="font-medium">Kategori</span>
                </a>
                
                <a href="{{ route('admin.pricing-plans.index') }}" class="sidebar-item flex items-center px-4 py-3 {{ request()->routeIs('admin.pricing-plans.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">Pricing Plans</span>
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="sidebar-item flex items-center px-4 py-3 {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="font-medium">Laporan</span>
                </a>
                
                <hr class="border-white/15 my-4">
                
                <a href="{{ route('home') }}" class="sidebar-item flex items-center px-4 py-3">
                    <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span class="font-medium">Lihat Website</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="sidebar-item flex items-center w-full px-4 py-3 text-left">
                        <svg class="w-5 h-5 mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <div class="topbar p-4 flex justify-between items-center">
                <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Admin Dashboard')</h1>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                    <img src="{{ Auth::user()->profile->avatar ? Storage::url(Auth::user()->profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                         alt="Avatar" class="w-8 h-8 rounded-full border-2 border-gray-200">
                </div>
            </div>
            
            <!-- Content -->
            <div class="content-container p-6">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="card p-6">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>

