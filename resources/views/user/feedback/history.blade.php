@extends('layouts.app')

@section('header', 'History Feedback')
@section('page-title', 'History Feedback')

@section('content')
<div class="max-w-7xl mx-auto pb-10 space-y-6">

    

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Pesan</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($feedbacks as $index => $feedback)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-900">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-6 py-4 text-gray-700 max-w-md">
                            {{ Str::limit($feedback->isi_feedback, 120) }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $feedback->created_at->translatedFormat('d F Y') }}
                        </td>

                        <td class="px-6 py-4">
                            @if($feedback->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    ⏳ Pending
                                </span>
                            @elseif($feedback->status === 'diproses')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    🔄 Diproses
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Selesai
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">

                               <div class="flex justify-center gap-2">

    {{-- EDIT --}}
    <button
        type="button"
        class="edit-btn inline-flex items-center justify-center w-9 h-9 rounded-lg
               text-blue-600 hover:bg-blue-50 transition"
        data-id="{{ $feedback->id }}"
        data-pesan="{{ $feedback->isi_feedback }}"
        title="Edit"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
    </button>

    {{-- DELETE --}}
    <button
        type="button"
        onclick="confirmDelete({{ $feedback->id }})"
        class="inline-flex items-center justify-center w-9 h-9 rounded-lg
               text-red-600 hover:bg-red-50 transition"
        title="Hapus"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m2-4h6a1 1 0 011 1v1H8V4a1 1 0 011-1z" />
        </svg>
    </button>

</div>


                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <div class="text-4xl">💬</div>
                                <p>Belum ada feedback yang dikirimkan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="editModal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">
                    Edit Feedback
                </h3>
                <button type="button"
                        onclick="closeEditModal()"
                        class="text-gray-400 hover:text-gray-600">
                    ✖
                </button>
            </div>

            <form id="editForm"
                  method="POST"
                  enctype="multipart/form-data"
                  onsubmit="return submitEditForm(event)">
                @csrf
                @method('PATCH')

                <textarea
                    id="feedbackMessage"
                    name="isi_feedback"
                    rows="6"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                ></textarea>

                <input
                    type="file"
                    name="file"
                    class="mt-3 w-full text-sm text-gray-600"
                >

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                            onclick="closeEditModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SCRIPT (LOGIC TETAP) --}}
    <script>
        let currentFeedbackId = null;

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                currentFeedbackId = btn.dataset.id
                document.getElementById('feedbackMessage').value = btn.dataset.pesan
                document.getElementById('editModal').classList.remove('hidden')
            })
        })

        function submitEditForm(e) {
            e.preventDefault()
            if (!currentFeedbackId) return false
            const form = document.getElementById('editForm')
            form.action = '/feedback/' + currentFeedbackId
            form.submit()
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden')
            document.getElementById('editForm').reset()
            currentFeedbackId = null
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin hapus?',
                text: 'Feedback akan dihapus permanen',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit()
                }
            })
        }
    </script>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("success") }}'
        })
    </script>
    @endif

</div>
@endsection
