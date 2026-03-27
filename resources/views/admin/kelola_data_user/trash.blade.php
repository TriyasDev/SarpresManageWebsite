{{-- resources/views/admin/kelola_data_user/trash.blade.php --}}
@extends('layouts.admin')
@section('title', 'Tempat Sampah User - KlikAset')

@section('content')
    @if(session('success'))
        <div id="flashMsg" class="mb-5 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashMsg').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">&times;</button>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('users.index') }}" class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <span class="text-gray-300">/</span>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Tempat Sampah User</h1>
                <p class="text-sm text-gray-500 mt-0.5">User yang telah dihapus sementara</p>
            </div>
        </div>
    </div>

    <div class="flex items-start gap-3 mb-6 px-5 py-4 bg-amber-50 border border-amber-200 rounded-[20px] text-sm text-amber-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>User di sini tidak tampil di halaman utama. Pulihkan untuk mengaktifkan kembali, atau hapus permanen.</span>
    </div>

    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm p-5 mb-6">
        <form action="{{ route('users.trash') }}" method="GET">
            <div class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari username, email, atau NIPD..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2">
                    <x-icon-magnifer class="w-5 h-5 text-gray-400"/>
                </button>
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
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Dihapus Pada</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trashedUsers as $user)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition opacity-80">
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
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->deleted_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('users.restore', $user->id_user) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">Pulihkan</button>
                            </form>
                            <form method="POST" action="{{ route('users.force_delete', $user->id_user) }}" onsubmit="return confirm('Hapus permanen user ini? Data tidak dapat dikembalikan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus Permanen</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">Tempat sampah kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($trashedUsers->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 bg-white rounded-[30px] border border-gray-100 p-4 gap-4">
        <p class="text-xs lg:text-sm text-gray-600">
            Menampilkan {{ $trashedUsers->firstItem() ?? 0 }}–{{ $trashedUsers->lastItem() ?? 0 }} dari {{ $trashedUsers->total() }} user
        </p>
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{ $trashedUsers->links() }}
        </div>
    </div>
    @endif
@endsection
