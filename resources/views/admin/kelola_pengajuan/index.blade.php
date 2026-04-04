@extends('layouts.admin')
@section('title', 'Kelola Pengajuan - KlikAset')
@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">Kelola Pengajuan</h1>
        <p class="text-sm text-gray-500 mt-0.5">Daftar pengajuan peminjaman barang</p>
    </div>
    {{-- Tidak ada tombol aksi kanan agar fokus ke pengajuan --}}
</div>

{{-- Flash Message --}}
@if(session('success'))
    <div id="flashSuccess"
         class="mb-6 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-full text-sm font-medium flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flashSuccess').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">✕</button>
    </div>
@endif

{{-- Statistik Card (minimalis, seperti gaya laporan) --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    {{-- Disetujui Bulan Ini --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium">Total Disetujui<br>Bulan Ini</p>
            <p class="text-3xl font-bold text-gray-900">{{ $statDisetujui }}</p>
        </div>
    </div>

    {{-- Ditolak Bulan Ini --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium">Total Ditolak<br>Bulan Ini</p>
            <p class="text-3xl font-bold text-gray-900">{{ $statDitolak }}</p>
        </div>
    </div>

    {{-- Menunggu --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-gray-500 font-medium">Menunggu<br>Persetujuan</p>
            <p class="text-3xl font-bold text-gray-900">{{ $statMenunggu }}</p>
        </div>
    </div>
</div>

{{-- Filter & Pencarian (gaya rounded-full seperti laporan) --}}
<form method="GET" action="{{ route('approvals.index') }}" id="filterForm">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">

            {{-- Search --}}
            <div class="flex-1 relative">
                <input type="text" name="search" id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Cari nama peminjam, NIPD, atau barang..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition">
                <svg class="w-5 h-5 absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- Filter Status --}}
            <div class="lg:w-52">
                <div class="relative">
                    <select name="status" onchange="document.getElementById('filterForm').submit()"
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-full outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                        <option value="">Semua Status</option>
                        <option value="menunggu"     {{ request('status') === 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui"    {{ request('status') === 'disetujui'    ? 'selected' : '' }}>Disetujui</option>
                        <option value="dipinjam"     {{ request('status') === 'dipinjam'     ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="ditolak"      {{ request('status') === 'ditolak'      ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Tabel Pengajuan --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[900px]">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/80">
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">No</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Nama Peminjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Barang</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Tgl Pinjam</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Tgl Kembali</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Status</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Catatan</th>
                    <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $index => $p)
                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                    <td class="p-4 text-center text-sm text-gray-500">{{ $pengajuans->firstItem() + $index }}</td>
                    <td class="p-4 text-center">
                        <p class="font-semibold text-sm text-gray-800">{{ $p->user?->username ?? '-' }}</p>
                        <p class="text-xs text-gray-400">NIPD: {{ $p->user?->nipd ?? '-' }}</p>
                    </td>
                    <td class="p-4">
                        @php
                            $firstBarang = $p->firstDetail?->barang;
                            $totalItems  = $p->detailPeminjaman->count();
                        @endphp
                        @if($firstBarang)
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 bg-gray-100">
                                    @if($firstBarang->foto && $firstBarang->foto !== 'default.jpg')
                                        <img src="{{ asset('storage/' . $firstBarang->foto) }}" alt="{{ $firstBarang->nama_barang }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-sm text-gray-800">{{ $firstBarang->nama_barang }}</p>
                                    <p class="text-xs text-gray-400">
                                        Jml: {{ $p->firstDetail->jumlah }}
                                        @if($totalItems > 1)
                                            <span class="text-blue-500">+{{ $totalItems - 1 }} lainnya</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <p class="font-semibold text-sm text-gray-800">{{ $p->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</p>
                    </td>
                    <td class="p-4 text-center">
                        <p class="font-semibold text-sm text-gray-800">{{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}</p>
                    </td>
                    <td class="p-4 text-center">
                        <span class="inline-flex px-3 py-1.5 text-xs font-semibold rounded-full border whitespace-nowrap {{ $p->badge_status }}">
                            {{ $p->label_status }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        @if($p->catatan)
                            <span class="text-xs text-gray-500 max-w-[120px] block mx-auto truncate" title="{{ $p->catatan }}">
                                {{ $p->catatan }}
                            </span>
                        @else
                            <span class="text-xs text-gray-300">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($p->is_pending)
                            <div class="flex gap-2 justify-center">
                                <button type="button"
                                    onclick="openModal('approve', {{ $p->id_peminjaman }}, '{{ addslashes($p->user?->username ?? '') }}', '{{ addslashes($p->firstDetail?->barang?->nama_barang ?? 'barang') }}')"
                                    class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200 hover:bg-green-200 transition">
                                    Terima
                                </button>
                                <button type="button"
                                    onclick="openModal('reject', {{ $p->id_peminjaman }}, '{{ addslashes($p->user?->username ?? '') }}', '{{ addslashes($p->firstDetail?->barang?->nama_barang ?? 'barang') }}')"
                                    class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full border border-red-200 hover:bg-red-200 transition">
                                    Tolak
                                </button>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">Sudah diproses</p>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-16 text-center">
                        <p class="text-4xl mb-3">📭</p>
                        <p class="font-semibold text-gray-500 text-sm">
                            Belum ada pengajuan{{ request('search') || request('status') ? ' yang sesuai filter' : ' masuk' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Pengajuan dari peminjam akan muncul di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Custom (sama persis dengan kelola laporan) --}}
    @if($pengajuans->total() > 0)
    <div class="flex flex-col lg:flex-row items-center justify-between gap-5 p-5 bg-white border-t border-gray-100 rounded-3xl shadow-sm">
        <div class="flex flex-wrap items-center gap-3">
            <p class="text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-full">
                Menampilkan {{ $pengajuans->firstItem() }}–{{ $pengajuans->lastItem() }} dari {{ $pengajuans->total() }} pengajuan
            </p>

            @if($pengajuans->onFirstPage())
                <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">← Sebelumnya</span>
            @else
                <a href="{{ $pengajuans->previousPageUrl() }}" class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition shadow-sm">← Sebelumnya</a>
            @endif

            <div class="flex gap-1.5">
                @php
                    $current = $pengajuans->currentPage();
                    $last = $pengajuans->lastPage();
                    $start = max(1, $current - 2);
                    $end = min($last, $current + 2);
                    if ($start > 1) echo '<span class="px-3 py-2 text-gray-400">...</span>';
                    for ($i = $start; $i <= $end; $i++) {
                        $activeClass = ($i == $current) ? 'bg-costume-primary text-white shadow-md' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50';
                        echo '<a href="' . $pengajuans->url($i) . '" class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium transition ' . $activeClass . '">' . $i . '</a>';
                    }
                    if ($end < $last) echo '<span class="px-3 py-2 text-gray-400">...</span>';
                @endphp
            </div>

            @if($pengajuans->hasMorePages())
                <a href="{{ $pengajuans->nextPageUrl() }}" class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200 transition shadow-sm">Selanjutnya →</a>
            @else
                <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">Selanjutnya →</span>
            @endif
        </div>

        <div class="flex items-center gap-2 rounded-full px-4 py-1.5">
            <span class="text-sm text-gray-500">Ke halaman :</span>
            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2" id="jumpToPageForm">
                @foreach(request()->query() as $key => $value)
                    @if($key != 'page')
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <input type="number" name="page" value="{{ $pengajuans->currentPage() }}" min="1" max="{{ $pengajuans->lastPage() }}"
                    class="w-9 px-3 py-1.5 border border-gray-300 rounded-full text-center text-sm focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none">
                <button type="submit" class="px-5 py-1.5 bg-costume-primary text-white text-sm font-medium rounded-full hover:bg-blue-700 transition shadow-md">Pergi</button>
            </form>
            <span class="text-sm text-gray-500">dari {{ $pengajuans->lastPage() }}</span>
        </div>
    </div>
    @endif
</div>

{{-- Modal Konfirmasi Terima / Tolak (gaya rounded-2xl) --}}
<div id="confirmModal"
     class="fixed inset-0 z-50 hidden bg-black/50 items-center justify-center p-4"
     onclick="if(event.target===this) closeModal()">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-center gap-3 mb-5">
            <div id="modalIcon" class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 text-xl"></div>
            <div>
                <h3 id="modalTitle" class="text-lg font-bold text-gray-800"></h3>
                <p id="modalSubtitle" class="text-sm text-gray-500 mt-0.5"></p>
            </div>
        </div>
        <form id="modalForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2 text-sm">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                <textarea name="catatan" rows="3"
                    placeholder="Tambahkan catatan untuk peminjam..."
                    class="w-full px-5 py-3 border-2 border-gray-300 rounded-xl outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm resize-none transition"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()"
                    class="flex-1 px-5 py-3 border-2 border-gray-300 rounded-full text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="modalSubmitBtn"
                    class="flex-1 px-5 py-3 rounded-full text-white text-sm font-semibold transition">
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let searchTimer;
    document.getElementById('searchInput')?.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => document.getElementById('filterForm').submit(), 500);
    });

    function openModal(type, id, nama, barang) {
        const isApprove = type === 'approve';
        const baseUrl   = "{{ url('admin/kelola_pengajuan') }}";
        document.getElementById('modalForm').action = `${baseUrl}/${id}/${type}`;

        const iconEl = document.getElementById('modalIcon');
        iconEl.textContent = isApprove ? '✅' : '❌';
        iconEl.className = `w-12 h-12 rounded-full flex items-center justify-center shrink-0 text-xl ${isApprove ? 'bg-green-100' : 'bg-red-100'}`;

        document.getElementById('modalTitle').textContent    = isApprove ? 'Setujui Pengajuan?' : 'Tolak Pengajuan?';
        document.getElementById('modalSubtitle').textContent = `${nama} — ${barang}`;

        const btn = document.getElementById('modalSubmitBtn');
        btn.textContent = isApprove ? 'Ya, Setujui' : 'Ya, Tolak';
        btn.className = `flex-1 px-5 py-3 rounded-full text-white text-sm font-semibold transition ${isApprove ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'}`;

        document.querySelector('#modalForm textarea[name="catatan"]').value = '';
        const modal = document.getElementById('confirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('confirmModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
</script>
@endpush
