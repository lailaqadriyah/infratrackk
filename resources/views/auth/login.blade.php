<x-guest-layout>
    <div class="flex flex-col items-center justify-center text-center mb-10">
        <div class="mb-6">
            <img src="images/logo-infraplan.png" alt="Logo InfraPlan" class="h-24 w-auto mx-auto object-contain">
        </div>

        <h2 class="text-4xl font-extrabold mb-3 tracking-tight text-gray-900">InfraPlan</h2>
        
        <p class="text-gray-600 text-base font-semibold leading-relaxed max-w-md mx-auto uppercase tracking-normal">
            Sistem Informasi Perencanaan dan Anggaran Publik<br>
            <span class="text-gray-600 font-medium italic">BAPPEDA Provinsi Sumatera Barat</span>
        </p>
    </div>

    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl shadow-blue-500/5 border border-gray-300 max-w-lg mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-gray-900 mb-1 tracking-tight">Login</h1>
            <p class="text-gray-500 text-sm font-medium">Silakan masuk ke akun Anda</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-bold text-xs mb-2 text-left uppercase tracking-wider" />
                <x-text-input id="email" class="block w-full border-gray-200 focus:border-blue-600 focus:ring-blue-600 rounded-xl p-4 text-sm bg-gray-50/50 shadow-sm transition-all" 
                                type="email" name="email" :value="old('email')" 
                                required autofocus autocomplete="username" 
                                placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold text-xs mb-2 text-left uppercase tracking-wider" />
                <x-text-input id="password" class="block w-full border-gray-200 focus:border-blue-600 focus:ring-blue-600 rounded-xl p-4 text-sm bg-gray-50/50 shadow-sm transition-all"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between py-1">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 shadow-sm cursor-pointer" name="remember">
                    <span class="ms-2 text-xs text-gray-600 group-hover:text-gray-900 transition-colors font-medium">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs text-blue-600 hover:text-blue-800 font-bold transition-all hover:underline" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-4 px-8 border border-transparent rounded-xl shadow-lg text-base font-black text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 transform hover:scale-[1.01]">
                    {{ __('Login Sekarang') }}
                </button>
            </div>

            <div class="text-center pt-6 border-t border-gray-100 mt-6">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-black transition-all ml-1 underline decoration-2 underline-offset-4">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>