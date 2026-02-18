<x-guest-layout>
<div class="flex flex-col items-center justify-center text-center mb-10">
        <div class="mb-6">
            {{-- Sesuaikan URL logo dengan yang ada di login.blade.php --}}
            <img src="{{ asset('images/logo-infraplan.png') }}" alt="Logo InfraPlan" class="h-24 w-auto mx-auto object-contain">
        </div>

        <h2 class="text-4xl font-extrabold mb-10 tracking-tight text-gray-900">InfraPlan</h2>
        
        <p class="text-gray-600 text-base font-semibold leading-relaxed max-w-md mx-auto uppercase tracking-normal">
            Lupa Kata Sandi? <br>
            <span class="text-sm font-medium normal-case tracking-wide text-gray-500">
                Masukkan email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi.
            </span>
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- Tombol diubah menjadi warna biru (bg-blue-600) agar senada dengan halaman login --}}
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.02]">
                {{ __('Kirim Tautan Reset Kata Sandi') }}
            </button>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                Kembali ke Halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>
