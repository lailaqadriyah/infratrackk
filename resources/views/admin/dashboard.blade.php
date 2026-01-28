@extends('layouts.admin_layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-600 mt-2">Selamat datang di panel administrasi BAPPEDA Sumatra Barat</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card RENJA -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total RENJA</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Renja::count() }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.renja.index') }}" class="text-blue-600 text-sm hover:text-blue-700 mt-4 inline-block">Kelola RENJA →</a>
    </div>

    <!-- Card RKPD -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total RKPD</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Rkpd::count() }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.rkpd.index') }}" class="text-green-600 text-sm hover:text-green-700 mt-4 inline-block">Kelola RKPD →</a>
    </div>

    <!-- Card OPD -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total OPD</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Opd::count() }}</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection
