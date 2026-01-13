@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-gray-700 text-3xl font-medium">Paket Langganan</h3>
        <a href="{{ route('admin.pricing-plans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Tambah Paket
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plans as $plan)
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 {{ $plan->is_popular ? 'border-blue-500 shadow-xl' : 'border-gray-300' }}">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <h4 class="text-xl font-bold text-gray-800">{{ $plan->name }}</h4>
                    @if($plan->is_popular)
                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded">Populer</span>
                    @endif
                </div>
                
                <div class="mt-4">
                    <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($plan->price_monthly, 0, ',', '.') }}</span>
                    <span class="text-gray-500 text-sm">/ bulan</span>
                </div>

                <ul class="mt-6 space-y-3">
                    <li class="flex items-center text-sm text-gray-600">
                        <span class="mr-2 text-green-500">✔</span> 
                        Limit: {{ $plan->download_limit ?? 'Tanpa Batas' }} Download
                    </li>
                    @if(is_array($plan->features))
                        @foreach($plan->features as $feature)
                        <li class="flex items-center text-sm text-gray-600">
                            <span class="mr-2 text-green-500">✔</span> {{ $feature }}
                        </li>
                        @endforeach
                    @endif
                </ul>

                <div class="mt-8 pt-6 border-t flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ $plan->user_profiles_count }} Pengguna</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.pricing-plans.edit', $plan->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Edit</a>
                        <form action="{{ route('admin.pricing-plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection