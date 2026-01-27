<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('page-title', 'Default Title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            {{-- Sidebar --}}
            <aside x-data="{ openMenus: ['visualisasi'] }" class="w-64 bg-white border-r border-gray-200 h-screen flex flex-col fixed left-0 top-0 z-20 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-br from-blue-600 to-green-600 rounded-lg shadow-md">
                            {{-- Icon Home sesuai Figma --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-bold text-gray-900 tracking-tight">InfraTrack</h1>
                            <p class="text-xs text-gray-600">BAPPEDA Sumbar</p>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                    <ul class="space-y-1">
                        
                        <li>
                            <button 
                                @click="openMenus.includes('visualisasi') ? openMenus = openMenus.filter(i => i !== 'visualisasi') : openMenus.push('visualisasi')"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors {{ request()->is('dashboard-*') ? 'bg-gradient-to-r from-blue-50 to-green-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor font-medium"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                    <span class="font-medium">Visualisasi</span>
                                </div>
                                <svg :class="openMenus.includes('visualisasi') ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            
                            <ul x-show="openMenus.includes('visualisasi')" x-transition class="mt-1 ml-4 space-y-1">
                                <li>
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                                        <span>Dashboard RENJA</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                                        <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                                        <span>Dashboard RKPD</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-current"></div>
                                        <span>Dashboard APBD</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('feedback.index') }}" 
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('feedback.index') ? 'bg-gradient-to-r from-blue-50 to-green-50 text-blue-700 shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                                <span class="font-medium">Feedback</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('feedback.history') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors text-gray-700 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="font-medium">History Feedback</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="p-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors text-red-600 hover:bg-red-50 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                    <p class="text-[10px] text-gray-500 text-center mt-3 uppercase tracking-wider">
                        © 2026 InfraTrackk
                    </p>
                </div>
            </aside>

            {{-- Overlay untuk mobile --}}
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden hidden" onclick="toggleSidebar()"></div>

            {{-- Overlay untuk mobile --}}
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 md:hidden hidden" onclick="toggleSidebar()"></div>

            {{-- Main Content --}}
            <div class="flex-1 flex flex-col md:ml-64">
                {{-- Top Navigation --}}
                <header class="fixed top-0 left-0 md:left-64 right-0 bg-white shadow-sm border-b z-20 border-gray-200">
                    <div class="flex items-center justify-between ">
                        <button onclick="toggleSidebar()" class="md:hidden text-gray-600 hover:text-gray-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                       
    <div class="px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-blue-600 to-green-600 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl text-gray-900">@yield('header', 'Default Header')</h1>
                <p class="text-sm text-gray-600">
                    Sampaikan masukan, saran, atau keluhan Anda
                </p>
            </div>
        </div>
    </div>
                    </div>
                </header>

                {{-- Page Content --}}
                <main class="flex-1 p-6 pt-20">
                    @yield('content')
                </main>
            </div>
        </div>

        <script>
            function toggleSidebar() {
                const sidebar = document.querySelector('aside');
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        </script>
    </body>
</html>
