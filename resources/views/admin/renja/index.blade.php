@extends('layouts.admin_layout')

@section('title', 'Modul Perencanaan')

@section('content')
<style>[x-cloak] { display: none !important; }</style>

<div x-data="renjaManager()" x-init="init()" class="space-y-0">
<!-- Header: judul kiri, tombol pojok kanan -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Modul Perencanaan</h1>
            <p class="text-sm text-gray-600">Kelola data RENJA dan RKPD</p>
        </div>
    </div>
    <div class="flex gap-3">
        <button @click="uploadModalOpen = true" type="button" class="flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Upload File
        </button>
        <button @click="manualModalOpen = true" type="button" class="flex items-center gap-2 bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Data Manual
        </button>
    </div>
</div>

<!-- Tabs -->
<div class="flex gap-6 mb-6 border-b border-gray-200">
    <a href="{{ route('admin.renja.index') }}" class="pb-4 font-medium text-green-600 border-b-2 border-green-600">RENJA</a>
    <a href="{{ route('admin.rkpd.index') }}" class="pb-4 font-medium text-gray-600 hover:text-gray-900">RKPD</a>
</div>

<!-- Filter -->
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <form method="GET" action="{{ route('admin.renja.index') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter Tahun</label>
            <select name="tahun" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $t)
                    <option value="{{ $t->id }}" {{ ($tahunFilter ?? '') == $t->id ? 'selected' : '' }}>{{ $t->tahun }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter OPD</label>
            <select name="opd" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua OPD</option>
                @foreach($opds as $o)
                    <option value="{{ $o->id }}" {{ ($opdFilter ?? '') == $o->id ? 'selected' : '' }}>{{ $o->nama_opd }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Filter
            </button>
            <a href="{{ route('admin.renja.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">Reset</a>
        </div>
    </form>
</div>

<!-- Data Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-4 border-b border-gray-200">
        <h3 class="font-semibold text-gray-900">Data RENJA</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tahun</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">OPD</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Program</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Kegiatan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Sub Kegiatan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Target</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Pagu</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($renjas as $renja)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $renja->tahun->tahun ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $renja->opd->nama_opd ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $renja->program ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $renja->kegiatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $renja->sub_kegiatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $renja->target ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($renja->anggaran ?? 0, 0, ',', '.') }}</td>
                        @php
                            $editData = json_encode([
                                'id' => $renja->id,
                                'id_tahun' => $renja->id_tahun,
                                'id_opd' => $renja->id_opd,
                                'program' => $renja->program ?? '',
                                'kegiatan' => $renja->kegiatan ?? '',
                                'sub_kegiatan' => $renja->sub_kegiatan ?? '',
                                'indikator' => $renja->indikator ?? '',
                                'target' => $renja->target ?? '',
                                'anggaran' => $renja->anggaran ?? 0,
                            ]);
                        @endphp
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <button type="button" class="btn-edit-renja p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit" data-renja="{{ e($editData) }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <form id="delete-form-{{ $renja->id }}" action="{{ route('admin.renja.destroy', $renja) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn-delete-renja p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus" data-id="{{ $renja->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
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
    {{ $renjas->links() }}
</div>

<!-- Modal: Upload File RENJA -->
<div x-show="uploadModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @keydown.escape.window="uploadModalOpen = false">
    <div @click.outside="uploadModalOpen = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Upload File RENJA</h3>
            <button type="button" @click="uploadModalOpen = false" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form action="{{ route('admin.renja.upload') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <p class="text-sm text-gray-600">Upload file Excel (.xls, .xlsx) untuk import data. Pastikan kolom sesuai: program, kegiatan, sub_kegiatan, indikator, target, pagu</p>
            <div>
                <label for="upload_id_tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="id_tahun" id="upload_id_tahun" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-800 focus:border-gray-800">
                    <option value="">Pilih Tahun</option>
                    @foreach($tahunList as $t)
                        <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="upload_id_opd" class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                <select name="id_opd" id="upload_id_opd" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gray-800 focus:border-gray-800">
                    <option value="">Pilih OPD</option>
                    @foreach($opds as $o)
                        <option value="{{ $o->id }}">{{ $o->nama_opd }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="upload_file" class="block text-sm font-medium text-gray-700 mb-1">File Excel</label>
                <input type="file" name="file" id="upload_file" accept=".xls,.xlsx" required class="w-full border-2 border-dashed border-gray-300 rounded-lg px-4 py-6 text-sm text-gray-600 focus:border-gray-800 focus:ring-1 focus:ring-gray-800">
                <p class="text-xs text-gray-500 mt-1">Format: .xls, .xlsx (maks 5MB)</p>
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gray-900 text-white px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Upload dan Import
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Tambah Data Manual -->
<div x-show="manualModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto" @keydown.escape.window="manualModalOpen = false">
    <div @click.outside="manualModalOpen = false" class="bg-white rounded-xl shadow-xl max-w-2xl w-full my-8 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Tambah Data Manual</h3>
            <button type="button" @click="manualModalOpen = false" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form action="{{ route('admin.renja.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="manual_id_tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="id_tahun" id="manual_id_tahun" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tahun</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="manual_id_opd" class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                    <select name="id_opd" id="manual_id_opd" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih OPD</option>
                        @foreach($opds as $o)
                            <option value="{{ $o->id }}">{{ $o->nama_opd }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label for="manual_program" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                <input type="text" name="program" id="manual_program" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="manual_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Kegiatan</label>
                <input type="text" name="kegiatan" id="manual_kegiatan" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="manual_sub_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Sub Kegiatan</label>
                <input type="text" name="sub_kegiatan" id="manual_sub_kegiatan" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="manual_indikator" class="block text-sm font-medium text-gray-700 mb-1">Indikator</label>
                <input type="text" name="indikator" id="manual_indikator" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="manual_target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                <input type="text" name="target" id="manual_target" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="manual_anggaran" class="block text-sm font-medium text-gray-700 mb-1">Anggaran (Rp)</label>
                <input type="number" name="anggaran" id="manual_anggaran" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" @click="manualModalOpen = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Data -->
<div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto" @keydown.escape.window="editModalOpen = false">
    <div @click.outside="editModalOpen = false" class="bg-white rounded-xl shadow-xl max-w-2xl w-full my-8 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Edit Data RENJA</h3>
            <button type="button" @click="editModalOpen = false" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form id="edit-form-renja" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="edit_id_tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="id_tahun" id="edit_id_tahun" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tahun</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="edit_id_opd" class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                    <select name="id_opd" id="edit_id_opd" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih OPD</option>
                        @foreach($opds as $o)
                            <option value="{{ $o->id }}">{{ $o->nama_opd }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label for="edit_program" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                <input type="text" name="program" id="edit_program" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="edit_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Kegiatan</label>
                <input type="text" name="kegiatan" id="edit_kegiatan" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="edit_sub_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Sub Kegiatan</label>
                <input type="text" name="sub_kegiatan" id="edit_sub_kegiatan" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="edit_indikator" class="block text-sm font-medium text-gray-700 mb-1">Indikator</label>
                <input type="text" name="indikator" id="edit_indikator" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="edit_target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                <input type="text" name="target" id="edit_target" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="edit_anggaran" class="block text-sm font-medium text-gray-700 mb-1">Anggaran (Rp)</label>
                <input type="number" name="anggaran" id="edit_anggaran" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" @click="editModalOpen = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Global variable untuk Alpine
let renjaAlpine = null;

function renjaManager() {
    return {
        uploadModalOpen: false,
        manualModalOpen: false,
        editModalOpen: false,
        init() {
            renjaAlpine = this;
        }
    };
}

// Event handlers untuk tombol edit dan hapus
function attachRenjaHandlers() {
    // Edit buttons
    document.querySelectorAll('.btn-edit-renja').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var data = JSON.parse(this.dataset.renja);
            if (renjaAlpine) {
                renjaAlpine.editModalOpen = true;
            }
            setTimeout(function() {
                var form = document.getElementById('edit-form-renja');
                if (form) {
                    form.action = '{{ url("/admin/renja") }}/' + data.id;
                    document.getElementById('edit_id_tahun').value = data.id_tahun;
                    document.getElementById('edit_id_opd').value = data.id_opd;
                    document.getElementById('edit_program').value = data.program;
                    document.getElementById('edit_kegiatan').value = data.kegiatan;
                    document.getElementById('edit_sub_kegiatan').value = data.sub_kegiatan;
                    document.getElementById('edit_indikator').value = data.indikator;
                    document.getElementById('edit_target').value = data.target;
                    document.getElementById('edit_anggaran').value = data.anggaran;
                }
            }, 100);
        });
    });

    // Delete buttons
    document.querySelectorAll('.btn-delete-renja').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.dataset.id;
            Swal.fire({
                title: 'Hapus Data RENJA?',
                html: 'Data yang dihapus tidak dapat dikembalikan. Pastikan Anda yakin untuk melanjutkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
}

// Jalankan segera (script ini ada di akhir body, DOM sudah siap)
attachRenjaHandlers();
</script>

@if(session('success'))
<script>
Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', confirmButtonColor: '#16a34a' });
</script>
@endif

@if(session('error'))
<script>
Swal.fire({ icon: 'error', title: 'Gagal', text: '{{ session("error") }}', confirmButtonColor: '#dc2626' });
</script>
@endif
@endsection
