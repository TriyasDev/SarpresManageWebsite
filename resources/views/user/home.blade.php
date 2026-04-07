@extends('layouts.app')
@section('title', 'Beranda - KlikAset SMK BBC')
@section('content')

    {{-- HERO SECTION --}}
    <section class="relative w-full min-h-svh flex items-center justify-center py-24 overflow-hidden" id="beranda">

        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/assets/universitas0.webp') }}" alt="SMK Budi Bakti"
                class="w-full h-full object-cover" style="object-position: center 70%;">
            <div class="absolute inset-0 bg-gradient-to-br from-white/95 via-white/90 to-blue-50/85"></div>
        </div>

        {{-- Decorative Blobs --}}
        <div class="absolute top-20 right-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-20 left-10 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Content --}}
        <div class="relative z-10 w-full max-w-3xl mx-auto px-6 sm:px-8 text-center">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-50 border border-blue-100 rounded-full mb-6">
                <span class="w-2 h-2 rounded-full bg-costume-primary animate-pulse shrink-0"></span>
                <span class="text-xs font-semibold text-costume-primary tracking-wide uppercase">Platform Peminjaman
                    Aset</span>
            </div>

            {{-- Heading --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-4">
                Website Peminjaman
                <span class="block text-costume-primary">KlikAset</span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-8 max-w-xl mx-auto">
                Platform digital untuk memudahkan peminjaman monitor, laptop, dan aset sekolah lainnya.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-10">
                <a href="#pinjam"
                    class="group w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-costume-primary text-white rounded-xl font-semibold text-sm sm:text-base hover:bg-costume-primary/90 transition-all shadow-lg shadow-blue-500/25 hover:shadow-xl active:scale-[0.98]">
                    Ajukan Peminjaman
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform shrink-0" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="#sarana"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-white/80 backdrop-blur-sm text-slate-700 rounded-xl font-semibold text-sm sm:text-base border border-slate-200 hover:border-costume-primary hover:text-costume-primary transition-all shadow-sm active:scale-[0.98]">
                    Lihat Katalog
                </a>
            </div>

            {{-- Feature List --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8">
                <div class="flex items-center gap-2 text-slate-600">
                    <x-icon-check-circle class="w-5 h-5 text-costume-primary shrink-0" />
                    <span class="text-sm">Pengajuan online tanpa antri</span>
                </div>
                <div class="flex items-center gap-2 text-slate-600">
                    <x-icon-check-circle class="w-5 h-5 text-costume-primary shrink-0" />
                    <span class="text-sm">Tracking status real-time</span>
                </div>
                <div class="flex items-center gap-2 text-slate-600">
                    <x-icon-check-circle class="w-5 h-5 text-costume-primary shrink-0" />
                    <span class="text-sm">Riwayat peminjaman tersimpan</span>
                </div>
            </div>

        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section class="py-24 bg-white" id="mengapa-kami">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700" data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-full mb-4">
                    <span class="text-sm font-semibold text-costume-primary">Fitur Utama</span>
                </div>
                <h2 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-4">
                    Cara Kerja <span class="text-costume-primary">KlikAset</span>
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Sistem digital untuk memudahkan peminjaman aset sekolah
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-costume-primary hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 0ms" data-animate>
                    <div class="w-16 h-16 bg-linear-to-br from-costume-primary to-costume-second rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-blue-500/20">
                        <x-icon-document-add class="w-8 h-8 text-white"/>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-costume-primary transition-colors">Pengajuan Online</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Ajukan peminjaman langsung dari web tanpa perlu ke ruang admin</p>
                </div>

                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-emerald-500 hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 100ms" data-animate>
                    <div class="w-16 h-16 bg-linear-to-br from-emerald-500 to-emerald-600 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-emerald-500/20">
                        <x-icon-calendar-search class="w-8 h-8 text-white"/>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-emerald-600 transition-colors">Tracking Status</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Pantau status pengajuan dan peminjaman Anda secara real-time</p>
                </div>

                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-violet-500 hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 200ms" data-animate>
                    <div class="w-16 h-16 bg-linear-to-br from-violet-500 to-violet-600 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-violet-500/20">
                        <x-icon-clock-circle class="w-8 h-8 text-white"/>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-violet-600 transition-colors">Riwayat Lengkap</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Lihat semua riwayat peminjaman dan pengembalian aset</p>
                </div>

                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-amber-500 hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 300ms" data-animate>
                    <div class="w-16 h-16 bg-linear-to-br from-amber-500 to-amber-600 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-amber-500/20">
                        <x-icon-crown-line class="w-8 h-8 text-white"/>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-amber-600 transition-colors">Sistem Poin</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Dapatkan poin dari peminjaman yang tepat waktu</p>
                </div>
            </div>

            <div class="mt-20 pt-12 border-t border-slate-200 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700" data-animate>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-slate-900 mb-1">Digital</div>
                        <div class="text-sm text-slate-600">Proses pengajuan tanpa kertas</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-slate-900 mb-1">Transparan</div>
                        <div class="text-sm text-slate-600">Status dapat dipantau kapan saja</div>
                    </div>
                    <div class="md:col-span-1 col-span-2">
                        <div class="text-3xl font-bold text-slate-900 mb-1">Terorganisir</div>
                        <div class="text-sm text-slate-600">Data tersimpan rapi dan aman</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{-- SARANA/PRASARANA SECTION --}}
<section class="py-24 bg-slate-50" id="sarana">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-16 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700" data-animate>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-full mb-4">
                <span class="text-sm font-semibold text-costume-primary">Katalog</span>
            </div>
            <h2 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-4">Sarana & Prasarana</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Berbagai aset untuk mendukung kegiatan belajar</p>
        </div>

        {{-- Category Tabs (hanya kategori populer) --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700" data-animate>
            @foreach($popularCategories as $kat)
            <button type="button"
                data-kategori="{{ $kat }}"
                class="kategori-tab px-6 py-2.5 rounded-full font-medium text-sm transition-all
                    {{ $activeKategori === $kat ? 'bg-costume-primary text-white shadow-md shadow-blue-500/25' : 'bg-white text-slate-700 border border-slate-200 hover:border-costume-primary hover:text-costume-primary' }}">
                {{ $kat }}
            </button>
            @endforeach
            {{-- Tombol "Lihat Semua" mengarah ke halaman all-assets --}}
            <a href="{{ route('all-assets') }}"
                class="px-6 py-2.5 rounded-full font-medium text-sm bg-white text-costume-primary border border-costume-primary hover:bg-costume-primary hover:text-white transition-all">
                Lihat Semua
            </a>
        </div>

        {{-- Container untuk grid asset dan pagination (diisi via AJAX) --}}
        <div id="sarana-container">
            <div class="flex justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-costume-primary"></div>
            </div>
        </div>

    </div>
</section>

{{-- PINJAM SECTION --}}
<section class="py-24 bg-white" id="pinjam">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700" data-animate>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-full mb-4">
                <span class="text-sm font-semibold text-costume-primary">Mulai Sekarang</span>
            </div>
            <h2 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-4">
                Pinjam <span class="text-costume-primary">Sekarang</span>
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Pilih aset yang Anda butuhkan dan ajukan peminjaman dengan mudah
            </p>
        </div>

        {{-- Grid untuk 9 aset terpopuler (hanya 3 tampil awal) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" id="popularGrid">
            @foreach($popularItems as $index => $item)
                <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-costume-primary hover:shadow-xl hover:-translate-y-1 transition-all duration-300 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                     data-animate data-popular-index="{{ $index }}"
                     @if($index >= 3) style="display: none;" @endif>
                    {{-- Card content (sama seperti sebelumnya) --}}
                    <div class="relative h-56 bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
                        @if($item->foto && $item->foto !== 'default.jpg')
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3 px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full shadow-lg">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 {{ $item->jumlah_tersedia > 5 ? 'bg-emerald-500' : 'bg-amber-500' }} rounded-full animate-pulse"></div>
                                <span class="text-xs font-bold text-slate-900">{{ $item->jumlah_tersedia }} Tersedia</span>
                            </div>
                        </div>
                        <div class="absolute top-3 right-3 px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full shadow-lg">
                            <span class="text-xs font-bold
                                @if($item->kondisi === 'baik') text-emerald-600
                                @elseif($item->kondisi === 'rusak ringan') text-amber-600
                                @else text-red-600 @endif">
                                {{ ucfirst($item->kondisi) }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-costume-primary text-xs font-semibold rounded-full">
                                {{ $item->kategori }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $item->nama_barang }}</h3>
                        <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $item->deskripsi }}</p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Kondisi: {{ ucfirst($item->kondisi) }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-4 h-4 text-costume-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Stok: {{ $item->jumlah_total }} unit ({{ $item->jumlah_tersedia }} tersedia)</span>
                            </div>
                        </div>
                        <a href="{{ route('borrow', ['barang' => $item->id_barang]) }}"
                           class="block w-full py-3.5 bg-costume-primary text-white text-center rounded-xl font-semibold hover:bg-costume-primary/90 transition-all shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 group">
                            <span class="flex items-center justify-center gap-2">
                                Pinjam Sekarang
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Container tombol (akan diisi JavaScript) --}}
        <div class="flex flex-wrap items-center justify-center gap-4" id="buttonContainer"></div>
    </div>
</section>

@endsection

@push('styles')
    <style>
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-2rem); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(2rem); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>
@endpush

@push('scripts')
<script>
    // Intersection Observer untuk animasi scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));

    // Tab filter untuk Sarana (jika ada)
    (function () {
        const tabs = document.querySelectorAll('.tab-btn');
        const cards = document.querySelectorAll('.asset-card');
        const grid = document.getElementById('assets-grid');
        const empty = document.getElementById('empty-state');
        if (tabs.length && cards.length) {
            function filterCards(activeTab) {
                let visible = 0;
                cards.forEach(card => {
                    const match = card.dataset.tab === activeTab;
                    if (match) {
                        card.style.display = '';
                        card.classList.remove('visible');
                        requestAnimationFrame(() => requestAnimationFrame(() => card.classList.add('visible')));
                        visible++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                if (empty) empty.classList.toggle('hidden', visible > 0);
                if (grid) grid.classList.toggle('hidden', visible === 0);
            }
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active', 'bg-costume-primary', 'text-white', 'shadow-md', 'shadow-blue-500/25');
                        t.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
                    });
                    tab.classList.add('active', 'bg-costume-primary', 'text-white', 'shadow-md', 'shadow-blue-500/25');
                    tab.classList.remove('bg-white', 'text-slate-700', 'border', 'border-slate-200');
                    filterCards(tab.dataset.tab);
                });
            });
            const firstTab = tabs[0];
            if (firstTab) filterCards(firstTab.dataset.tab);
        }
    })();

