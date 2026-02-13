@extends('layouts.app')
@section('header', 'Edit Data Realisasi')
@section('header_description', 'Ubah data realisasi yang sudah diisikan sebelumnya')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen w-full">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Edit Data Realisasi</h2>
            <p class="text-sm text-gray-600 mt-1">Ubah informasi realisasi di bawah ini</p>
        </div>

        <form action="{{ route('user.realisasi.update', $realisasi->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Tahun -->
            <div>
                <label for="id_tahun" class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                <select name="id_tahun" id="id_tahun" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_tahun') border-red-500 @enderror" required>
                    <option value="">-- Pilih Tahun --</option>
                    @foreach($tahuns as $tahun)
                        <option value="{{ $tahun->id }}" {{ $realisasi->id_tahun == $tahun->id ? 'selected' : '' }}>{{ $tahun->tahun }}</option>
                    @endforeach
                </select>
                @error('id_tahun')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- OPD -->
            <div>
                <label for="id_opd" class="block text-sm font-semibold text-gray-700 mb-2">OPD</label>
                <select name="id_opd" id="id_opd" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_opd') border-red-500 @enderror" required>
                    <option value="">-- Pilih OPD --</option>
                    @foreach($opds as $opd)
                        <option value="{{ $opd->id }}" {{ $realisasi->id_opd == $opd->id ? 'selected' : '' }}>{{ $opd->nama_opd }}</option>
                    @endforeach
                </select>
                @error('id_opd')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alokasi -->
            <div>
                <label for="alokasi" class="block text-sm font-semibold text-gray-700 mb-2">Alokasi</label>
                <input type="number" name="alokasi" id="alokasi" step="0.01" value="{{ old('alokasi', $realisasi->alokasi) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alokasi') border-red-500 @enderror" required>
                @error('alokasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sub Kegiatan -->
            <div>
                <label for="sub_kegiatan" class="block text-sm font-semibold text-gray-700 mb-2">Sub Kegiatan</label>
                <input type="text" name="sub_kegiatan" id="sub_kegiatan" value="{{ old('sub_kegiatan', $realisasi->sub_kegiatan) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('sub_kegiatan') border-red-500 @enderror" required>
                @error('sub_kegiatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Daerah -->
            <div>
                <label for="nama_daerah" class="block text-sm font-semibold text-gray-700 mb-2">Nama Daerah</label>
                <input type="text" name="nama_daerah" id="nama_daerah" value="{{ old('nama_daerah', $realisasi->nama_daerah) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_daerah') border-red-500 @enderror" required>
                @error('nama_daerah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Action -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Simpan Perubahan
                </button>
                <a href="{{ route('user.realisasi.index') }}" class="flex-1 bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors font-semibold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        Toast.fire({
            icon: 'success',
            title: '{{ session("success") }}'
        });
    });
</script>
@endif

@endsection
