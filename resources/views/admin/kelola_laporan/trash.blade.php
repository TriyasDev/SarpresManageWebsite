@extends('layouts.admin')
@section('title', 'Tempat Sampah Laporan - KlikAset')
@section('content')

{{-- Alert --}}
@if(session('success'))
    <div id="flashSuccess"
         class="mb-4 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flashSuccess').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">✕</button>
    </div>
@endif

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.kelola_laporan.index') }}"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <span class="text-gray-300">/</span>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Tempat Sampah Laporan</h1>
            <p class="text-sm text-gray-500 mt-0.5">Laporan yang telah dihapus sementara</p>
        </div>
    </div>
    <span class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 self-start sm:self-auto">
        {{ $laporans->total() }} item di sampah
    </span>
</div>

{{-- Info Banner --}}
<div class="flex items-start gap-3 mb-6 px-5 py-4 bg-amber-50 border border-amber-200 rounded-[20px] text-sm text-amber-700">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span>Laporan di sini tidak tampil di halaman utama. Pulihkan untuk mengaktifkan kembali, atau hapus permanen untuk menghapus beserta foto buktinya.</span>
</div>

{{-- Search --}}
<div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
    <form action="{{ route('admin.kelola_laporan.trash') }}" method="GET">
        <div class="relative">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari peminjam / barang..."
                class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
            <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2">
                <x-icon-magnifer class="w-5 h-5 text-gray-400"/>
            </button>
        </div>
    </form>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 bg-red-50/60">
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">No</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Nama Peminjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Barang</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Jenis Laporan</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Kondisi</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Dihapus Pada</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $index => $laporan)
                <tr class="border-b border-gray-100 hover:bg-red-50/30 transition">
                    <td class="p-4 text-center text-sm text-gray-500">
                        {{ $laporans->firstItem() + $index }}
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-center text-sm text-gray-500">
                            {{ $laporan->peminjam?->user?->username ?? '-' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-center text-sm text-gray-500">
                            {{ $laporan->peminjam?->aset?->nama_barang ?? '-' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-[30px] border opacity-60 {{ $laporan->badge_jenis }}">
                                {{ $laporan->label_jenis }}
                            </span>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-[30px] border opacity-60 {{ $laporan->badge_kondisi }}">
                                {{ $laporan->label_kondisi }}
                            </span>
                        </div>
                    </td>
                    <td class="p-4 text-center text-xs text-gray-400 whitespace-nowrap">
                        {{ $laporan->deleted_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-2">

                            {{-- Pulihkan --}}
                            <form action="{{ route('admin.kelola_laporan.restore', $laporan->id_laporan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-4 py-1.5 bg-green-50 text-green-600 border border-green-200 rounded-[30px] text-xs font-semibold hover:bg-green-100 transition whitespace-nowrap">
                                    Pulihkan
                                </button>
                            </form>

                            {{-- Hapus Permanen --}}
                            <form action="{{ route('admin.kelola_laporan.force_delete', $laporan->id_laporan) }}" method="POST"
                                  onsubmit="return confirm('Hapus PERMANEN laporan ini? Foto bukti juga akan dihapus dan tidak bisa dikembalikan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-[30px] text-xs font-semibold hover:bg-red-100 transition whitespace-nowrap">
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
    @if($laporans->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between p-4 gap-4">
        <p class="text-xs lg:text-sm text-gray-600">
            Menampilkan {{ $laporans->firstItem() }}–{{ $laporans->lastItem() }} dari {{ $laporans->total() }}
        </p>
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{ $laporans->links() }}
        </div>
    </div>
    @endif
</div>

@endsection
