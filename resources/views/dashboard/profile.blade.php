{{-- resources/views/dashboard/profile.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Saya - BMKG')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">Profil Saya</h1>
        <p class="text-gray-600">Kelola informasi profil Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card p-6">
            <div class="text-center">
                <img src="{{ $user->profile->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200' }}" 
                     alt="Avatar" class="w-32 h-32 rounded-full mx-auto mb-4">
                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                
                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-600">Paket Saat Ini:</p>
                    <p class="font-bold text-blue-900">{{ $user->profile->pricingPlan->name ?? 'GRATIS' }}</p>
                </div>

                @if($user->role !== 'admin')
                <a href="{{ route('pricing.index') }}" class="btn-primary w-full mt-4 block">
                    Upgrade Paket
                </a>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="card p-6">
                <h3 class="text-xl font-bold mb-6">Informasi Profil</h3>

                {{-- PERBAIKAN: Nama route disesuaikan dengan dashboard.profile.update --}}
                <form action="{{ route('dashboard.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama Lengkap *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900" required>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Email</label>
                            <input type="email" value="{{ $user->email }}" 
                                   class="w-full px-4 py-2 border rounded-lg bg-gray-100" disabled>
                            <p class="text-xs text-gray-600 mt-1">Email tidak dapat diubah</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">No. Telepon</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Perusahaan/Institusi</label>
                            <input type="text" name="company" value="{{ old('company', $user->profile->company ?? '') }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900">
                            @error('company')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Alamat</label>
                            <textarea name="address" rows="3" 
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-900">{{ old('address', $user->profile->address ?? '') }}</textarea>
                            @error('address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <button type="submit" class="btn-primary">
                            Simpan Perubahan
                        </button>
                        {{-- PERBAIKAN: Nama route disesuaikan dengan dashboard.index --}}
                        <a href="{{ route('dashboard.index') }}" class="px-6 py-3 bg-gray-200 rounded-lg font-semibold hover:bg-gray-300">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection