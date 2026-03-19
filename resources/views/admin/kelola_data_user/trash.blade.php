@extends('layouts.admin')

@section('title', 'Tempat Sampah User - KlikAset')

@section('content')

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 px-5 py-3 bg-green-100 text-green-700 rounded-[30px] border border-green-200 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <span class="text-gray-300">/</span>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Tempat Sampah</h1>
                <p class="text-sm text-gray-500 mt-0.5">User yang telah dihapus sementara</p>
            </div>
        </div>
    </div>

    {{-- Info Banner --}}
    <div class="flex items-start gap-3 mb-6 px-5 py-4 bg-amber-50 border border-amber-200 rounded-[20px] text-sm text-amber-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>User di tempat sampah tidak bisa login. Pulihkan untuk mengaktifkan kembali, atau hapus permanen untuk menghapus seluruh datanya.</span>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
        <form action="{{ route('users..trash') }}" method="GET">
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

    {{-- Tabel User Sampah --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80">
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">No</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Nama Lengkap</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">NIPD</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Rank</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Jenis Kelamin</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Dihapus Pada</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedUsers as $index => $user)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                            <td class="p-4 text-center text-sm text-gray-500">
                                {{ $trashedUsers->firstItem() + $index }}
                            </td>
                            <td class="p-4">
                                <p class="font-medium text-center text-sm text-gray-700">{{ $user->username }}</p>
                                <p class="text-xs text-gray-400 text-center">{{ $user->email }}</p>
                            </td>
                            <td class="p-4 text-center text-sm text-gray-600">{{ $user->nipd ?? '-' }}</td>
                            <td class="p-4">
                                <div class="flex justify-center">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-semibold rounded-[30px] border border-gray-200">
                                        {{ $user->rank ?? 'Reliant' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 text-center text-sm capitalize text-gray-600">{{ $user->jenis_kelamin ?? '-' }}</td>
                            <td class="p-4 text-center text-xs text-gray-500 whitespace-nowrap">
                                {{ $user->deleted_at->format('d M Y, H:i') }}
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2 justify-center">
                                    {{-- Tombol Pulihkan --}}
                                    <form action="{{ route('users..restore', $user->id_user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 hover:bg-green-200 transition whitespace-nowrap">
                                            Pulihkan
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus Permanen --}}
                                    <form action="{{ route('users..force_delete', $user->id_user) }}" method="POST"
                                          onsubmit="return confirm('Hapus permanen user \'{{ addslashes($user->username) }}\'? Data tidak dapat dikembalikan!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 hover:bg-red-200 transition whitespace-nowrap">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-gray-400 text-sm">
                                Tempat sampah kosong{{ $search ? ' — tidak ada hasil untuk pencarian ini' : '' }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white gap-4">
            <p class="text-xs lg:text-sm text-gray-600">
                Menampilkan {{ $trashedUsers->firstItem() ?? 0 }}–{{ $trashedUsers->lastItem() ?? 0 }} dari {{ $trashedUsers->total() }} user
            </p>
            <div class="flex items-center gap-2 flex-wrap justify-center">
                {{ $trashedUsers->links() }}
            </div>
        </div>
    </div>

@endsection
