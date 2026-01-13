@extends('layouts.admin')

@section('title', 'Tambah Paket Layanan')

@section('content')
<div class="max-w-5xl mx-auto">

    <h3 class="text-3xl font-semibold text-gray-800 mb-6">
        Buat Paket Baru
    </h3>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-md p-8">
        <form action="{{ route('admin.pricing-plans.store') }}" method="POST">
            @csrf

            {{-- BASIC INFO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Paket
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                           placeholder="Contoh: Startup"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Limit Download
                    </label>
                    <input type="number"
                           name="download_limit"
                           value="{{ old('download_limit') }}"
                           class="w-full border rounded-lg px-4 py-2"
                           placeholder="Kosongkan untuk unlimited">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga Bulanan (Rp)
                    </label>
                    <input type="number"
                           name="price_monthly"
                           value="{{ old('price_monthly') }}"
                           class="w-full border rounded-lg px-4 py-2"
                           placeholder="0 untuk gratis">
                    <p class="text-xs text-gray-500 mt-1">
                        Isi 0 jika paket gratis
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga Tahunan (Rp)
                    </label>
                    <input type="number"
                           name="price_yearly"
                           value="{{ old('price_yearly') }}"
                           class="w-full border rounded-lg px-4 py-2"
                           placeholder="Opsional">
                </div>

            </div>

            {{-- FEATURES --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Daftar Fitur Paket
                </label>

                <div id="feature-container" class="space-y-3">
                    <div class="flex gap-2">
                        <input type="text"
                               name="features[]"
                               class="flex-1 border rounded-lg px-4 py-2"
                               placeholder="Contoh: Akses data cuaca harian"
                               required>
                        <button type="button"
                                onclick="removeFeature(this)"
                                class="text-red-500 hover:text-red-700 text-sm">
                            Hapus
                        </button>
                    </div>
                </div>

                <button type="button"
                        onclick="addFeature()"
                        class="mt-3 text-blue-600 text-sm font-semibold hover:underline">
                    + Tambah fitur
                </button>
            </div>

            {{-- POPULAR --}}
            <div class="flex items-center mb-8">
                <input type="checkbox"
                       name="is_popular"
                       value="1"
                       id="is_popular"
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                <label for="is_popular" class="ml-2 text-sm text-gray-700">
                    Tandai sebagai paket <strong>Popular</strong>
                </label>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.pricing-plans.index') }}"
                   class="px-4 py-2 rounded-lg text-gray-600 hover:text-gray-800">
                    Batal
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                    Simpan Paket
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addFeature() {
    const container = document.getElementById('feature-container');

    const div = document.createElement('div');
    div.className = 'flex gap-2';

    div.innerHTML = `
        <input type="text" name="features[]" class="flex-1 border rounded-lg px-4 py-2"
               placeholder="Fitur lainnya..." required>
        <button type="button"
                onclick="removeFeature(this)"
                class="text-red-500 hover:text-red-700 text-sm">
            Hapus
        </button>
    `;

    container.appendChild(div);
}

function removeFeature(button) {
    button.parentElement.remove();
}
</script>
@endpush
