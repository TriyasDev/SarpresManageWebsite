@extends('layouts.admin')
@section('title', 'Trash Laporan - KlikAset')
@section('content')

{{-- Header --}}
<div class="mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.kelola_laporan') }}"
           class="flex items-center gap-2 text-gray-500 hover:text-gray-800 transition text-sm font-medium"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-800 font-semibold text-sm">Trash Laporan</span>
    </div>
    <span class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200">
        {{ $laporans->total() }} item di trash
    </span>
</div>

{{-- Flash Message --}}
@if(session('success'))
    <div id="flashSuccess"
         class="mb-4 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flashSuccess').remove()" class="ml-4 text-green-500 hover:text-green-700">✕</button>
    </div>
@endif

{{-- Tabel --}}
<div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 bg-red-50/60">
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Nama Peminjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Barang</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Jenis Laporan</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Kondisi</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Dihapus Pada</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $laporan)
                <tr class="border-b border-gray-100 hover:bg-red-50/30 transition">
                    <td class="p-4">
                        <p class="font-medium text-center text-sm text-gray-500">
                            {{ $laporan->peminjam?->user?->nama ?? '-' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-center text-sm text-gray-500">
                            {{ $laporan->peminjam?->aset?->nama_aset ?? '-' }}
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
                    <td class="p-4 text-center text-xs text-gray-400">
                        {{ $laporan->deleted_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-2">

                            {{-- Restore --}}
                            <form action="{{ route('admin.kelola_laporan.restore', $laporan->id_laporan) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="px-4 py-1.5 bg-green-50 text-green-600 border border-green-200 rounded-[30px] text-xs font-semibold hover:bg-green-100 transition"
                                    title="Pulihkan"
                                >
                                    Pulihkan
                                </button>
                            </form>

                            {{-- Force Delete --}}
                            <form action="{{ route('admin.kelola_laporan.force_delete', $laporan->id_laporan) }}" method="POST"
                                  onsubmit="return confirm('Hapus PERMANEN laporan ini? Tindakan ini tidak dapat diurungkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-[30px] text-xs font-semibold hover:bg-red-100 transition"
                                    title="Hapus Permanen"
                                >
                                    Hapus Permanen
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-gray-400 text-sm">
                        Trash kosong. Tidak ada laporan yang dihapus.
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
        {{ $laporans->links() }}
    </div>
    @endif
</div>

@endsection
