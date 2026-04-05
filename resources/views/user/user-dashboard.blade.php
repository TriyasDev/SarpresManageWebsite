@extends('layouts.user')

@section('title', 'Dashboard User - KlikAset')

{{-- Optional: font Inter dari Google Fonts (minimal) --}}
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
<style>
    /* Hanya fallback font, semua styling lain pakai Tailwind */
    body {
        font-family: 'Inter', sans-serif;
    }
    footer { display: none !important; }
</style>
@endpush

@section('content')
<div class="flex min-h-screen bg-slate-50">
    {{-- Sidebar user (sudah diperbaiki) --}}
    @include('partials.sidebar-user')

    {{-- Main content --}}
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
            {{-- Welcome Card dengan gradien tema sidebar --}}
            <div class="bg-gradient-to-r from-costume-primary to-costume-second rounded-2xl p-6 text-white shadow-lg">
                <h1 class="text-2xl font-bold">Halo, {{ $user->nama ?? $user->username ?? 'Pengguna' }}!</h1>
                <p class="text-white/80 mt-1">Kelola peminjaman aset dengan mudah & transparan.</p>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                {{-- Card Total Poin --}}
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Poin Aktif</span>
                    </div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Total Poin</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($currentPoints ?? 2450) }}</p>
                    <div class="mt-3 space-y-1">
                        <div class="flex justify-between text-xs text-slate-500">
                            <span>Menuju {{ $nextTier ?? 'Gold' }}</span>
                            <span>{{ $currentPoints ?? 2450 }} / {{ $nextTier ? ($tierRequirements[$nextTier]['min_points'] ?? 3000) : 3000 }}</span>
                        </div>
                        <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-amber-500 h-full rounded-full transition-all duration-700" style="width: {{ $percentage ?? 82 }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Card Pinjaman Aktif --}}
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Aktif</span>
                    </div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Pinjaman Aktif</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $activeLoans ?? 3 }}</p>
                    @if(isset($activeLoansList) && $activeLoansList->first())
                        <p class="text-xs text-slate-500 mt-2">Terdekat: {{ $activeLoansList->first()->tanggal_kembali->format('d M Y') }}</p>
                    @else
                        <p class="text-xs text-slate-500 mt-2">Tidak ada pinjaman aktif</p>
                    @endif
                </div>

                {{-- Card Peringkat & Tier (STATIS contoh) --}}
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-5 text-white shadow-sm hover:shadow-md transition hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-white/20 text-white">Tier & Peringkat</span>
                    </div>
                    <p class="text-xs uppercase tracking-wide opacity-80">Peringkat Kamu</p>
                    <p class="text-3xl font-bold mt-1">{{ $currentTier ?? 'Silver' }}</p>
                    <p class="text-sm mt-2">
                        🏆 Peringkat <strong>#{{ $rank ?? 8 }}</strong> dari {{ $totalUsers ?? 94 }} pengguna
                    </p>
                    <div class="mt-3 text-xs opacity-80 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        <span>Butuh {{ $pointsToNextRank ?? 550 }} poin lagi ke peringkat berikutnya</span>
                    </div>
                </div>
            </div>

            {{-- Daftar Pinjaman Aktif --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center flex-wrap gap-2">
                    <div>
                        <h2 class="font-bold text-slate-800">Pinjaman Aktif</h2>
                        <p class="text-xs text-slate-500">Barang yang sedang kamu pinjam</p>
                    </div>
                    <a href="{{ route('loans') }}" class="text-sm text-costume-primary font-semibold hover:underline flex items-center gap-1">
                        Lihat semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                @if(isset($activeLoansList) && $activeLoansList->count())
                    <div class="divide-y divide-slate-100">
                        @foreach($activeLoansList->take(3) as $loan)
                            @php $barang = $loan->first_barang ?? null; @endphp
                            <div class="p-4 hover:bg-slate-50 transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-slate-800">{{ $barang->nama_barang ?? 'Aset Tidak Diketahui' }}</h3>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $barang->kategori ?? '-' }} · {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $loan->status == 'disetujui' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $loan->status == 'disetujui' ? 'Disetujui' : 'Dipinjam' }}
                                    </span>
                                </div>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-xs text-slate-500">Jumlah: {{ $loan->detailPeminjaman->first()->jumlah ?? 1 }} unit</span>
                                    <button onclick="openDetailModal(
                                        '{{ addslashes($barang->nama_barang ?? 'Aset') }}',
                                        '{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}',
                                        '{{ $loan->status == 'disetujui' ? 'Disetujui' : 'Dipinjam' }}',
                                        '{{ addslashes($barang->kategori ?? '-') }}'
                                    )" class="text-xs text-costume-primary font-medium hover:underline">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p>Tidak ada pinjaman aktif saat ini.</p>
                        <a href="{{ route('all-assets') }}" class="inline-block mt-3 text-costume-primary text-sm font-semibold">Ajukan peminjaman →</a>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- Modal Detail --}}
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
    function openDetailModal(name, date, status, type) {
        const statusBadge = (status === 'Dipinjam')
            ? 'bg-blue-100 text-blue-800'
            : 'bg-amber-100 text-amber-800';
        document.getElementById('modalContent').innerHTML = `
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Aset</span><span class="font-semibold">${name}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="text-slate-500">Kategori</span><span>${type}</span></div>
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
