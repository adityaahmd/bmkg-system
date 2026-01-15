<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold flex items-center">
                    ← Kembali ke Daftar Pesanan
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-extrabold text-blue-900">Detail Pesanan #{{ $order->order_number }}</h2>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase">
                        {{ $order->payment_status }}
                    </span>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Pemesan</h3>
                        <div class="space-y-3">
                            <p class="text-gray-900 font-medium">{{ $order->customer_name }}</p>
                            <p class="text-gray-600 text-sm">{{ $order->customer_email }}</p>
                            <p class="text-gray-600 text-sm">{{ $order->customer_phone }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Ringkasan Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-blue-900 text-lg border-t border-gray-200 pt-2 mt-2">
                                <span>Total Tagihan</span>
                                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>