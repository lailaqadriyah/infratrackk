@extends('layouts.admin_layout')

@section('title', 'Edit APBD')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Edit Data APBD</h1>
    <p class="text-gray-600 mt-2">Ubah data APBD yang ada</p>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form action="{{ route('admin.apbd.update', $apbd->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <select name="id_tahun" id="id_tahun" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('id_tahun') border-red-500 @enderror" required>
                    <option value="">Pilih Tahun</option>
                    @foreach ($tahuns as $tahun)
                        <option value="{{ $tahun->id }}" {{ $apbd->id_tahun == $tahun->id ? 'selected' : '' }}>{{ $tahun->tahun }}</option>
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
                        <option value="{{ $opd->id }}" {{ $apbd->id_opd == $opd->id ? 'selected' : '' }}>{{ $opd->nama_opd }}</option>
                    @endforeach
                </select>
                @error('id_opd')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Kegiatan</label>
            <input type="text" name="kegiatan" id="kegiatan" value="{{ old('kegiatan', $apbd->kegiatan) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('kegiatan') border-red-500 @enderror" required>
            @error('kegiatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sub_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Sub Kegiatan</label>
            <input type="text" name="sub_kegiatan" id="sub_kegiatan" value="{{ old('sub_kegiatan', $apbd->sub_kegiatan) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('sub_kegiatan') border-red-500 @enderror" required>
            @error('sub_kegiatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nama_sumber_dana" class="block text-sm font-medium text-gray-700 mb-2">Nama Sumber Dana</label>
            <input type="text" name="nama_sumber_dana" id="nama_sumber_dana" value="{{ old('nama_sumber_dana', $apbd->nama_sumber_dana) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('nama_sumber_dana') border-red-500 @enderror" required>
            @error('nama_sumber_dana')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nama_rekening" class="block text-sm font-medium text-gray-700 mb-2">Nama Rekening</label>
            <input type="text" name="nama_rekening" id="nama_rekening" value="{{ old('nama_rekening', $apbd->nama_rekening) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('nama_rekening') border-red-500 @enderror" required>
            @error('nama_rekening')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="pagu" class="block text-sm font-medium text-gray-700 mb-2">Pagu (Rp)</label>
            <input type="number" name="pagu" id="pagu" step="0.01" value="{{ old('pagu', $apbd->pagu) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 @error('pagu') border-red-500 @enderror" required>
            @error('pagu')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-4 pt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Update</button>
            <a href="{{ route('admin.apbd.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
