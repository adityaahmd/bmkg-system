@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <h3 class="text-gray-700 text-3xl font-medium">Laporan Analitik</h3>
        
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center mt-4 md:mt-0">
            <select name="period" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>1 Tahun Terakhir</option>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <p class="text-sm text-gray-500 uppercase font-bold">User Baru</p>
            <p class="text-2xl font-semibold text-gray-800">{{ $userData['new_users'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <p class="text-sm text-gray-500 uppercase font-bold">User Aktif</p>
            <p class="text-2xl font-semibold text-gray-800">{{ $userData['active_users'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
            <p class="text-sm text-gray-500 uppercase font-bold">Total User Sistem</p>
            <p class="text-2xl font-semibold text-gray-800">{{ $userData['total_users'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-bold text-gray-700">10 Produk Terlaris</h4>
                <a href="{{ route('admin.reports.export', ['type' => 'sales', 'period' => $period, 'format' => 'pdf']) }}" class="text-sm text-blue-600 hover:underline">Export PDF</a>
            </div>
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Produk</th>
                        <th class="py-2">Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesData as $product)
                    <tr class="border-b">
                        <td class="py-3">{{ $product->name }}</td>
                        <td class="py-3 font-bold">{{ $product->order_items_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-bold text-gray-700">Pendapatan</h4>
                <a href="{{ route('admin.reports.export', ['type' => 'revenue', 'period' => $period, 'format' => 'excel']) }}" class="text-sm text-green-600 hover:underline">Export Excel</a>
            </div>
            <div class="space-y-4">
                @foreach($revenueData as $rev)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ $rev->date }}</span>
                    <span class="text-sm font-bold text-gray-800">Rp {{ number_format($rev->total) }}</span>
                </div>
                @endforeach
                @if($revenueData->isEmpty())
                    <p class="text-center text-gray-400 py-10">Tidak ada data transaksi</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection