@extends('layouts.app')
@section('header', 'Kegiatan: ' . ($kegiatan ?? '-'))
@section('header_description', 'Rincian sub-kegiatan dan atribut terkait')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen w-full">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b bg-gray-50">
            <h3 class="font-bold text-gray-800 text-sm italic">Rincian untuk Kegiatan: {{ $kegiatan }} (Program: {{ $program }})</h3>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-blue-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Tahun</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">OPD</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Sub Kegiatan</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Nama Sumber Dana</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Nama Rekening</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Nama Daerah</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Alokasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($details as $d)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-4 border-x border-gray-200 text-black-700">{{ $d->label_tahun ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-700">{{ $d->nama_opd ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">{{ $d->sub_kegiatan ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">{{ $d->nama_sumber_dana ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">{{ $d->nama_rekening ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">{{ $d->nama_daerah ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600 whitespace-nowrap">Rp {{ number_format($d->total_alokasi ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-400 italic">Rincian tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
