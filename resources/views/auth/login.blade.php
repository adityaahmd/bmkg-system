<x-guest-layout>
    <div class="flex flex-col md:flex-row min-h-screen w-full overflow-hidden">
        
        <div class="hidden md:flex md:w-3/5 bg-[#003366] relative p-16 flex-col justify-between text-white overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#003366] via-[#004a99] to-[#00a859] opacity-90"></div>
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('img/bmkg.png') }}" alt="Logo BMKG" class="h-20 drop-shadow-2xl">
                    <div class="h-12 w-[1px] bg-white/20"></div>
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight">BMKG</h2>
                        <p class="text-[10px] uppercase tracking-[0.3em] opacity-70">Official Data Portal</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10">
                <h1 class="text-7xl font-black leading-none mb-6">
                    Selamat datang,<br>
                    <span class="text-[#4ade80]">Sahabat Data!</span>
                </h1>
                <p class="text-xl text-blue-50/80 max-w-xl leading-relaxed font-light">
                    Akses dataset meteorologi, klimatologi, dan geofisika terlengkap untuk mendukung inovasi dan riset Anda.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-4 text-sm font-medium opacity-60">
                <span class="flex h-2 w-2 rounded-full bg-green-400 animate-pulse"></span>
                Sistem Layanan Data Terpadu
            </div>
        </div>

        <div class="w-full md:w-2/5 flex items-center justify-center p-8 md:p-20 bg-white">
            <div class="w-full max-w-md">
                
                <div class="md:hidden flex flex-col items-center mb-10">
                    <img src="{{ asset('img/bmkg.png') }}" alt="Logo BMKG" class="h-20 mb-4">
                    <h2 class="text-3xl font-bold text-[#003366]">BMKG Data</h2>
                </div>

                <div class="mb-10 text-left">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">Login</h2>
                    <p class="text-gray-500 font-medium">Silakan masuk menggunakan akun Anda.</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="text-left">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2 ml-1">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-[#003366] transition-all outline-none font-medium" 
                            placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="text-left" x-data="{ show: false }">
                        <div class="flex justify-between items-center mb-2 px-1">
                            <label for="password" class="text-sm font-bold text-gray-700">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-blue-600 hover:underline" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input id="password" :type="show ? 'text' : 'password'" name="password" required 
                                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-[#003366] transition-all outline-none font-medium" 
                                placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#003366]">
                                <svg x-show="!show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.076m3.113-3.113A9.978 9.978 0 0112 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-1.274 0-2.454-.256-3.512-.72m-4.709-4.709L3 3l18 18" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 text-[#003366] border-gray-300 rounded-lg focus:ring-[#003366] cursor-pointer">
                        <label for="remember_me" class="ml-3 text-sm text-gray-600 font-medium cursor-pointer select-none">Ingat perangkat ini</label>
                    </div>

                    <button type="submit" class="w-full bg-[#003366] hover:bg-[#00254a] text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-900/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        <span>Masuk ke Akun</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>

                    <p class="text-center text-gray-600 font-medium">
                        Belum memiliki akun? <a href="{{ route('register') }}" class="text-[#00a859] hover:underline font-bold">Daftar Sekarang</a>
                    </p>
                </form>

                <div class="mt-20 text-center">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-loose">
                        &copy; {{ date('Y') }} Badan Meteorologi, Klimatologi, dan Geofisika<br>Republik Indonesia
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>