// ========== TOGGLE 3 ⇄ max 9 + TOMBOL LIAT SEMUA ASET ==========
(function() {
    const popularGrid = document.getElementById('popularGrid');
    const btnContainer = document.getElementById('buttonContainer');
    if (!popularGrid || !btnContainer) return;

    const cards = document.querySelectorAll('#popularGrid > div[data-popular-index]');
    const totalCards = cards.length; // jumlah aset yang tersedia (1-9)

    let showingAll = false; // false = hanya 3 pertama, true = semua card

    function updateButtons() {
        // Jika totalCards <= 3, sembunyikan semua tombol
        if (totalCards <= 3) {
            btnContainer.innerHTML = '';
            return;
        }

        if (!showingAll) {
            btnContainer.innerHTML = `
                <button id="btnShowMore" class="inline-flex items-center gap-2 px-8 py-3 bg-costume-primary text-white rounded-xl font-semibold hover:bg-costume-primary/90 transition-all shadow-md shadow-blue-500/25">
                    Lihat Lebih Banyak
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            `;
            document.getElementById('btnShowMore')?.addEventListener('click', () => setShowAll(true));
        } else {
            btnContainer.innerHTML = `
                <button id="btnShowLess" class="inline-flex items-center gap-2 px-8 py-3 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition-all shadow-md">
                    Lihat Lebih Sedikit
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                </button>
                <a href="{{ route('all-assets') }}" id="btnViewAll" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-costume-primary to-blue-600 text-white rounded-xl font-semibold hover:from-costume-primary/90 hover:to-blue-600/90 transition-all shadow-md shadow-blue-500/30 hover:shadow-lg">
                    Lihat Semua Aset
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            `;
            document.getElementById('btnShowLess')?.addEventListener('click', () => setShowAll(false));
        }
    }

    function setShowAll(showAll) {
        showingAll = showAll;
        cards.forEach((card, idx) => {
            if (showAll) {
                // Tampilkan semua card (totalCards)
                if (idx < totalCards) {
                    card.style.display = '';
                    card.classList.remove('visible');
                    setTimeout(() => card.classList.add('visible'), 50);
                } else {
                    card.style.display = 'none';
                }
            } else {
                // Hanya tampilkan 3 pertama
                if (idx < 3) {
                    card.style.display = '';
                    card.classList.remove('visible');
                    setTimeout(() => card.classList.add('visible'), 50);
                } else {
                    card.style.display = 'none';
                }
            }
        });
        updateButtons();
    }

    // Inisialisasi
    if (totalCards <= 3) {
        // Tampilkan semua card tanpa tombol
        cards.forEach((card, idx) => {
            card.style.display = '';
            setTimeout(() => card.classList.add('visible'), 50);
        });
        btnContainer.innerHTML = '';
    } else {
        // Tampilkan hanya 3 pertama
        cards.forEach((card, idx) => {
            if (idx < 3) {
                card.style.display = '';
                setTimeout(() => card.classList.add('visible'), 50);
            } else {
                card.style.display = 'none';
            }
        });
        showingAll = false;
        updateButtons();
    }
})();

