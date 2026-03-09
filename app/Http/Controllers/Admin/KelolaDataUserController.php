<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaDataUserController extends Controller
{
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
            ->appends(request()->query()); // ← ganti withQueryString()

        return view('admin.kelola_data_user.index', compact('users', 'search'));
    }

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
            'point'         => 0,
        ]);

        return redirect()->route('admin.kelola-data-user.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username'      => 'required|string|max:255',
            'email'         => 'required|email|unique:tb_user,email,' . $id . ',id_user',
            'no_telpon'     => 'nullable|string|max:20',
            'nipd'          => 'required|string|unique:tb_user,nipd,' . $id . ',id_user',
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

        return redirect()->route('admin.kelola-data-user.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.kelola-data-user.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
