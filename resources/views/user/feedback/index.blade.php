@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md space-y-6">

        {{-- Header --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-lg text-sm">
            <strong>Masukan Anda sangat berharga</strong> bagi kami untuk meningkatkan pelayanan dan pembangunan.
        </div>

        {{-- Form Feedback --}}
        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama *</label>
                    <input type="text" name="nama"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan nama Anda" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email (Opsional)</label>
                    <input type="email" name="email"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan email Anda">
                    <p class="text-xs text-gray-400 mt-1">
                        Email akan digunakan jika kami perlu menghubungi Anda
                    </p>
                </div>

                {{-- Masukan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Masukan / Keluhan *</label>
                    <textarea name="isi_feedback" rows="4"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tuliskan masukan, saran, atau keluhan Anda di sini..." required></textarea>
                </div>

                {{-- Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Upload File atau Gambar (Opsional)
                    </label>
                    <label
                        class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-4 cursor-pointer hover:bg-gray-50">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16V4a1 1 0 011-1h8a1 1 0 011 1v12m-4-4l-4-4m0 0l-4 4m4-4v12" />
                        </svg>
                        <span class="text-sm text-gray-500 mt-2">Klik untuk upload file</span>
                        <input type="file" name="file" class="hidden">
                    </label>
                </div>

                {{-- Button --}}
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-green-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Kirim Feedback
                </button>
            </form>
        </div>

        {{-- Kontak --}}
        <div class="bg-white rounded-xl shadow p-5 text-sm text-gray-600">
            <h3 class="font-semibold text-gray-800 mb-2">Kontak Kami</h3>
            <p><strong>BAPPEDA Provinsi Sumatera Barat</strong></p>
            <p>Jl. Jenderal Sudirman No. 51, Padang</p>
            <p>Email: bappeda@sumbarprov.go.id</p>
            <p>Telp: (0751) 123456</p>
        </div>

    </div>
</div>
@endsection
