@extends('layouts.admin_layout')

@section('title', 'Kelola Akun')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Kelola Akun</h1>
    <p class="text-sm text-gray-600">Atur role dan kelola akun pengguna</p>
</div>

<div class="bg-white rounded-lg shadow-sm p-4 mb-6 border border-gray-200">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tambah Akun</h2>
    <form method="POST" action="{{ route('admin.users.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Pilih Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
                type="password"
                name="password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            />
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                required
            />
        </div>
        <div class="flex items-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                Simpan Akun
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
            <input
                type="text"
                name="q"
                value="{{ $search ?? '' }}"
                placeholder="Nama atau email"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
        </div>
        <div class="min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ ($roleId ?? '') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <div class="p-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900">Daftar Akun</h3>
        <p class="text-sm text-gray-500">Total: {{ $users->total() }}</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Dibuat</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="flex flex-wrap items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="role_id" class="min-w-[96px] border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-2.5 py-1.5 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ optional($user->created_at)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" onclick="resetPasswordUser({{ $user->id }})" class="px-3 py-1 text-xs bg-amber-500 text-white rounded-md hover:bg-amber-600">
                                    Reset Password
                                </button>
                                <button type="button" onclick="confirmDeleteUser({{ $user->id }})" class="px-3 py-1 text-xs bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                            <form id="delete-user-{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy', $user) }}" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <form id="reset-password-{{ $user->id }}" method="POST" action="{{ route('admin.users.resetPassword', $user) }}" class="hidden">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="password">
                                <input type="hidden" name="password_confirmation">
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada akun.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>

<script>
    function resetPasswordUser(id) {
        const password = prompt('Masukkan password baru (min 8 karakter)')
        if (!password) return
        if (password.length < 8) {
            alert('Password minimal 8 karakter.')
            return
        }
        const confirmation = prompt('Ulangi password baru')
        if (password !== confirmation) {
            alert('Konfirmasi password tidak sama.')
            return
        }
        const form = document.getElementById(`reset-password-${id}`)
        form.querySelector('input[name="password"]').value = password
        form.querySelector('input[name="password_confirmation"]').value = confirmation
        form.submit()
    }

    function confirmDeleteUser(id) {
        if (!confirm('Hapus akun ini?')) return
        document.getElementById(`delete-user-${id}`).submit()
    }
</script>
@endsection
