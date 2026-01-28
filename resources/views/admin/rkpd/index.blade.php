@extends('layouts.admin_layout')

@section('title', 'Modul Anggaran')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Modul Anggaran</h1>
    <p class="text-gray-600 mt-2">Kelola data RENJA dan RKPD</p>
</div>

<!-- Tabs -->
<div class="flex gap-6 mb-6 border-b border-gray-200">
    <a href="{{ route('admin.renja.index') }}" class="pb-4 font-medium text-gray-600 hover:text-gray-900">RENJA</a>
    <a href="{{ route('admin.rkpd.index') }}" class="pb-4 font-medium text-green-600 border-b-2 border-green-600">RKPD</a>
</div>

<!-- Actions -->
<div class="flex gap-3 mb-6">
    <button onclick="document.getElementById('uploadForm').click()" class="flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
        Upload File
    </button>
    <a href="{{ route('admin.rkpd.create') }}" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Data Manual
    </a>
</div>

<!-- Data Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tahun</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">OPD</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Program</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Kegiatan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Anggaran</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($rkpds as $rkpd)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $rkpd->tahun->tahun }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $rkpd->opd->nama_opd }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $rkpd->program }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $rkpd->kegiatan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($rkpd->anggaran, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.rkpd.edit', $rkpd->id) }}" class="text-blue-600 hover:text-blue-700 font-medium text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.rkpd.destroy', $rkpd->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-xs">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada data. Tambahkan data dengan tombol di atas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $rkpds->links() }}
</div>

<!-- Hidden upload form -->
<input type="file" id="uploadForm" class="hidden" accept=".pdf,.xls,.xlsx,.doc,.docx">
@endsection
