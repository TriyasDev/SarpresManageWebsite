@extends('layouts.admin')
@section('title', 'Kelola Laporan - KlikAset')
@section('content')

{{-- Alert --}}
@if(session('success'))
    <div id="flashSuccess"
         class="mb-4 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flashSuccess').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">✕</button>
    </div>
@endif

{{-- Header & Tombol Aksi --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Kelola Laporan</h1>
        <p class="text-sm text-gray-500 mt-0.5">Rekap pengembalian dan kondisi barang</p>
    </div>
    <div class="flex items-center gap-2 flex-wrap">

        {{-- Tombol Tempat Sampah --}}
        <a href="{{ route('reports.trash') }}"
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

        {{-- Export Excel --}}
        <a href="{{ route('reports.export_excel', request()->query()) }}"
           class="flex items-center gap-2 px-4 py-2.5 border-2 border-green-200 rounded-[30px] bg-green-50 text-green-700 text-sm font-semibold hover:bg-green-100 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Excel
        </a>

        {{-- Export PDF --}}
        <a href="{{ route('reports.export_pdf', request()->query()) }}"
           class="flex items-center gap-2 px-4 py-2.5 border-2 border-blue-200 rounded-[30px] bg-blue-50 text-blue-700 text-sm font-semibold hover:bg-blue-100 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            PDF
        </a>

        {{-- Tombol Tambah Laporan --}}
        <a href="{{ route('reports.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-costume-primary text-white text-sm font-semibold rounded-[30px] hover:bg-blue-700 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Laporan
        </a>
    </div>
</div>

{{-- Filter & Pencarian --}}
<form method="GET" action="{{ route('reports.index') }}" id="filterForm">
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">

            {{-- Pencarian --}}
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari peminjam / barang..."
                    id="searchInput"
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"
                />
                <x-icon-magnifer class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
            </div>

            {{-- Filter Jenis Laporan --}}
            <div class="lg:w-52">
                <div class="relative">
                    <select name="jenis_laporan"
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                        <option value="">Semua Jenis</option>
                        <option value="dikembalikan"        {{ request('jenis_laporan') === 'dikembalikan'        ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="telat mengembalikan" {{ request('jenis_laporan') === 'telat mengembalikan' ? 'selected' : '' }}>Telat Mengembalikan</option>
                        <option value="hilang"              {{ request('jenis_laporan') === 'hilang'              ? 'selected' : '' }}>Hilang</option>
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
                <div class="relative">
                    <select name="kondisi_barang"
                        onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                        <option value="">Semua Kondisi</option>
                        <option value="baik"             {{ request('kondisi_barang') === 'baik'            ? 'selected' : '' }}>Baik</option>
                        <option value="masih di pinjam"  {{ request('kondisi_barang') === 'masih di pinjam' ? 'selected' : '' }}>Masih Di Pinjam</option>
                        <option value="rusak"            {{ request('kondisi_barang') === 'rusak'           ? 'selected' : '' }}>Rusak</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tombol Filter --}}
            <div class="lg:w-auto">
                <button type="submit"
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] bg-white text-sm font-medium hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <x-icon-filter class="w-4 h-4"/>
                    Filter
                </button>
            </div>
        </div>
    </div>
</form>

{{-- Tabel Data Laporan --}}
<div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
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

                    {{-- No --}}
                    <td class="p-4 text-center text-sm text-gray-500">
                        {{ $laporans->firstItem() + $index }}
                    </td>

                    {{-- Nama Peminjam --}}
                    <td class="p-4">
                        <p class="font-medium text-center text-sm">{{ $laporan->peminjam?->user?->username ?? '-' }}</p>
                        <p class="text-xs text-gray-500 text-center">{{ $laporan->peminjam?->user?->email ?? '-' }}</p>
                    </td>

                    {{-- Nama Aset --}}
                    <td class="p-4">
                        <p class="font-medium text-center text-sm">{{ $laporan->peminjam?->aset?->nama_barang ?? '-' }}</p>
                        <p class="text-xs text-gray-500 text-center">{{ $laporan->peminjam?->aset?->kategori ?? '-' }}</p>
                    </td>

                    {{-- Tgl Dipinjam --}}
                    <td class="p-4">
                        <p class="font-semibold text-center text-sm whitespace-nowrap">
                            {{ $laporan->tanggal_dipinjam?->format('d/m/Y') ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-400 text-center">
                            {{ $laporan->tanggal_dipinjam?->format('H:i') ?? '' }}
                        </p>
                    </td>

                    {{-- Tgl Dikembalikan --}}
                    <td class="p-4">
                        <p class="font-semibold text-center text-sm whitespace-nowrap">
                            {{ $laporan->tanggal_dikembalikan?->format('d/m/Y') ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-400 text-center">
                            {{ $laporan->tanggal_dikembalikan?->format('H:i') ?? '' }}
                        </p>
                    </td>

                    {{-- Jenis Laporan --}}
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-[30px] border whitespace-nowrap {{ $laporan->badge_jenis }}">
                                {{ $laporan->label_jenis }}
                            </span>
                        </div>
                    </td>

                    {{-- Kondisi Barang --}}
                    <td class="p-4">
                        <div class="flex justify-center">
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-[30px] border whitespace-nowrap {{ $laporan->badge_kondisi }}">
                                {{ $laporan->label_kondisi }}
                            </span>
                        </div>
                    </td>

                    {{-- Foto Bukti --}}
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

                    {{-- Aksi --}}
                    <td class="p-4">
                        <div class="flex justify-center items-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('reports.edit', $laporan->id_laporan) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            {{-- Hapus (soft delete) --}}
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

    {{-- Pagination --}}
    <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white gap-4">
        <p class="text-xs lg:text-sm text-gray-600">
            Menampilkan {{ $laporans->firstItem() ?? 0 }}–{{ $laporans->lastItem() ?? 0 }} dari {{ $laporans->total() }} laporan
        </p>
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{ $laporans->links() }}
        </div>
    </div>
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
        <img id="fotoModalImg" src="" alt="Foto Bukti" class="w-full rounded-[20px] shadow-2xl"/>
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
