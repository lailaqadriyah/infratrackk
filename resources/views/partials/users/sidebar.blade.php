<aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full">
    <div class="p-6">
        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</h2>
        <nav class="mt-4 space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <div class="px-4 py-2">
    <a href="{{ route('user.renja.dashboard') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.renja.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-600 hover:bg-gray-100' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        <span class="font-medium">Dashboard RENJA</span>
    </a>
</div>

            {{-- Feedback (Active) --}}
            <a href="{{ route('feedback.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('feedback.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <span class="font-medium">Kirim Feedback</span>
            </a>
        </nav>
    </div>

    {{-- Bagian Bawah (Profil Singkat) --}}
    <div class="mt-auto p-4 border-t border-gray-100">
        <div class="flex items-center gap-3 px-2 py-3">
            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-blue-600 to-green-500 flex items-center justify-center text-white text-xs font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">Masyarakat</p>
            </div>
        </div>
    </div>
</aside>