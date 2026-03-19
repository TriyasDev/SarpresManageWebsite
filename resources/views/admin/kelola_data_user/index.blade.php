@extends('layouts.admin')

@section('title', 'Kelola Data User - KlikAset')

@section('content')

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 px-5 py-3 bg-green-100 text-green-700 rounded-[30px] border border-green-200 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-5 py-3 bg-red-100 text-red-700 rounded-[30px] border border-red-200 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header & Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Kelola Data User</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manajemen akun peminjam sarpras sekolah</p>
        </div>
        <div class="flex items-center gap-2">
            {{-- Tombol Tempat Sampah --}}
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

            {{-- Tombol Tambah User --}}
            <a href="{{ route('users.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 bg-costume-primary text-white text-sm font-semibold rounded-[30px] hover:bg-blue-700 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </a>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Cari nama user atau NIPD..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition" />
                <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2">
                    <x-icon-magnifer class="w-5 h-5 text-gray-400" />
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Data User --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80">
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">No</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Nama Lengkap</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">NIPD</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Alamat</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Tanggal Lahir</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Rank</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Jenis Kelamin</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                            <td class="p-4 text-center text-sm text-gray-500">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="p-4">
                                <p class="font-medium text-center text-sm">{{ $user->username }}</p>
                                <p class="text-xs text-gray-500 text-center">{{ $user->email }}</p>
                            </td>
                            <td class="p-4 text-center text-sm">{{ $user->nipd ?? '-' }}</td>
                            <td class="p-4 text-center text-xs text-gray-600 max-w-[150px] truncate">{{ $user->alamat ?? '-' }}</td>
                            <td class="p-4 text-center text-sm whitespace-nowrap">
                                {{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '-' }}
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200">
                                        {{ $user->rank ?? 'Reliant' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 text-center text-sm capitalize">{{ $user->jenis_kelamin ?? '-' }}</td>
                            <td class="p-4">
                                <div class="flex gap-2 justify-center">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('users.edit', $user->id_user) }}"
                                       class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 hover:bg-yellow-200 transition whitespace-nowrap">
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus (Soft Delete) --}}
                                    <form action="{{ route('users.destroy', $user->id_user) }}" method="POST"
                                          onsubmit="return confirm('Pindahkan user \'{{ addslashes($user->username) }}\' ke tempat sampah?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 hover:bg-red-200 transition whitespace-nowrap">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-10 text-center text-gray-400 text-sm">
                                Belum ada data user{{ $search ? ' yang sesuai pencarian' : '' }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white gap-4">
            <p class="text-xs lg:text-sm text-gray-600">
                Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user
            </p>
            <div class="flex items-center gap-2 flex-wrap justify-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>

@endsection
