<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfraPlan - BAPPEDA Sumbar</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50 text-gray-900">
    {{-- Header --}}
    <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- HEADER BRAND (ganti blok logo+judul yang lama) --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-infraplan.png') }}" alt="Logo InfraPlan" class="w-12 h-12 object-contain rounded-lg bg-white p-1 shadow-sm">
                    <div>
                        <h1 class="font-bold text-xl">InfraPlan</h1>
                        <p class="text-xs text-gray-600">BAPPEDA Sumbar</p>
                    </div>
                </div>
                {{-- BUTTON LOGIN (ganti class lama) --}}
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300">
                    Login
                </a>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="container mx-auto px-6 py-20">
        <div class="max-w-4xl mx-auto text-center space-y-8">
            

            <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                Sistem Informasi
                <span class="block bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 bg-clip-text text-transparent">
                    Perencanaan & Anggaran Daerah
                </span>
            </h1>

            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                BAPPEDA Provinsi Sumatera Barat menghadirkan platform digital terintegrasi untuk transparansi
                perencanaan dan pengelolaan anggaran daerah yang akuntabel dan berbasis data.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                {{-- HERO BUTTONS (ganti class lama) --}}
                <a href="{{ route('user.renja.index') }}" class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 text-lg font-semibold">
                    Lihat Dashboard
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition-all duration-300 text-lg font-semibold border-2 border-blue-200">
                        Daftar Akun
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-3 gap-8 pt-12 max-w-2xl mx-auto">
                <div class="space-y-2">
                    <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent">150+</div>
                    <div class="text-sm text-gray-600">Program Terintegrasi</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent">2026</div>
                    <div class="text-sm text-gray-600">Data Terkini</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent">100%</div>
                    <div class="text-sm text-gray-600">Transparansi</div>
                </div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section class="bg-white py-20">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center space-y-4 mb-12">
                    <h2 class="text-4xl font-bold">Tentang BAPPEDA</h2>
                    <p class="text-lg text-gray-600">Badan Perencanaan Pembangunan Daerah Provinsi Sumatera Barat</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-teal-50 rounded-2xl p-8 space-y-6">
                    <p class="text-gray-700 leading-relaxed text-lg">
                        BAPPEDA Provinsi Sumatera Barat merupakan lembaga teknis daerah yang bertanggung jawab
                        dalam perencanaan pembangunan daerah. Kami berkomitmen untuk mewujudkan perencanaan
                        pembangunan yang berkualitas, terintegrasi, dan berkelanjutan.
                    </p>

                    <div class="grid md:grid-cols-3 gap-6 pt-4">
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <h3 class="font-bold mb-2">Visi</h3>
                            <p class="text-sm text-gray-600">Menjadi pusat perencanaan pembangunan yang profesional dan berintegritas</p>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <h3 class="font-bold mb-2">Misi</h3>
                            <p class="text-sm text-gray-600">Menyusun perencanaan pembangunan berbasis data dan partisipatif</p>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <h3 class="font-bold mb-2">Transparansi</h3>
                            <p class="text-sm text-gray-600">Keterbukaan informasi untuk akuntabilitas publik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-4xl font-bold">Fitur InfraPlan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Platform lengkap untuk monitoring dan evaluasi perencanaan serta anggaran daerah</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
                @php
                    $features = [
                        [
                            'title' => 'Dashboard RENJA',
                            'desc' => 'Visualisasi data Rencana Kerja (RENJA) dengan analisis komprehensif dan interaktif',
                            'icon' => 'renja'
                        ],
                        [
                            'title' => 'Dashboard RKPD',
                            'desc' => 'Monitoring Rencana Kerja Pemerintah Daerah dengan grafik real-time',
                            'icon' => 'rkpd'
                        ],
                        [
                            'title' => 'Dashboard APBD',
                            'desc' => 'Analisis Anggaran Pendapatan dan Belanja Daerah yang transparan',
                            'icon' => 'apbd'
                        ],
                        [
                            'title' => 'Feedback Masyarakat',
                            'desc' => 'Platform aspirasi dan masukan dari masyarakat untuk pembangunan daerah',
                            'icon' => 'feedback'
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                            @if ($feature['icon'] === 'renja')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l3-3 3 2 4-5" />
                                </svg>
                            @elseif ($feature['icon'] === 'rkpd')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8M14 7h7v7" />
                                </svg>
                            @elseif ($feature['icon'] === 'apbd')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3a9 9 0 109 9h-9V3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12A9 9 0 0012 3v9h9z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5m-9 7l3-3h11a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2h1l3 3z" />
                                </svg>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
   

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-5">
        <div class="container mx-auto px-6">
            <div class="max-w-xl mx-auto text-center space-y-3">
                <div class="flex items-center justify-center gap-2">
                    <img src="{{ asset('images/logo-infraplan.png') }}" alt="Logo InfraPlan" class="w-7 h-7 object-contain rounded bg-white p-1">
                    <div class="text-left leading-tight">
                        <h3 class="font-semibold text-sm text-white">InfraPlan</h3>
                        <p class="text-[11px] text-gray-400">BAPPEDA Prov. Sumbar</p>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-3">
                    <p class="text-[11px]">© 2026 BAPPEDA Provinsi Sumatera Barat</p>
                    <p class="text-[11px] mt-1 max-w-xs mx-auto leading-snug">
                        Jl. Khatib Sulaiman, Lolong Belanti, Padang Utara, Kota Padang, Sumatera Barat 25173, Indonesia.
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>