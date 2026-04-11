@extends('layouts.admin')
@section('title', 'Kelola Laporan - KlikAset')
@section('content')

{{-- Header & Tombol Aksi --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Kelola Laporan</h1>
        <p class="text-sm text-gray-500 mt-0.5">Rekap pengembalian dan kondisi barang</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">

        {{-- Tombol Tempat Sampah --}}
        <a href="{{ route('reports.trash') }}"
           class="relative flex items-center gap-2 px-4 py-2.5 border-2 border-gray-300 text-gray-600 text-sm font-semibold rounded-full hover:bg-gray-50 transition">
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

        {{-- Export Excel --}}
<a href="{{ route('reports.export_excel', request()->query()) }}"
   class="flex items-center gap-2 px-4 py-2.5 border-2 border-green-200 rounded-full bg-green-50 text-green-700 text-sm font-semibold hover:bg-green-100 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Excel
</a>

        {{-- Export PDF --}}
<a href="{{ route('reports.export_pdf', request()->query()) }}"
   class="flex items-center gap-2 px-4 py-2.5 border-2 border-blue-200 rounded-full bg-blue-50 text-blue-700 text-sm font-semibold hover:bg-blue-100 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    PDF
</a>

        {{-- Tombol Tambah Laporan --}}
        <a href="{{ route('reports.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-costume-primary text-white text-sm font-semibold rounded-full hover:bg-blue-700 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Laporan
        </a>
    </div>
</div>

{{-- Filter & Pencarian --}}
<form method="GET" action="{{ route('reports.index') }}" id="filterForm">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">

            {{-- Pencarian --}}
            <div class="flex-1 relative">
                <label class="block text-xs font-medium text-gray-500 mb-1 ml-3">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam / barang..."
                    id="searchInput" class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
            </div>

            {{-- Filter Jenis Laporan --}}
            <div class="lg:w-52">
                <label class="block text-xs font-medium text-gray-500 mb-1 ml-3">Jenis Laporan</label>
                <div class="relative">
                    <select name="jenis_laporan" onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                        <option value="">Semua Jenis</option>
                        <option value="dikembalikan" {{ request('jenis_laporan') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="telat mengembalikan" {{ request('jenis_laporan') === 'telat mengembalikan' ? 'selected' : '' }}>Telat Mengembalikan</option>
                        <option value="hilang" {{ request('jenis_laporan') === 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Filter Kondisi --}}
            <div class="lg:w-48">
                <label class="block text-xs font-medium text-gray-500 mb-1 ml-3">Kondisi</label>
                <div class="relative">
                    <select name="kondisi_barang" onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                        <option value="">Semua Kondisi</option>
                        <option value="baik" {{ request('kondisi_barang') === 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="masih di pinjam" {{ request('kondisi_barang') === 'masih di pinjam' ? 'selected' : '' }}>Masih Di Pinjam</option>
                        <option value="rusak" {{ request('kondisi_barang') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Filter Tanggal Mulai --}}
            <div class="lg:w-48">
                <label class="block text-xs font-medium text-gray-500 mb-1 ml-3">Dari Tanggal</label>
                <div class="relative">
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition">
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            {{-- Filter Tanggal Sampai --}}
            <div class="lg:w-48">
                <label class="block text-xs font-medium text-gray-500 mb-1 ml-3">Sampai Tanggal</label>
                <div class="relative">
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition">
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            {{-- Tombol Reset Filter --}}
            @if(request('search') || request('jenis_laporan') || request('kondisi_barang') || request('start_date') || request('end_date'))
            <div class="lg:w-auto flex items-end">
                <a href="{{ route('reports.index') }}" class="flex items-center justify-center gap-2 px-5 py-3 bg-gray-100 text-gray-600 rounded-full text-sm font-semibold hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Reset Filter
                </a>
            </div>
            @endif
        </div>
    </div>
</form>

{{-- Tabel Data Laporan --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/80">
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">No</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Nama Peminjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Barang</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Tgl Pinjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Tgl Kembali</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Jenis Laporan</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Kondisi</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Foto</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $index => $laporan)
                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                    <td class="p-4 text-center text-sm text-gray-500">{{ $laporans->firstItem() + $index }}</td>
                    <td class="p-4">
                        <p class="font-medium text-center text-sm">{{ $laporan->peminjaman?->user?->username ?? '-' }}</p>
                        <p class="text-xs text-gray-500 text-center">{{ $laporan->peminjaman?->user?->email ?? '-' }}</p>
                    </td>
                    <td class="p-4">
                        @php $firstBarang = $laporan->peminjaman?->detailPeminjaman->first()?->barang; @endphp
                        <p class="font-medium text-center text-sm">{{ $firstBarang?->nama_barang ?? '-' }}</p>
                        <p class="text-xs text-gray-500 text-center">{{ $firstBarang?->kategori ?? '-' }}</p>
                    </td>
                    <td class="p-4">
                        <p class="font-semibold text-center text-sm whitespace-nowrap">{{ $laporan->tanggal_dipinjam?->format('d/m/Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-400 text-center">{{ $laporan->tanggal_dipinjam?->format('H:i') ?? '' }}</p>
                    </td>
                    <td class="p-4">
                        <p class="font-semibold text-center text-sm whitespace-nowrap">{{ $laporan->tanggal_dikembalikan?->format('d/m/Y') ?? '-' }}</p>
                        <p class="text-xs text-gray-400 text-center">{{ $laporan->tanggal_dikembalikan?->format('H:i') ?? '' }}</p>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full border whitespace-nowrap {{ $laporan->badge_jenis }}">
                                {{ $laporan->label_jenis }}
                            </span>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full border whitespace-nowrap {{ $laporan->badge_kondisi }}">
                                {{ $laporan->label_kondisi }}
                            </span>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center">
                            @if($laporan->foto_bukti)
                                <button type="button"
                                    onclick="openFotoModal('{{ asset('storage/' . $laporan->foto_bukti) }}')"
                                    class="w-10 h-10 rounded-[10px] overflow-hidden border-2 border-gray-200 hover:border-blue-400 transition"
                                    title="Lihat Foto">
                                    <img src="{{ asset('storage/' . $laporan->foto_bukti) }}" alt="Foto" class="w-full h-full object-cover"/>
                                </button>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('reports.edit', $laporan->id_laporan) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('reports.destroy', $laporan->id_laporan) }}" method="POST"
                                  onsubmit="return confirm('Pindahkan laporan ini ke tempat sampah?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition"
                                    title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="p-10 text-center text-gray-400 text-sm">
                        Belum ada data laporan{{ request('search') ? ' yang sesuai pencarian' : '' }}.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

{{-- PAGINATION CUSTOM (disesuaikan dengan tema costume-primary) --}}
@if($laporans->total() > 0)
<div class="flex flex-col lg:flex-row items-center justify-between gap-5 p-5 bg-white border-t border-gray-100 rounded-3xl shadow-sm">

    {{-- Bagian kiri: info range + tombol navigasi (prev, numbers, next) --}}
    <div class="flex flex-wrap items-center gap-3">
        {{-- Info jumlah data --}}
        <p class="text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-full">
            Menampilkan {{ $laporans->firstItem() }}–{{ $laporans->lastItem() }} dari {{ $laporans->total() }} laporan
        </p>

        {{-- Tombol Sebelumnya --}}
        @if($laporans->onFirstPage())
            <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">← Sebelumnya</span>
        @else
            <a href="{{ $laporans->previousPageUrl() }}" class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition shadow-sm">← Sebelumnya</a>
        @endif

        {{-- Daftar nomor halaman (dengan ellipsis jika terlalu banyak) --}}
        <div class="flex gap-1.5">
            @php
                $current = $laporans->currentPage();
                $last = $laporans->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);

                if ($start > 1) echo '<span class="px-3 py-2 text-gray-400">...</span>';
                for ($i = $start; $i <= $end; $i++) {
                    $activeClass = ($i == $current) ? 'bg-costume-primary text-white shadow-md' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50';
                    echo '<a href="' . $laporans->url($i) . '" class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium transition ' . $activeClass . '">' . $i . '</a>';
                }
                if ($end < $last) echo '<span class="px-3 py-2 text-gray-400">...</span>';
            @endphp
        </div>

        {{-- Tombol Selanjutnya --}}
        @if($laporans->hasMorePages())
            <a href="{{ $laporans->nextPageUrl() }}" class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition shadow-sm">Selanjutnya →</a>
        @else
            <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">Selanjutnya →</span>
        @endif
    </div>

    {{-- Bagian kanan: Lompat Halaman --}}
    <div class="flex items-center gap-2 rounded-full px-4 py-1.5">
        <span class="text-sm text-gray-500">Ke halaman :</span>
        <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2" id="jumpToPageForm">
            @foreach(request()->query() as $key => $value)
                @if($key != 'page')
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <input type="number" name="page" value="{{ $laporans->currentPage() }}" min="1" max="{{ $laporans->lastPage() }}"
                   class="w-9 px-3 py-1.5 border border-gray-300 rounded-full text-center text-sm focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
            <button type="submit" class="px-5 py-1.5 bg-costume-primary text-white text-sm font-medium rounded-full hover:bg-blue-700 transition shadow-md">Pergi</button>
        </form>
        <span class="text-sm text-gray-500">dari {{ $laporans->lastPage() }}</span>
    </div>
</div>
@endif
</div>

{{-- Modal Preview Foto --}}
<div id="fotoModal"
     class="fixed inset-0 z-50 hidden bg-black/60 items-center justify-center p-4"
     onclick="closeFotoModal()">
    <div class="relative max-w-2xl w-full" onclick="event.stopPropagation()">
        <button onclick="closeFotoModal()"
            class="absolute -top-4 -right-4 w-9 h-9 bg-white rounded-full flex items-center justify-center shadow-lg text-gray-600 hover:text-red-500 transition z-10">
            ✕
        </button>
        <img id="fotoModalImg" src="" alt="Foto Bukti" class="w-full rounded-2xl shadow-2xl"/>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Live Search
    let searchTimer;
    document.getElementById('searchInput')?.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    // Modal Foto
    function openFotoModal(src) {
        document.getElementById('fotoModalImg').src = src;
        const modal = document.getElementById('fotoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeFotoModal() {
        const modal = document.getElementById('fotoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('fotoModalImg').src = '';
    }
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeFotoModal(); });
</script>
@endpush
