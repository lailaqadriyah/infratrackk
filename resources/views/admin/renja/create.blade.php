@extends('layouts.admin_layout')

@section('title', 'Tambah RENJA')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Tambah Data RENJA</h1>
    <p class="text-gray-600 mt-2">Tambahkan data RENJA baru ke sistem</p>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form action="{{ route('admin.renja.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <select name="id_tahun" id="id_tahun" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('id_tahun') border-red-500 @enderror" required>
                    <option value="">Pilih Tahun</option>
                    @foreach ($tahuns as $tahun)
                        <option value="{{ $tahun->id }}" {{ old('id_tahun') == $tahun->id ? 'selected' : '' }}>{{ $tahun->tahun }}</option>
                    @endforeach
                </select>
                @error('id_tahun')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_opd" class="block text-sm font-medium text-gray-700 mb-2">OPD</label>
                <select name="id_opd" id="id_opd" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('id_opd') border-red-500 @enderror" required>
                    <option value="">Pilih OPD</option>
                    @foreach ($opds as $opd)
                        <option value="{{ $opd->id }}" {{ old('id_opd') == $opd->id ? 'selected' : '' }}>{{ $opd->nama_opd }}</option>
                    @endforeach
                </select>
                @error('id_opd')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
            <input type="text" name="program" id="program" value="{{ old('program') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('program') border-red-500 @enderror" required>
            @error('program')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Kegiatan</label>
            <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('kegiatan') border-red-500 @enderror" required>
            @error('kegiatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sub_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Sub Kegiatan</label>
            <input type="text" name="sub_kegiatan" id="sub_kegiatan" value="{{ old('sub_kegiatan') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('sub_kegiatan') border-red-500 @enderror" required>
            @error('sub_kegiatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="indikator" class="block text-sm font-medium text-gray-700 mb-2">Indikator</label>
            <input type="text" name="indikator" id="indikator" value="{{ old('indikator') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('indikator') border-red-500 @enderror" required>
            @error('indikator')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="target" class="block text-sm font-medium text-gray-700 mb-2">Target</label>
            <input type="text" name="target" id="target" value="{{ old('target') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('target') border-red-500 @enderror" required>
            @error('target')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="anggaran" class="block text-sm font-medium text-gray-700 mb-2">Anggaran (Rp)</label>
            <input type="number" name="anggaran" id="anggaran" step="0.01" value="{{ old('anggaran') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('anggaran') border-red-500 @enderror" required>
            @error('anggaran')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Upload File (PDF, Excel, Word)</label>
            <input type="file" name="file" id="file" accept=".pdf,.xls,.xlsx,.doc,.docx" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            <p class="text-gray-500 text-xs mt-1">Maksimal 5MB. Format: PDF, XLS, XLSX, DOC, DOCX</p>
            @error('file')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
            <a href="{{ route('admin.renja.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
