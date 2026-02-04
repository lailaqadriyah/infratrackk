<aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full font-sans">
    <div class="p-6">
        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</h2>
        <nav class="mt-4 space-y-1">
            
           {{-- Dropdown Visualisasi (Selalu Terbuka) --}}
            <div x-data="{ open: true }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-lg transition-all duration-300 {{ (request()->routeIs('user.rkpd.*') || request()->routeIs('user.renja.*')) ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                        <span class="font-medium text-sm">Visualisasi</span>
                    </div>
                </button>
                
                <div x-show="open" class="mt-1 ml-4 space-y-1 border-l-2 border-gray-100 pl-4">
                    
                    {{-- Dashboard Renja --}}
                    <a href="{{ route('user.renja.index') }}" 
                       class="block px-4 py-2 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('user.renja.*') ? 'text-blue-600 font-bold bg-blue-50' : 'text-gray-500 hover:text-blue-600 hover:bg-gray-50' }}">
                        Dashboard Renja
                    </a>

                    {{-- Dashboard RKPD (Warna akan pindah ke sini jika diklik) --}}
                    <a href="{{ route('user.rkpd.index') }}" 
                       class="block px-4 py-2 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('user.rkpd.*') ? 'text-blue-600 font-bold bg-blue-50' : 'text-gray-500 hover:text-blue-600 hover:bg-gray-50' }}">
                        Dashboard RKPD
                    </a>
                </div>
            </div>

            {{-- Feedback --}}
            <a href="{{ route('user.feedback.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-gray-600 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <span class="font-medium text-sm">Kirim Feedback</span>
            </a>
        </nav>
    </div>

    {{-- Profil Bawah --}}
    <div class="mt-auto p-4 border-t border-gray-100 bg-gray-50/50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Keluar</span>
            </button>
        </form>
        <div class="flex items-center gap-3 px-2 py-2">
            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-[10px] font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[9px] text-gray-500 uppercase tracking-tighter font-bold">Masyarakat</p>
            </div>
        </div>
    </div>
</aside>