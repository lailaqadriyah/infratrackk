@extends('layouts.app')
@section('header', 'Program: ' . ($program ?? '-'))
@section('header_description', 'Daftar kegiatan untuk program yang dipilih')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen w-full">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b bg-gray-50">
            <h3 class="font-bold text-gray-800 text-sm italic">Kegiatan untuk Program: {{ $program }}</h3>
        </div>
        <div class="p-4">
            <table class="min-w-full text-sm">
                <thead class="bg-blue-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Total Alokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kegiatans as $k)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-4 border-x border-gray-200 text-black-700">
                            <a href="{{ route('user.apbd.kegiatan', [urlencode($program), urlencode($k->kegiatan)]) }}" class="text-blue-600 hover:underline">{{ $k->kegiatan ?? '-' }}</a>
                        </td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">Rp {{ number_format($k->total ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-10 text-center text-gray-400 italic">Kegiatan tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
