<aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full font-sans">
    <div class="p-6">
        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</h2>
        <nav class="mt-4 space-y-1">
            
            {{-- Dropdown Visualisasi --}}
            {{-- Logika x-data open memastikan dropdown otomatis terbuka jika berada di halaman renja atau rkpd --}}
            <div x-data="{ open: {{ request()->routeIs('user.renja.*', 'user.rkpd.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                    class="flex items-center justify-between w-full p-3 rounded-lg transition-colors {{ request()->routeIs('user.renja.*', 'user.rkpd.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="font-medium">Visualisasi</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-cloak class="mt-2 ml-8 space-y-1">
                    {{-- Dashboard RENJA --}}
                    <a href="{{ route('user.renja.index') }}" 
                        class="block p-2 rounded-md text-sm transition-colors {{ request()->routeIs('user.renja.index') ? 'text-blue-700 font-bold bg-blue-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        Dashboard RENJA
                    </a>
                    
                    {{-- Dashboard RKPD --}}
                    <a href="{{ route('user.rkpd.index') }}" 
                        class="block p-2 rounded-md text-sm transition-colors {{ request()->routeIs('user.rkpd.index') ? 'text-blue-700 font-bold bg-blue-50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        Dashboard RKPD
                    </a>
                </div>
            </div>

            {{-- Feedback --}}
            <a href="{{ route('feedback.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('feedback.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">
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