@extends('layouts.app')
@section('header', 'Feedback Masyarakat')
@section('header_description', 'Sampaikan masukan, saran, atau keluhan Anda.')

@section('header', 'Feedback Masyarakat')

@section('page-title', 'Feedback Masyarakat')

@section('content')
        <div class="max-w-3xl mx-auto pb-10">
            
            {{-- Info Card --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 mt-6 shadow-sm">
                <p class="text-sm text-blue-800 leading-relaxed">
                    <span class="font-bold">Informasi:</span> Masukan Anda sangat berharga bagi kami untuk
                    meningkatkan pelayanan dan pembangunan di Provinsi Sumatera Barat. Semua feedback
                    akan dianalisis dan ditindaklanjuti oleh tim BAPPEDA.
                </p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- {{-- Nama --}}
                    <div class="mb-6">
                        <label for="nama" class="text-sm font-semibold text-gray-700 mb-2 block">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" 
                            placeholder="Masukkan nama Anda"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all"
                            required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-6">
                        <label for="email" class="text-sm font-semibold text-gray-700 mb-2 block">
                            Email (Opsional)
                        </label>
                        <input type="email" name="email" id="email"
                            placeholder="Masukkan email Anda"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all">
                        <p class="text-xs text-gray-500 mt-2">
                            Email akan digunakan jika kami perlu menghubungi Anda
                        </p>
                    </div> -->

                    {{-- Masukan --}}
                    <div class="mb-6">
                        <label for="isi_feedback" class="text-sm font-semibold text-gray-700 mb-2 block">
                            Masukan/Keluhan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi_feedback" id="isi_feedback" rows="6"
                            placeholder="Tuliskan masukan, saran, atau keluhan Anda di sini..."
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 resize-none transition-all"
                            required minlength="10"></textarea>
                        <p class="text-xs text-gray-500 mt-2">
                            Minimal 10 karakter. Jelaskan secara detail agar kami dapat memahami dengan baik.
                        </p>
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-8">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Upload File atau Gambar (Opsional)
                        </label>
                        <div class="group relative">
                            <label for="file" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 group-hover:bg-gray-100 group-hover:border-blue-400 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <p class="text-sm text-gray-600 font-medium">Klik untuk upload file atau gambar</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, PDF, DOC (Max. 5MB)</p>
                                <input type="file" name="file" id="file" class="hidden" accept="image/*,.pdf,.doc,.docx">
                            </label>
                        </div>
                        {{-- Preview Gambar --}}
                        <div id="image-preview" class="mt-4 hidden">
                            <p class="text-sm text-gray-700 mb-2">Preview:</p>
                            <img id="preview-img" class="max-w-full h-auto max-h-64 rounded-lg shadow-sm border" alt="Preview">
                        </div>
                    </div>

                    {{-- Tombol Kirim --}}
                    <button type="submit"
                        class="w-full flex justify-center items-center gap-2 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                        Kirim Feedback
                    </button>
                </form>
            </div>

            {{-- Footer Info --}}
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-l-blue-600">
                <h3 class="text-base font-bold text-gray-900 mb-3">Kontak Kami</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center gap-2">
                        <span class="font-semibold text-gray-800 w-20">Lembaga:</span> BAPPEDA Provinsi Sumatera Barat
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="font-semibold text-gray-800 w-20">Alamat:</span> Jl. Jenderal Sudirman No. 51, Padang
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="font-semibold text-gray-800 w-20">Email:</span> bappeda@sumbarprov.go.id
                    </p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('feedback.history') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Lihat History Feedback
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    /* Menghilangkan scrollbar default agar lebih bersih seperti Figma */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>

{{-- SweetAlert CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3b82f6'
    });
@endif

// Preview gambar saat upload
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});
</script>
@endsection