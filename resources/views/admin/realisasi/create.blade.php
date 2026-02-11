@extends('layouts.admin_layout')

@section('title', 'Tambah Realisasi')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Tambah Data Realisasi</h1>
    <p class="text-gray-600 mt-2">Tambahkan data realisasi baru ke sistem</p>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form action="{{ route('admin.realisasi.store') }}" method="POST" class="space-y-6">
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
            <label for="alokasi" class="block text-sm font-medium text-gray-700 mb-2">Alokasi</label>
            <input type="text" name="alokasi" id="alokasi" value="{{ old('alokasi') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('alokasi') border-red-500 @enderror" required>
            @error('alokasi')
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
            <label for="nama_daerah" class="block text-sm font-medium text-gray-700 mb-2">Nama Daerah</label>
            <input type="text" name="nama_daerah" id="nama_daerah" value="{{ old('nama_daerah') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('nama_daerah') border-red-500 @enderror" required>
            @error('nama_daerah')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
            <a href="{{ route('admin.realisasi.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