// ========== AJAX untuk Sarana & Prasarana (pagination + filter kategori) ==========
(function() {
    const container = document.getElementById('sarana-container');
    const tabs = document.querySelectorAll('.kategori-tab');
    let currentKategori = '{{ $activeKategori }}';
    let currentPage = 1;

    function loadAssets(kategori, page) {
        if (!container) return;
        // Tampilkan loading
        container.innerHTML = '<div class="flex justify-center py-12"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-costume-primary"></div></div>';

        fetch(`{{ url('/assets/json') }}?kategori=${encodeURIComponent(kategori)}&page=${page}`)
            .then(res => res.json())
            .then(data => {
                container.innerHTML = data.html;
                // Re-attach pagination event listeners
                attachPaginationEvents();
                // Trigger animasi fade-in untuk kartu baru
                document.querySelectorAll('#sarana-container [data-animate]').forEach(el => {
                    el.classList.add('visible');
                });
                // Scroll halus ke section sarana (agar tidak loncat ke header)
                const saranaSection = document.getElementById('sarana');
                if (saranaSection) {
                    const offset = 80; // tinggi navbar + sedikit ruang
                    const elementPosition = saranaSection.getBoundingClientRect().top + window.scrollY;
                    window.scrollTo({
                        top: elementPosition - offset,
                        behavior: 'smooth'
                    });
                }
            })
            .catch(err => {
                console.error('Gagal memuat aset:', err);
                container.innerHTML = '<div class="text-center py-12 text-red-500">Gagal memuat data. Silakan refresh halaman.</div>';
            });
    }

    function attachPaginationEvents() {
        const paginationLinks = document.querySelectorAll('#pagination-container a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                if (page) {
                    currentPage = parseInt(page);
                    loadAssets(currentKategori, currentPage);
                }
            });
        });
    }

    // Event listener untuk tab kategori
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const kategori = this.getAttribute('data-kategori');
            if (kategori === currentKategori) return;
            currentKategori = kategori;
            currentPage = 1;
            // Update active class pada tabs
            tabs.forEach(t => {
                t.classList.remove('bg-costume-primary', 'text-white', 'shadow-md', 'shadow-blue-500/25');
                t.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            });
            this.classList.remove('bg-white', 'text-slate-700', 'border', 'border-slate-200');
            this.classList.add('bg-costume-primary', 'text-white', 'shadow-md', 'shadow-blue-500/25');
            loadAssets(currentKategori, currentPage);
        });
    });

    // Load pertama kali
    if (container && '{{ $activeKategori }}') {
        loadAssets(currentKategori, 1);
    }
})();
</script>
@endpush
