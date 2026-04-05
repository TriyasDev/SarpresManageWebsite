@extends('layouts.user')

@section('title', 'Pinjaman Aktif - KlikAset')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    footer { display: none !important; }
</style>
@endpush

@section('content')
<div class="flex min-h-screen bg-slate-50">
    @include('partials.sidebar-user')

    <div class="flex-1 lg:ml-64">
        {{-- Mobile header --}}
        <div class="lg:hidden sticky top-0 z-20 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 py-3 flex items-center justify-between">
            <button onclick="openSidebarUser()" class="p-2 rounded-lg hover:bg-slate-100 transition">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <span class="font-bold text-slate-800">KlikAset</span>
            <div class="w-8"></div>
        </div>

        <main class="p-4 md:p-6 space-y-6">
            {{-- Header dengan statistik --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-wrap justify-between items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Pinjaman Aktif</h1>
                    <p class="text-slate-500 text-sm mt-1">Daftar aset yang sedang Anda pinjam</p>
                </div>
                <div class="bg-costume-primary/10 rounded-full px-4 py-2">
                    <span class="text-costume-primary font-bold text-lg">{{ $activeLoans->count() }}</span>
                    <span class="text-slate-600 text-sm"> pinjaman aktif</span>
                </div>
            </div>

            {{-- Grid card pinjaman --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($activeLoans as $loan)
                    @php
                        $barang = $loan->first_barang ?? null;
                        $namaBarang = $barang->nama_barang ?? 'Aset tidak diketahui';
                        $kategori = $barang->kategori ?? '-';
                        $tanggalPinjam = \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y');
                        $tanggalKembali = \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y');
                        $status = $loan->status ?? 'dipinjam';
                        $jumlah = $loan->detailPeminjaman->first()->jumlah ?? 1;

                        // Badge color based on status
                        $badgeClass = $status == 'disetujui' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800';
                        $statusText = $status == 'disetujui' ? 'Disetujui' : 'Dipinjam';
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1 overflow-hidden">
                        <div class="p-5">
                            {{-- Header card: icon + status --}}
                            <div class="flex justify-between items-start mb-3">
                                <div class="w-10 h-10 rounded-xl bg-costume-primary/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-costume-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            {{-- Nama barang & kategori --}}
                            <h3 class="font-bold text-slate-800 text-lg">{{ $namaBarang }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $kategori }}</p>

                            {{-- Detail peminjaman --}}
                            <div class="mt-4 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Jumlah</span>
                                    <span class="font-medium text-slate-700">{{ $jumlah }} unit</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Tanggal pinjam</span>
                                    <span class="font-medium text-slate-700">{{ $tanggalPinjam }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Tanggal kembali</span>
                                    <span class="font-medium text-slate-700">{{ $tanggalKembali }}</span>
                                </div>
                            </div>

                            {{-- Tombol detail --}}
                            <button onclick="openDetailModal(
                                '{{ addslashes($namaBarang) }}',
                                '{{ $tanggalPinjam }} - {{ $tanggalKembali }}',
                                '{{ $statusText }}',
                                '{{ addslashes($kategori) }}',
                                '{{ $jumlah }}'
                            )" class="mt-5 w-full py-2 rounded-xl border border-costume-primary/30 text-costume-primary font-semibold text-sm hover:bg-costume-primary hover:text-white transition duration-200">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center shadow-sm">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="text-lg font-semibold text-slate-700">Tidak ada pinjaman aktif</h3>
                            <p class="text-slate-500 mt-1">Anda belum meminjam aset apapun saat ini.</p>
                            <a href="{{ route('all-assets') }}" class="inline-block mt-4 px-5 py-2 bg-costume-primary text-white rounded-xl text-sm font-semibold hover:bg-costume-primary/90 transition">
                                + Ajukan Peminjaman
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>

{{-- Modal Detail (sama seperti di dashboard) --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4" onclick="if(event.target===this) closeModal()">
    <div class="bg-white rounded-2xl max-w-sm w-full shadow-xl overflow-hidden">
        <div class="bg-costume-primary px-5 py-4 text-white flex justify-between items-center">
            <span class="font-bold">Detail Peminjaman</span>
            <button onclick="closeModal()" class="text-white/80 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="p-5 space-y-3 text-sm" id="modalContent"></div>
        <div class="px-5 pb-5">
            <button onclick="closeModal()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold py-2 rounded-xl transition">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openDetailModal(name, date, status, type, qty) {
        const statusBadge = (status === 'Dipinjam')
            ? 'bg-blue-100 text-blue-800'
            : 'bg-amber-100 text-amber-800';
        document.getElementById('modalContent').innerHTML = `
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Aset</span><span class="font-semibold">${name}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Kategori</span><span>${type}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Jumlah</span><span>${qty} unit</span></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Periode</span><span>${date}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Status</span><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold ${statusBadge}">${status}</span></div>
        `;
        document.getElementById('detailModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection
