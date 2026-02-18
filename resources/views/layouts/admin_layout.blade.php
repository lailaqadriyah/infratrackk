<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed left-0 top-0 h-screen z-20">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
    <div class="flex items-center gap-3">
        <div class="p-2">
            <img src="{{ asset('images/logo-infraplan.png') }}" 
                 alt="Logo InfraPlan" 
                 class="h-10 w-10 object-contain">
        </div>
        <div>
            <h1 class="font-bold text-gray-900 tracking-tight">InfraPlan</h1>
            <p class="text-xs text-gray-600">BAPPEDA Sumbar</p>
        </div>
    </div>

                <!-- User Info -->
                <div class="bg-gray-50 rounded-lg p-3">
                   <div class="flex justify-center">
    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold mb-2">A</div>
</div>  
                    <p class="font-medium text-center text-gray-900 text-sm">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-center text-gray-600">Admin</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border-l-4 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 font-medium border-blue-500' : 'border-transparent text-gray-700 hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>

                <a href="{{ route('admin.renja.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border-l-4 {{ request()->routeIs('admin.renja.*') || request()->routeIs('admin.rkpd.*') ? 'bg-blue-100 text-blue-700 font-medium border-blue-500' : 'border-transparent text-gray-700 hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-sm">Modul Perencanaan</span>
                </a>

                <a href="{{ route('admin.apbd.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border-l-4 {{ request()->routeIs('admin.apbd.*') || request()->routeIs('admin.realisasi.*') ? 'bg-blue-100 text-blue-700 font-medium border-blue-500' : 'border-transparent text-gray-700 hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-sm">Modul Anggaran</span>
                </a>

                <a href="{{ route('admin.feedback.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border-l-4 {{ request()->routeIs('admin.feedback.*') ? 'bg-blue-100 text-blue-700 font-medium border-blue-500' : 'border-transparent text-gray-700 hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="text-sm">Modul Evaluasi</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors border-l-4 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 font-medium border-blue-500' : 'border-transparent text-gray-700 hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm">Kelola Akun</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-auto">
            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success') && !request()->routeIs('admin.renja.*') && !request()->routeIs('admin.rkpd.*'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
