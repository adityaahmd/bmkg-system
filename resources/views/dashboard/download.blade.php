{{-- resources/views/dashboard/downloads.blade.php --}}
@extends('layouts.app')

@section('title', 'Download Center - BMKG')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">Download Center</h1>
        <p class="text-gray-600">Akses data yang telah Anda beli</p>
    </div>

    @if($downloads->isEmpty())
        <div class="card p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Belum Ada Data</h2>
            <p class="text-gray-600 mb-6">Anda belum memiliki data yang bisa didownload</p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                Jelajahi Produk
            </a>
        </div>
    @else
        <div class="card overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4">Nama File</th>
                        <th class="text-left py-3 px-4">Produk</th>
                        <th class="text-center py-3 px-4">Tanggal</th>
                        <th class="text-center py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($downloads as $download)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium">{{ $download->file_name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">{{ $download->product->name }}</td>
                        <td class="py-3 px-4 text-center text-sm">
                            {{ $download->downloaded_at->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                Download
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $downloads->links() }}
        </div>
    @endif
</div>
@endsection