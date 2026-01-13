@extends('layouts.admin')

@section('title', 'Manajemen Produk - Admin BMKG')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-semibold transition">
        + Tambah Produk Baru
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
    <p class="font-bold text-sm">Berhasil!</p>
    <p class="text-sm">{{ session('success') }}</p>
</div>
@endif

<div class="bg-white p-6 rounded-xl shadow-sm mb-6 border border-gray-100">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap md:flex-nowrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" placeholder="Cari nama atau deskripsi..." 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        
        <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">Semua Status</option>
            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
        
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800 transition">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-100 text-gray-600 hover:bg-gray-200 px-6 py-2 rounded-lg font-semibold transition">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase">Produk</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase">Kategori</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase text-right">Harga</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase text-center">Tipe/Status</th>
                    <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                            <div>
                                <div class="font-bold text-gray-800 text-sm">{{ $product->name }}</div>
                                <div class="text-[10px] text-gray-500">ID: #{{ $product->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-600">
                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                    </td>
                    <td class="py-4 px-6 text-right font-bold text-sm text-gray-700">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-col items-center gap-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $product->type === 'gratis' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $product->type }}
                            </span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $product->status === 'published' ? 'bg-blue-100 text-blue-700' : ($product->status === 'draft' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ $product->status }}
                            </span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex justify-center items-center space-x-3">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-gray-400 hover:text-yellow-500 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400 text-sm">Tidak ada produk ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $products->appends(request()->query())->links() }}
</div>
@endsection