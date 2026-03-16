@extends('layouts.admin')
@section('title', 'Tempat Sampah Aset - KlikAset')

@section('content')

    {{-- Alert --}}
    @if(session('success'))
        <div id="flashMsg" class="mb-5 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashMsg').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kelola_aset.index') }}"
               class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <span class="text-gray-300">/</span>
            <div>
                <h1 class="text-xl font-bold text-gray-800">Tempat Sampah Aset</h1>
                <p class="text-sm text-gray-500 mt-0.5">Aset yang telah dihapus sementara</p>
            </div>
        </div>
    </div>

    {{-- Info Banner --}}
    <div class="flex items-start gap-3 mb-6 px-5 py-4 bg-amber-50 border border-amber-200 rounded-[20px] text-sm text-amber-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Aset di sini tidak tampil di halaman utama. Pulihkan untuk mengaktifkan kembali, atau hapus permanen untuk menghapus beserta fotonya.</span>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-[30px] border border-gray-100 shadow-sm p-5 mb-6">
        <form action="{{ route('admin.kelola_aset.trash') }}" method="GET">
            <div class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                    placeholder="Cari nama aset..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2">
                    <x-icon-magnifer class="w-5 h-5 text-gray-400"/>
                </button>
            </div>
        </form>
    </div>

    {{-- Card Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($trashedBarangs as $barang)
        <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden flex flex-col opacity-80">

            {{-- Gambar --}}
            <div class="h-44 bg-gray-100 flex items-center justify-center overflow-hidden rounded-t-[30px] relative">
                @if($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover grayscale"/>
                @else
                    <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                @endif
                {{-- Badge sampah --}}
                <div class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-[30px]">
                    Dihapus
                </div>
            </div>

            {{-- Info --}}
            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-bold text-gray-700 text-sm mb-1 truncate">{{ $barang->nama_barang }}</h3>
                <span class="inline-block text-xs bg-gray-100 text-gray-500 font-semibold px-3 py-0.5 rounded-[30px] mb-2 w-fit">{{ $barang->kategori }}</span>
                <p class="text-xs text-gray-400 mt-auto">
                    Dihapus: {{ $barang->deleted_at->format('d M Y, H:i') }}
                </p>

                {{-- Aksi --}}
                <div class="flex gap-2 mt-4">
                    {{-- Pulihkan --}}
                    <form method="POST" action="{{ route('admin.kelola_aset.restore', $barang->id_barang) }}" class="flex-1">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="w-full py-2 text-xs font-semibold bg-green-100 text-green-700 rounded-[30px] hover:bg-green-200 transition border border-green-200">
                            Pulihkan
                        </button>
                    </form>

                    {{-- Hapus Permanen --}}
                    <form method="POST" action="{{ route('admin.kelola_aset.force_delete', $barang->id_barang) }}"
                          onsubmit="return confirm('Hapus permanen \'{{ addslashes($barang->nama_barang) }}\'? Foto juga akan dihapus dan tidak bisa dikembalikan!')"
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full py-2 text-xs font-semibold bg-red-100 text-red-600 rounded-[30px] hover:bg-red-200 transition border border-red-200">
                            Hapus Permanen
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 flex flex-col items-center text-gray-400">
            <svg class="w-14 h-14 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <p class="text-base font-medium">Tempat sampah kosong{{ $search ? ' — tidak ada hasil untuk pencarian ini' : '' }}.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($trashedBarangs->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 bg-white rounded-[30px] border border-gray-100 p-4 gap-4">
        <p class="text-xs lg:text-sm text-gray-600">
            Menampilkan {{ $trashedBarangs->firstItem() ?? 0 }}–{{ $trashedBarangs->lastItem() ?? 0 }} dari {{ $trashedBarangs->total() }} aset
        </p>
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{ $trashedBarangs->links() }}
        </div>
    </div>
    @endif

@endsection
