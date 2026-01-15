<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold text-blue-900 tracking-tight">
                Buat Akun Baru
            </h2>
            <p class="text-sm text-gray-500 mt-2">Daftar untuk mengakses layanan data portal</p>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden sm:rounded-2xl">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-input-label for="name" class="text-xs font-semibold uppercase tracking-wider text-gray-600" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" class="block mt-1.5 w-full bg-gray-50 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama sesuai KTP" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
                </div>

                <div class="mt-5">
                    <x-input-label for="email" class="text-xs font-semibold uppercase tracking-wider text-gray-600" :value="__('Email Instansi/Pribadi')" />
                    <x-text-input id="email" class="block mt-1.5 w-full bg-gray-50 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                </div>

                <div class="mt-5">
                    <x-input-label for="password" class="text-xs font-semibold uppercase tracking-wider text-gray-600" :value="__('Kata Sandi')" />
                    <x-text-input id="password" class="block mt-1.5 w-full bg-gray-50 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" type="password" name="password" required placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                </div>

                <div class="mt-5">
                    <x-input-label for="password_confirmation" class="text-xs font-semibold uppercase tracking-wider text-gray-600" :value="__('Konfirmasi Kata Sandi')" />
                    <x-text-input id="password_confirmation" class="block mt-1.5 w-full bg-gray-50 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" type="password" name="password_confirmation" required placeholder="Ulangi kata sandi Anda" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 uppercase tracking-widest">
                        {{ __('Daftar Sekarang') }}
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Sudah punya akun?') }}
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-500 transition-colors underline decoration-2 underline-offset-4">
                            {{ __('Masuk di sini') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} BMKG Data Service Portal. All rights reserved.
        </div>
    </div>
</x-guest-layout>