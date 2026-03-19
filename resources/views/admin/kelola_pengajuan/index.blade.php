@extends('layouts.admin')
@section('title', 'Kelola Pengajuan - KlikAset')

@section('content')

    {{-- Alert --}}
    @if(session('success'))
        <div id="flashSuccess"
             class="mb-5 px-5 py-3 bg-green-100 text-green-700 border border-green-200 rounded-[30px] text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashSuccess').remove()" class="ml-4 text-green-500 hover:text-green-700 text-lg leading-none">✕</button>
        </div>
    @endif

    {{-- ===== Statistik + Search ===== --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

            {{-- Disetujui Bulan Ini --}}
            <div class="bg-white rounded-[20px] border-2 border-gray-100 p-4 lg:p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 lg:w-14 lg:h-14 bg-blue-100 rounded-[16px] flex items-center justify-center shrink-0">
                    <x-icon-checklist-minimalistic class="w-7 h-7 lg:w-8 lg:h-8 text-blue-500"/>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium leading-tight">Total Disetujui<br>Bulan Ini</p>
                    <p class="text-3xl lg:text-4xl font-bold text-gray-900 mt-0.5">{{ $statDisetujui }}</p>
                </div>
            </div>

            {{-- Ditolak Bulan Ini --}}
            <div class="bg-white rounded-[20px] border-2 border-gray-100 p-4 lg:p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 lg:w-14 lg:h-14 bg-red-100 rounded-[16px] flex items-center justify-center shrink-0">
                    <x-icon-forbidden-circle class="w-7 h-7 lg:w-8 lg:h-8 text-red-500"/>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium leading-tight">Total Ditolak<br>Bulan Ini</p>
                    <p class="text-3xl lg:text-4xl font-bold text-gray-900 mt-0.5">{{ $statDitolak }}</p>
                </div>
            </div>

            {{-- Menunggu --}}
            <div class="bg-white rounded-[20px] border-2 border-gray-100 p-4 lg:p-5 flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 lg:w-14 lg:h-14 bg-yellow-100 rounded-[16px] flex items-center justify-center shrink-0">
                    <x-icon-hourglass class="w-7 h-7 lg:w-8 lg:h-8 text-yellow-400"/>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium leading-tight">Menunggu<br>Persetujuan</p>
                    <p class="text-3xl lg:text-4xl font-bold text-gray-900 mt-0.5">{{ $statMenunggu }}</p>
                </div>
            </div>

        </div>

        {{-- Search + Filter --}}
        <form method="GET" action="{{ route('approvals.index') }}" id="filterForm">
            <div class="flex flex-col lg:flex-row gap-4">

                {{-- Search --}}
                <div class="flex-1 relative">
                    <input type="text" name="search" id="searchInput"
                        value="{{ request('search') }}"
                        placeholder="Cari nama peminjam, NIPD, atau barang..."
                        class="w-full bg-white border-2 border-gray-200 rounded-[30px] px-5 py-3 pr-12 outline-none focus:border-costume-second focus:ring-2 focus:ring-blue-100 text-sm transition"/>
                    <x-icon-magnifer class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"/>
                </div>

                {{-- Filter Status --}}
                <div class="lg:w-52">
                    <div class="relative">
                        <select name="status"
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-5 py-3 border-2 border-gray-200 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second appearance-none bg-white cursor-pointer text-sm transition">
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

                <div class="lg:w-auto">
                    <button type="submit"
                        class="w-full px-5 py-3 border-2 border-gray-200 rounded-[30px] bg-white text-sm font-medium hover:bg-gray-50 transition flex items-center justify-center gap-2">
                        <x-icon-filter class="w-4 h-4"/>
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== Tabel Pengajuan ===== --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[820px]">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80">
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">No</th>
                        <th class="p-4 text-left font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">Nama Peminjam</th>
                        <th class="p-4 text-left font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">Barang</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">Tgl Pinjam</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">Tgl Kembali</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">Status</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">Catatan</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-600 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $index => $p)
                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">

                        {{-- No --}}
                        <td class="p-4 text-center text-sm text-gray-500">
                            {{ $pengajuans->firstItem() + $index }}
                        </td>

                        {{-- Nama Peminjam --}}
                        <td class="p-4">
                            <p class="font-semibold text-sm text-gray-800">{{ $p->user?->username ?? '-' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">NIPD: {{ $p->user?->nipd ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $p->user?->no_telpon ?? '' }}</p>
                        </td>

                        {{-- Barang (dari detail_peminjaman) --}}
                        <td class="p-4">
                            @php
                                $firstBarang = $p->firstDetail?->barang;
                                $totalItems  = $p->details_count ?? 0;
                            @endphp
                            @if($firstBarang)
                                <div class="flex items-center gap-2.5">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                                        @if($firstBarang->foto && $firstBarang->foto !== 'default.jpg')
                                            <img src="{{ asset('storage/' . $firstBarang->foto) }}"
                                                 alt="{{ $firstBarang->nama_barang }}"
                                                 class="w-full h-full object-cover"/>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm text-gray-800">{{ $firstBarang->nama_barang }}</p>
                                        <p class="text-xs text-gray-400">
                                            Jml: {{ $p->firstDetail->jumlah }}
                                            @if($p->details->count() > 1)
                                                <span class="text-blue-500">+{{ $p->details->count() - 1 }} lainnya</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>

                        {{-- Tgl Pinjam --}}
                        <td class="p-4 text-center">
                            <p class="font-semibold text-sm text-gray-800 whitespace-nowrap">
                                {{ $p->tanggal_pinjam?->format('d/m/Y') ?? '-' }}
                            </p>
                        </td>

                        {{-- Tgl Kembali --}}
                        <td class="p-4 text-center">
                            <p class="font-semibold text-sm text-gray-800 whitespace-nowrap">
                                {{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-[30px] border whitespace-nowrap {{ $p->badge_status }}">
                                {{ $p->icon_status }} {{ $p->label_status }}
                            </span>
                        </td>

                        {{-- Catatan --}}
                        <td class="p-4 text-center">
                            @if($p->catatan)
                                <span class="text-xs text-gray-500 max-w-[120px] block mx-auto truncate" title="{{ $p->catatan }}">
                                    {{ $p->catatan }}
                                </span>
                            @else
                                <span class="text-xs text-gray-300">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="p-4">
                            @if($p->is_pending)
                                <div class="flex gap-2 justify-center">
                                    <button type="button"
                                        onclick="openModal('approve', {{ $p->id_peminjaman }}, '{{ addslashes($p->user?->username ?? '') }}', '{{ addslashes($p->firstDetail?->barang?->nama_barang ?? 'barang') }}')"
                                        class="px-4 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-[30px] border border-green-200 hover:bg-green-200 transition whitespace-nowrap">
                                        Terima
                                    </button>
                                    <button type="button"
                                        onclick="openModal('reject', {{ $p->id_peminjaman }}, '{{ addslashes($p->user?->username ?? '') }}', '{{ addslashes($p->firstDetail?->barang?->nama_barang ?? 'barang') }}')"
                                        class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 hover:bg-red-200 transition whitespace-nowrap">
                                        Tolak
                                    </button>
                                </div>
                            @else
                                <p class="text-xs text-gray-400 text-center italic whitespace-nowrap">Sudah diproses</p>
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

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 lg:p-5 border-t border-gray-100 gap-3">
            <p class="text-xs lg:text-sm text-gray-500">
                Menampilkan
                <strong class="text-gray-800">{{ $pengajuans->firstItem() ?? 0 }}–{{ $pengajuans->lastItem() ?? 0 }}</strong>
                dari <strong class="text-gray-800">{{ $pengajuans->total() }}</strong> pengajuan
            </p>
            <div class="flex items-center gap-2 flex-wrap justify-center">
                {{ $pengajuans->links() }}
            </div>
        </div>
    </div>

    {{-- ===== Modal Konfirmasi Terima / Tolak ===== --}}
    <div id="confirmModal"
         class="fixed inset-0 z-50 hidden bg-black/50 items-center justify-center p-4"
         onclick="if(event.target===this) closeModal()">
        <div class="bg-white rounded-[30px] shadow-2xl w-full max-w-md p-8">

            <div class="flex items-center gap-3 mb-5">
                <div id="modalIcon" class="w-12 h-12 rounded-[14px] flex items-center justify-center shrink-0 text-xl"></div>
                <div>
                    <h3 id="modalTitle" class="text-base font-bold text-gray-800"></h3>
                    <p id="modalSubtitle" class="text-xs text-gray-500 mt-0.5"></p>
                </div>
            </div>

            <form id="modalForm" method="POST">
                @csrf
                @method('PUT')

                {{-- Catatan Admin (field name: catatan) --}}
                <div class="mb-5">
                    <label class="block text-gray-700 font-medium mb-2 text-sm">
                        Catatan <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea name="catatan" rows="3"
                        placeholder="Tambahkan catatan untuk peminjam..."
                        class="w-full px-5 py-3 border-2 border-gray-300 rounded-[20px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm resize-none transition"></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeModal()"
                        class="flex-1 px-5 py-3 border-2 border-gray-300 rounded-[30px] text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="modalSubmitBtn"
                        class="flex-1 px-5 py-3 rounded-[30px] text-white text-sm font-semibold transition">
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Live Search (debounce 500ms)
    let searchTimer;
    document.getElementById('searchInput')?.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => document.getElementById('filterForm').submit(), 500);
    });

    // Modal
    function openModal(type, id, nama, barang) {
        const isApprove = type === 'approve';
        const baseUrl   = "{{ url('admin/kelola_pengajuan') }}";

        document.getElementById('modalForm').action = `${baseUrl}/${id}/${type}`;

        const iconEl = document.getElementById('modalIcon');
        iconEl.textContent = isApprove ? '✅' : '❌';
        iconEl.className = `w-12 h-12 rounded-[14px] flex items-center justify-center shrink-0 text-xl ${isApprove ? 'bg-green-100' : 'bg-red-100'}`;

        document.getElementById('modalTitle').textContent    = isApprove ? 'Setujui Pengajuan?' : 'Tolak Pengajuan?';
        document.getElementById('modalSubtitle').textContent = `${nama} — ${barang}`;

        const btn = document.getElementById('modalSubmitBtn');
        btn.textContent = isApprove ? 'Ya, Setujui' : 'Ya, Tolak';
        btn.className = `flex-1 px-5 py-3 rounded-[30px] text-white text-sm font-semibold transition ${isApprove ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'}`;

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
