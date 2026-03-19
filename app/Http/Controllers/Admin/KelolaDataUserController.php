<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaDataUserController extends Controller
{
    // ──────────────────────────────────────────────────────────────
    //  INDEX – daftar user aktif
    // ──────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::where('role', 'peminjam')
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('nipd', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $trashedCount = User::onlyTrashed()->where('role', 'peminjam')->count();

        return view('admin.kelola_data_user.index', compact('users', 'search', 'trashedCount'));
    }

    // ──────────────────────────────────────────────────────────────
    //  CREATE – form tambah user baru
    // ──────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.kelola_data_user.create');
    }

    // ──────────────────────────────────────────────────────────────
    //  STORE – simpan user baru
    // ──────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'username'      => 'required|string|max:255',
            'email'         => 'required|email|unique:tb_user,email',
            'password'      => 'required|min:8',
            'no_telpon'     => 'nullable|string|max:20',
            'nipd'          => 'required|string|unique:tb_user,nipd',
            'alamat'        => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
        ]);

        User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'no_telpon'     => $request->no_telpon,
            'nipd'          => $request->nipd,
            'alamat'        => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'rank'          => 'Reliant',
            'role'          => 'peminjam',
            'point'         => 50,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    // ──────────────────────────────────────────────────────────────
    //  EDIT – form edit user
    // ──────────────────────────────────────────────────────────────
    public function edit(User $user)
    {
        abort_if($user->role !== 'peminjam', 403);

        return view('admin.kelola_data_user.edit', compact('user'));
    }

    // ──────────────────────────────────────────────────────────────
    //  UPDATE – simpan perubahan user
    // ──────────────────────────────────────────────────────────────
    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'peminjam', 403);

        $request->validate([
            'username'      => 'required|string|max:255',
            'email'         => 'required|email|unique:tb_user,email,' . $user->id_user . ',id_user',
            'no_telpon'     => 'nullable|string|max:20',
            'nipd'          => 'required|string|unique:tb_user,nipd,' . $user->id_user . ',id_user',
            'alamat'        => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'password'      => 'nullable|min:8',
        ]);

        $user->update([
            'username'      => $request->username,
            'email'         => $request->email,
            'no_telpon'     => $request->no_telpon,
            'nipd'          => $request->nipd,
            'alamat'        => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password'      => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    // ──────────────────────────────────────────────────────────────
    //  DESTROY – soft delete
    // ──────────────────────────────────────────────────────────────
    public function destroy(User $user)
    {
        abort_if($user->role !== 'peminjam', 403);

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dipindahkan ke tempat sampah.');
    }

    // ──────────────────────────────────────────────────────────────
    //  TRASH – daftar user yang dihapus (soft deleted)
    // ──────────────────────────────────────────────────────────────
    public function trash(Request $request)
    {
        $search = $request->get('search');

        $trashedUsers = User::onlyTrashed()
            ->where('role', 'peminjam')
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('nipd', 'like', "%{$search}%");
            })
            ->latest('deleted_at')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.kelola_data_user.trash', compact('trashedUsers', 'search'));
    }

    // ──────────────────────────────────────────────────────────────
    //  RESTORE – kembalikan user dari sampah
    // ──────────────────────────────────────────────────────────────
    public function restore($id)
    {
        $user = User::onlyTrashed()->where('role', 'peminjam')->findOrFail($id);
        $user->restore();

        return redirect()->route('users..trash')
            ->with('success', 'User berhasil dipulihkan.');
    }

    // ──────────────────────────────────────────────────────────────
    //  FORCE DELETE – hapus permanen
    // ──────────────────────────────────────────────────────────────
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->where('role', 'peminjam')->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users..trash')
            ->with('success', 'User berhasil dihapus secara permanen.');
    }
}
