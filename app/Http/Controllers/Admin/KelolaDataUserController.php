<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KelolaDataUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');

        $users = User::when(auth()->user()->role === 'admin', function ($query) {
            $query->where('role', 'peminjam');
        })
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nipd', 'like', "%{$search}%");
            })
            ->when($role && in_array($role, ['admin', 'peminjam']), function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $trashedCount = User::onlyTrashed()
            ->when(auth()->user()->role === 'admin', function ($query) {
                $query->where('role', 'peminjam');
            })
            ->count();

        return view('admin.kelola_data_user.index', compact('users', 'search', 'trashedCount'));
    }

    public function create()
    {
        return view('admin.kelola_data_user.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|string|max:255|unique:tb_user,username',
            'email' => 'required|email|unique:tb_user,email',
            'password' => 'required|min:8',
            'no_telpon' => 'nullable|string|max:20',
            'role' => 'required|in:peminjam,admin',
        ];

        if (auth()->user()->role === 'admin') {
            $request->merge(['role' => 'peminjam']);
        }

        if ($request->role === 'peminjam') {
            $rules['nipd'] = 'required|string|unique:tb_user,nipd';
            $rules['kelas'] = 'required|string';
            $rules['alamat'] = 'required|string';
            $rules['tanggal_lahir'] = 'required|date';
            $rules['jenis_kelamin'] = 'required|in:laki-laki,perempuan';
        }

        $request->validate($rules);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telpon' => $request->no_telpon,
            'role' => $request->role,
            'points' => 50,
            'is_banned' => false,
        ];

        if ($request->role === 'peminjam') {
            $data['nipd'] = $request->nipd;
            $data['kelas'] = $request->kelas;
            $data['alamat'] = $request->alamat;
            $data['tanggal_lahir'] = $request->tanggal_lahir;
            $data['jenis_kelamin'] = $request->jenis_kelamin;
        }

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'peminjam') {
            abort(403);
        }

        return view('admin.kelola_data_user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'peminjam') {
            abort(403);
        }

        $rules = [
            'username' => 'required|string|max:255|unique:tb_user,username,' . $user->id_user . ',id_user',
            'email' => 'required|email|unique:tb_user,email,' . $user->id_user . ',id_user',
            'no_telpon' => 'nullable|string|max:20',
            'role' => auth()->user()->role === 'super-admin' ? 'required|in:peminjam,admin' : 'prohibited',
        ];

        if ($user->role === 'peminjam') {
            $rules['nipd'] = 'required|string|unique:tb_user,nipd,' . $user->id_user . ',id_user';
            $rules['kelas'] = 'required|string';
            $rules['alamat'] = 'required|string';
            $rules['tanggal_lahir'] = 'required|date';
            $rules['jenis_kelamin'] = 'required|in:laki-laki,perempuan';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'min:8';
        }

        $request->validate($rules);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'no_telpon' => $request->no_telpon,
        ];

        if (auth()->user()->role === 'super-admin' && $request->has('role')) {
            $data['role'] = $request->role;
        }

        if ($user->role === 'peminjam') {
            $data['nipd'] = $request->nipd;
            $data['kelas'] = $request->kelas;
            $data['alamat'] = $request->alamat;
            $data['tanggal_lahir'] = $request->tanggal_lahir;
            $data['jenis_kelamin'] = $request->jenis_kelamin;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diperbarui!');

        if (auth()->user()->role === 'admin') {
            $request->request->remove('role');
        }
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'peminjam') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dipindahkan ke tempat sampah.');
    }

    public function trash(Request $request)
    {
        $search = $request->get('search');

        $trashedUsers = User::onlyTrashed()
            ->when(auth()->user()->role === 'admin', function ($query) {
                $query->where('role', 'peminjam');
            })
            ->when($search, function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nipd', 'like', "%{$search}%");
            })
            ->latest('deleted_at')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.kelola_data_user.trash', compact('trashedUsers', 'search'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (auth()->user()->role === 'admin' && $user->role !== 'peminjam') {
            abort(403);
        }

        $user->restore();

        return redirect()->route('users.trash')
            ->with('success', 'User berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (auth()->user()->role === 'admin' && $user->role !== 'peminjam') {
            abort(403);
        }

        $user->forceDelete();

        return redirect()->route('users.trash')
            ->with('success', 'User berhasil dihapus secara permanen.');
    }

    private function getFilteredUsersQuery(Request $request)
    {
        $query = User::when(auth()->user()->role === 'admin', function ($query) {
            $query->where('role', 'peminjam');
        })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('nipd', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('role') && in_array($request->role, ['admin', 'peminjam']) && auth()->user()->role === 'super-admin', function ($query) use ($request) {
                $query->where('role', $request->role);
            })
            ->latest();

        return $query;
    }

    public function exportExcel(Request $request)
    {
        $query = $this->getFilteredUsersQuery($request);
        $users = $query->get();

        return Excel::download(new UserExport($users), 'users_' . date('Y-m-d_Hi') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = $this->getFilteredUsersQuery($request);
        $users = $query->get();

        $pdf = Pdf::loadView('admin.kelola_data_user.export_pdf', [
            'users' => $users,
            'filters' => [
                'search' => $request->search,
                'role'   => $request->role,
            ]
        ]);

        return $pdf->download('users_' . date('Y-m-d_Hi') . '.pdf');
    }
}
