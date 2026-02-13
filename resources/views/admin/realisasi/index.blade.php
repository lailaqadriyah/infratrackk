@extends('layouts.admin_layout')

@section('title', 'Modul Anggaran')

@section('content')
<style>[x-cloak] { display: none !important; }</style>

<div x-data="realisasiManager()" class="space-y-0">
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-white border border-blue-400 flex items-center justify-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Modul Anggaran</h1>
            <p class="text-sm text-gray-600">Kelola data Realisasi</p>
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

<div class="flex gap-6 mb-6 border-b border-gray-200">
    <a href="{{ route('admin.apbd.index') }}" class="pb-4 font-medium {{ request()->routeIs('admin.apbd.index', 'admin.apbd.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900' }}">APBD</a>
    <a href="{{ route('admin.realisasi.index') }}" class="pb-4 font-medium {{ request()->routeIs('admin.realisasi.index', 'admin.realisasi.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900' }}">Realisasi</a>
</div>

<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <form method="GET" action="{{ route('admin.realisasi.index') }}" class="flex flex-wrap items-end gap-4">
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
            <a href="{{ route('admin.realisasi.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-4 border-b border-gray-200">
        <h3 class="font-semibold text-gray-900">Data Realisasi</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-blue-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider border-x border-gray-300">Tahun</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 border-x border-gray-300">OPD</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 border-x border-gray-300">Alokasi</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 border-x border-gray-300">Sub Kegiatan</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 border-x border-gray-300">Nama Daerah</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900 border-x border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($realisasis as $realisasi)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-black-900 border-x border-gray-200">{{ $realisasi->tahun->tahun ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-x border-gray-200">{{ $realisasi->opd->nama_opd ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-x border-gray-200">Rp {{ number_format($realisasi->alokasi ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-x border-gray-200">{{ $realisasi->sub_kegiatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-x border-gray-200">{{ $realisasi->nama_daerah ?? '-' }}</td>
                        
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                {{-- PERBAIKAN: Tombol edit langsung memicu fungsi openEditModal di Alpine.js --}}
                                <button type="button" 
                                    @click="openEditModal({
                                        id: {{ $realisasi->id }},
                                        id_tahun: {{ $realisasi->id_tahun }},
                                        id_opd: {{ $realisasi->id_opd }},
                                        alokasi: {{ $realisasi->alokasi ?? 0 }},
                                        sub_kegiatan: '{{ addslashes($realisasi->sub_kegiatan) }}',
                                        nama_daerah: '{{ addslashes($realisasi->nama_daerah) }}'
                                    })"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <button type="button" @click="confirmDelete({{ $realisasi->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <form id="delete-form-{{ $realisasi->id }}" action="{{ route('admin.realisasi.destroy', $realisasi) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
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

<div class="mt-6">
    {{ $realisasis->links() }}
</div>

<div x-show="uploadModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @keydown.escape.window="uploadModalOpen = false">
    <div @click.outside="uploadModalOpen = false" class="bg-white rounded-xl shadow-xl max-w-lg w-full overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Upload File Realisasi</h3>
            <button type="button" @click="uploadModalOpen = false" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form action="{{ route('admin.realisasi.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <p class="text-sm text-gray-600">Upload file Excel (.xls, .xlsx) untuk import data.</p>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="id_tahun" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Pilih Tahun</option>
                    @foreach($tahunList as $t) <option value="{{ $t->id }}">{{ $t->tahun }}</option> @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                <select name="id_opd" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Pilih OPD</option>
                    @foreach($opds as $o) <option value="{{ $o->id }}">{{ $o->nama_opd }}</option> @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">File Excel</label>
                <input type="file" name="file" accept=".xls,.xlsx" required class="w-full border-2 border-dashed border-gray-300 rounded-lg px-4 py-6 text-sm">
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full bg-gray-900 text-white px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors">Upload dan Import</button>
            </div>
        </form>
    </div>
</div>

<div x-show="manualModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto" @keydown.escape.window="manualModalOpen = false">
    <div @click.outside="manualModalOpen = false" class="bg-white rounded-xl shadow-xl max-w-2xl w-full my-8 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Tambah Data Manual</h3>
            <button type="button" @click="manualModalOpen = false" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form action="{{ route('admin.realisasi.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="id_tahun" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Pilih Tahun</option>
                        @foreach($tahunList as $t) <option value="{{ $t->id }}">{{ $t->tahun }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                    <select name="id_opd" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Pilih OPD</option>
                        @foreach($opds as $o) <option value="{{ $o->id }}">{{ $o->nama_opd }}</option> @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alokasi (Rp)</label>
                <input type="number" name="alokasi" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Kegiatan</label>
                <input type="text" name="sub_kegiatan" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Daerah</label>
                <input type="text" name="nama_daerah" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" @click="manualModalOpen = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg">Batal</button>
                <button type="submit" class="flex-1 bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div x-show="editModalOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 overflow-y-auto" @keydown.escape.window="editModalOpen = false">
    <div @click.outside="editModalOpen = false" class="bg-white rounded-xl shadow-xl max-w-2xl w-full my-8 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Edit Data Realisasi</h3>
            <button type="button" @click="editModalOpen = false" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form :action="'{{ url('admin/realisasi') }}/' + editData.id" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="id_tahun" x-model="editData.id_tahun" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @foreach($tahunList as $t) <option value="{{ $t->id }}">{{ $t->tahun }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                    <select name="id_opd" x-model="editData.id_opd" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @foreach($opds as $o) <option value="{{ $o->id }}">{{ $o->nama_opd }}</option> @endforeach
                    </select>
                </div>
            </div>
           <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alokasi (Rp)</label>
                <input type="number" name="alokasi" x-model="editData.alokasi" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub Kegiatan</label>
                <input type="text" name="sub_kegiatan" x-model="editData.sub_kegiatan" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Daerah</label>
                <input type="text" name="nama_daerah" x-model="editData.nama_daerah" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
           
            
            <div class="flex gap-3 pt-4">
                <button type="button" @click="editModalOpen = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function realisasiManager() {
    return {
        uploadModalOpen: false,
        manualModalOpen: false,
        editModalOpen: false,
        editData: {
            id: null,
            id_tahun: null,
            id_opd: null,
            alokasi: null,
            sub_kegiatan: '',
            nama_daerah: ''
        },

        openEditModal(data) {
            // Ensure proper data types
            this.editData = {
                id: parseInt(data.id),
                id_tahun: parseInt(data.id_tahun),
                id_opd: parseInt(data.id_opd),
                alokasi: parseFloat(data.alokasi) || 0,
                sub_kegiatan: data.sub_kegiatan || '',
                nama_daerah: data.nama_daerah || ''
            };
            this.editModalOpen = true;
        },

        // Fungsi konfirmasi hapus menggunakan SweetAlert2
        confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data Realisasi?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    };
}
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