@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin BMKG')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-gray-800 text-3xl font-bold">Tambah Produk Baru</h3>
        <a href="{{ route('admin.products.index') }}" class="text-blue-900 hover:text-blue-700 font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition @error('name') border-red-500 @enderror" 
                           placeholder="Masukkan nama produk..." required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tipe</label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none">
                            <option value="gratis" {{ old('type') == 'gratis' ? 'selected' : '' }}>Gratis</option>
                            <option value="premium" {{ old('type') == 'premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none">
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Thumbnail (Gambar)</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">File Produk (.zip, .pdf)</label>
                    <input type="file" name="product_file" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Produk</label>
                <textarea name="description" rows="5" 
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none transition" 
                          placeholder="Jelaskan detail produk di sini...">{{ old('description') }}</textarea>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-900 text-white px-10 py-3 rounded-xl font-bold hover:bg-blue-800 shadow-lg transform transition active:scale-95">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection