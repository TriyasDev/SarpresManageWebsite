@extends('layouts.app')
@section('title', 'Semua Aset - KlikAset SMK BBC')
@section('content')

<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 mb-4">
                Semua <span class="text-costume-primary">Sarana & Prasarana</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Lengkap dengan informasi stok dan kondisi
            </p>
        </div>

        {{-- Search Bar --}}
        <div class="max-w-md mx-auto mb-10">
            <form method="GET" action="{{ route('all-assets') }}" class="relative">
                @if($activeKategori)
                    <input type="hidden" name="kategori" value="{{ $activeKategori }}">
                @endif
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari aset (nama atau deskripsi)..."
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-costume-primary focus:ring-2 focus:ring-costume-primary/20 transition-all outline-none shadow-sm">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                @if($search)
                    <a href="{{ route('all-assets', $activeKategori ? ['kategori' => $activeKategori] : []) }}"
                       class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </form>
        </div>

        {{-- Filter Kategori dengan tampilan lebih rapi --}}
        <div class="mb-12">
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('all-assets', ['search' => $search]) }}"
                   class="px-5 py-2 rounded-full font-medium text-sm transition-all
                          {{ $activeKategori === '' ? 'bg-costume-primary text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-700 border border-slate-200 hover:border-costume-primary hover:text-costume-primary' }}">
                    Semua
                </a>
                @foreach($kategoriList as $kat)
                <a href="{{ route('all-assets', ['kategori' => $kat, 'search' => $search]) }}"
                   class="px-5 py-2 rounded-full font-medium text-sm transition-all
                          {{ $activeKategori === $kat ? 'bg-costume-primary text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-700 border border-slate-200 hover:border-costume-primary hover:text-costume-primary' }}">
                    {{ $kat }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Informasi jumlah hasil --}}
        <div class="flex justify-between items-center mb-6 text-sm text-slate-500">
            <p>Menampilkan {{ $barangs->firstItem() ?? 0 }} - {{ $barangs->lastItem() ?? 0 }} dari {{ $barangs->total() }} aset</p>
            @if($activeKategori || $search)
                <a href="{{ route('all-assets') }}" class="text-costume-primary hover:underline">Reset filter</a>
            @endif
        </div>

        {{-- Grid Aset --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($barangs as $barang)
            <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-costume-primary hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative h-48 bg-gradient-to-br from-slate-100 to-slate-200">
                    @if($barang->foto && $barang->foto !== 'default.jpg')
                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 px-3 py-1.5 text-white text-xs font-bold rounded-full shadow-lg
                        @if($barang->jumlah_tersedia > 10) bg-emerald-500
                        @elseif($barang->jumlah_tersedia > 3) bg-amber-500
                        @elseif($barang->jumlah_tersedia > 0) bg-orange-500
                        @else bg-red-500 @endif">
                        {{ $barang->jumlah_tersedia > 0 ? $barang->jumlah_tersedia . ' Tersedia' : 'Habis' }}
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 bg-blue-50 text-costume-primary text-xs font-semibold rounded-full">
                            {{ $barang->kategori }}
                        </span>
                        <span class="text-xs font-medium
                            @if($barang->kondisi === 'baik') text-emerald-600
                            @elseif($barang->kondisi === 'rusak ringan') text-amber-600
                            @else text-red-600 @endif">
                            {{ ucfirst($barang->kondisi) }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 truncate">{{ $barang->nama_barang }}</h3>
                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-4">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="truncate">{{ $barang->deskripsi }}</span>
                    </div>
                    <a href="{{ route('borrow', ['barang' => $barang->id_barang]) }}"
                       class="block w-full py-2.5 text-center bg-costume-primary text-white rounded-lg font-semibold text-sm hover:bg-costume-primary/90 transition-all shadow-sm">
                        Pinjam Sekarang
                    </a>
                </div>
            </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400">
                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-medium">Tidak ada aset yang ditemukan.</p>
                    <p class="text-sm mt-1">Coba kata kunci lain atau reset filter.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $barangs->links() }}
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('index') }}#pinjam" class="text-costume-primary hover:underline inline-flex items-center gap-1">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

@endsection
