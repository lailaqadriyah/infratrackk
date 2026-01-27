@extends('layouts.app')

@section('header', 'History Feedback')

@section('page-title', 'History Feedback')

@section('content')
<div class="max-w-7xl mx-auto pb-10" x-data="feedbackManager()">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl mt-6 font-bold text-gray-900">History Feedback</h1>
            <p class="text-sm text-gray-600 mt-1">Kelola feedback yang telah Anda kirimkan</p>
        </div>
        
    </div>

    {{-- Feedback List --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Pesan</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $index => $feedback)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-gray-700 max-w-md">
                                {{ Str::limit($feedback->isi_feedback, 100) }}
                                @if(strlen($feedback->isi_feedback) > 100)
                                    <span class="text-blue-600 cursor-pointer" title="{{ $feedback->isi_feedback }}">...</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $feedback->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @switch($feedback->status)
                                    @case('pending')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pending
                                        </span>
                                        @break
                                    @case('diproses')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Diproses
                                        </span>
                                        @break
                                    @case('selesai')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Selesai
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        @click="editFeedback({{ $feedback->id }}, @json($feedback->isi_feedback))"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form id="delete-form-{{ $feedback->id }}" action="/feedback/{{ $feedback->id }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button
                                        onclick="confirmDelete({{ $feedback->id }})"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p>Belum ada feedback yang dikirimkan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal for Add/Edit --}}
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4" x-text="editingId ? 'Edit Feedback' : 'Tambah Feedback'"></h3>
            <form @submit.prevent="submitForm()" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" x-bind:value="editingId ? 'PUT' : 'POST'">
                <input type="hidden" name="feedback_id" x-bind:value="editingId">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pesan Feedback
                    </label>
                    <textarea
                        x-model="formData.pesan"
                        placeholder="Tulis pesan feedback Anda di sini..."
                        rows="6"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload File Baru (Opsional)
                    </label>
                    <input
                        type="file"
                        name="file"
                        accept="image/*,.pdf,.doc,.docx"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah file</p>
                </div>

                <div class="flex items-center gap-3 justify-end">
                    <button
                        type="button"
                        @click="closeModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg hover:from-blue-700 hover:to-green-700 transition-all"
                        x-text="editingId ? 'Simpan Perubahan' : 'Kirim Feedback'"
                    >
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SweetAlert CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function feedbackManager() {
            return {
                isModalOpen: false,
                editingId: null,
                formData: {
                    pesan: ''
                },

                openModal() {
                    this.editingId = null;
                    this.formData.pesan = '';
                    this.isModalOpen = true;
                },

                editFeedback(id, pesan) {
                    console.log('Editing feedback:', id, pesan);
                    this.editingId = id;
                    this.formData.pesan = pesan;
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                    this.formData.pesan = '';
                    this.editingId = null;
                },

                submitForm() {
                    const form = document.querySelector('form');
                    const action = this.editingId ? `/feedback/${this.editingId}` : '/feedback';
                    form.action = action;
                    form.submit();
                }
            }
        }

        // Global function for delete confirmation
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Feedback ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>

    {{-- Success Alert --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3b82f6'
            });
        </script>
    @endif
</div>
@endsection