{{-- resources/views/admin/kelola_data_user/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Kelola User - KlikAset')

@section('content')
    @if(session('success'))
        <div id="flashMsg" class="mb-5 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashMsg').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">&times;</button>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Kelola User</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manajemen akun peminjam dan admin</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('users.trash') }}"
               class="relative flex items-center gap-2 px-4 py-2.5 border-2 border-gray-300 text-gray-600 text-sm font-semibold rounded-[30px] hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Sampah
                @if($trashedCount > 0)
                    <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        {{ $trashedCount > 99 ? '99+' : $trashedCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('users.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 bg-costume-primary text-white text-sm font-semibold rounded-[30px] hover:bg-blue-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari username, email, atau NIPD..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
            </div>
            @if(auth()->user()->role === 'super-admin')
            <div class="lg:w-48">
                <select name="role" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                </select>
            </div>
            @endif
            <div>
                <button type="submit" class="px-6 py-3 bg-costume-primary text-white rounded-[30px] text-sm font-semibold hover:bg-blue-700 transition">Filter</button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-[30px] border border-gray-100 shadow-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Username</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">NIPD / Kelas</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">No Telpon</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $user->username }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        @if($user->role === 'peminjam')
                            {{ $user->nipd ?? '-' }} / {{ $user->kelas ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->no_telpon ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Pindahkan user ini ke sampah?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">Tidak ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 bg-white rounded-[30px] border border-gray-100 p-4 gap-4">
        <p class="text-xs lg:text-sm text-gray-600">
            Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user
        </p>
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{ $users->links() }}
        </div>
    </div>
    @endif
@endsection
