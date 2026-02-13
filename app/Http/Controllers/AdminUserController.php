<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index(Request $request)
    {
        $search = $request->get('q');
        $roleId = $request->get('role');

        $usersQuery = User::with('role')->orderBy('name');

        if ($search) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleId) {
            $usersQuery->where('role_id', $roleId);
        }

        $users = $usersQuery->paginate(10)->withQueryString();
        $roles = Role::orderBy('nama_role')->get();

        return view('admin.users.index', compact('users', 'roles', 'search', 'roleId'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'integer', 'exists:role,id'],
        ]);

        if ($request->user()->id === $user->id) {
            return back()->withErrors(['role_id' => 'Tidak bisa mengubah role akun sendiri.']);
        }

        $user->role_id = $validated['role_id'];
        $user->save();

        return back()->with('success', 'Role berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role_id' => ['required', 'integer', 'exists:role,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Akun baru berhasil dibuat.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return back()->withErrors(['delete' => 'Tidak bisa menghapus akun sendiri.']);
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Password berhasil direset.');
    }
}
