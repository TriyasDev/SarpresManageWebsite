@extends('layouts.app')
@section('title', 'Beranda - KlikAset SMK BBC')
@section('content')

    {{-- HERO SECTION --}}
    <section class="relative bg-linear-to-br from-slate-50 to-blue-50/50 py-24 lg:py-32 overflow-hidden" id="beranda">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/assets/universitas0.webp') }}" alt="SMK Budi Bakti"
                class="w-full h-full object-cover opacity-100" style="object-position: center 70%;">
            <div class="absolute inset-0 bg-linear-to-br from-slate-50/90 to-blue-50/80"></div>
        </div>

        {{-- Subtle Background Elements --}}
        <div class="absolute top-20 right-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- Left Content --}}
                <div class="space-y-8 opacity-0 -translate-x-8 animate-[fadeInLeft_0.8s_ease-out_forwards]">
                    {{-- Main Heading --}}
                    <div class="space-y-4">
                        <h1 class="text-4xl lg:text-6xl font-bold text-slate-900 leading-tight">
                            WebsitePeminjaman
                            <span class="block text-costume-primary">
                                KlikAset
                            </span>
                        </h1>
                        <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
                            Platform digital untuk memudahkan peminjaman monitor, laptop, dan aset sekolah lainnya.
                        </p>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap gap-4">
                        <a href="#pinjam"
                            class="group px-8 py-4 bg-costume-primary text-white rounded-xl font-semibold hover:bg-costume-primary/90 transition-all shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 flex items-center gap-2">
                            Ajukan Peminjaman
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                        <a href="#sarana"
                            class="px-8 py-4 bg-white text-slate-700 rounded-xl font-semibold hover:border-costume-primary hover:text-costume-primary">
                            Lihat Katalog
                        </a>
                    </div>

                    {{-- Simple Info --}}
                    <div class="pt-8 space-y-3">
                        <div class="flex items-center gap-3 text-slate-600">
                            <x-icon-check-circle class="w-5 h-5 text-costume-primary shrink-0" />
                            <span class="text-sm">Pengajuan online tanpa antri</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <x-icon-check-circle class="w-5 h-5 text-costume-primary shrink-0" />
                            <span class="text-sm">Tracking status real-time</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-600">
                            <x-icon-check-circle class="w-5 h-5 text-costume-primary shrink-0" />
                            <span class="text-sm">Riwayat peminjaman tersimpan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section class="py-24 bg-white" id="mengapa-kami">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-16 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700"
                data-animate>
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

            {{-- Features Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Feature 1 --}}
                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-costume-primary hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 0ms" data-animate>
                    <div
                        class="w-16 h-16 bg-linear-to-br from-costume-primary to-costume-second rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-blue-500/20">
                        <x-icon-document-add class="w-8 h-8 text-white" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-costume-primary transition-colors">
                        Pengajuan Online
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Ajukan peminjaman langsung dari web tanpa perlu ke ruang admin
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-emerald-500 hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 100ms" data-animate>
                    <div
                        class="w-16 h-16 bg-linear-to-br from-emerald-500 to-emerald-600 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-emerald-500/20">
                        <x-icon-calendar-search class="w-8 h-8 text-white" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-emerald-600 transition-colors">
                        Tracking Status
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Pantau status pengajuan dan peminjaman Anda secara real-time
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-violet-500 hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 200ms" data-animate>
                    <div
                        class="w-16 h-16 bg-linear-to-br from-violet-500 to-violet-600 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-violet-500/20">
                        <x-icon-clock-circle class="w-8 h-8 text-white" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-violet-600 transition-colors">
                        Riwayat Lengkap
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Lihat semua riwayat peminjaman dan pengembalian aset
                    </p>
                </div>

                {{-- Feature 4 --}}
                <div class="group bg-white rounded-2xl border border-slate-200 p-8 text-center hover:border-amber-500 hover:shadow-xl transition-all duration-300 cursor-pointer opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                    style="transition-delay: 300ms" data-animate>
                    <div
                        class="w-16 h-16 bg-linear-to-br from-amber-500 to-amber-600 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 shadow-lg shadow-amber-500/20">
                        <x-icon-crown-line class="w-8 h-8 text-white" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-amber-600 transition-colors">
                        Sistem Poin
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Dapatkan poin dari peminjaman yang tepat waktu
                    </p>
                </div>
            </div>

            {{-- Simple Stats --}}
            <div class="mt-20 pt-12 border-t border-slate-200 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700"
                data-animate>
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

    {{-- ===================================== --}}
    {{-- SARANA/PRASARANA SECTION --}}
    {{-- ===================================== --}}
    <section class="py-24 bg-slate-50" id="sarana">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="text-center mb-16 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700"
                data-animate>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-full mb-4">
                    <span class="text-sm font-semibold text-costume-primary">Katalog</span>
                </div>
                <h2 class="text-3xl lg:text-5xl font-bold text-slate-900 mb-4">
                    Sarana & Prasarana
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Berbagai aset untuk mendukung kegiatan belajar
                </p>
            </div>

            {{-- Category Tabs --}}
            <div class="flex flex-wrap justify-center gap-3 mb-12 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700"
                data-animate>
                <button
                    class="px-6 py-2.5 bg-costume-primary text-white rounded-full font-medium text-sm shadow-md shadow-blue-500/25 hover:shadow-lg transition-all">
                    Semua
                </button>
                <button
                    class="px-6 py-2.5 bg-white text-slate-700 rounded-full font-medium text-sm border border-slate-200 hover:border-costume-primary hover:text-costume-primary transition-all">
                    Elektronik
                </button>
                <button
                    class="px-6 py-2.5 bg-white text-slate-700 rounded-full font-medium text-sm border border-slate-200 hover:border-costume-primary hover:text-costume-primary transition-all">
                    Multimedia
                </button>
                <button
                    class="px-6 py-2.5 bg-white text-slate-700 rounded-full font-medium text-sm border border-slate-200 hover:border-costume-primary hover:text-costume-primary transition-all">
                    Fasilitas
                </button>
                <button
                    class="px-6 py-2.5 bg-white text-slate-700 rounded-full font-medium text-sm border border-slate-200 hover:border-costume-primary hover:text-costume-primary transition-all">
                    Alat Tulis
                </button>
            </div>

            {{-- Assets Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $assets = [
                        ['image' => 'monitor.png', 'title' => 'Monitor Dell 24"', 'category' => 'Elektronik', 'available' => 30, 'condition' => 'Sangat Baik'],
                        ['image' => 'Laptop.png', 'title' => 'Laptop Asus ROG', 'category' => 'Elektronik', 'available' => 20, 'condition' => 'Sangat Baik'],
                        ['image' => 'bbc.jpg', 'title' => 'Proyektor Epson', 'category' => 'Multimedia', 'available' => 15, 'condition' => 'Baik'],
                        ['image' => 'bbc.jpg', 'title' => 'Kamera Canon', 'category' => 'Multimedia', 'available' => 8, 'condition' => 'Sangat Baik'],
                        ['image' => 'bbc.jpg', 'title' => 'Ruang Meeting', 'category' => 'Fasilitas', 'available' => 3, 'condition' => 'Sangat Baik'],
                        ['image' => 'bbc.jpg', 'title' => 'Ruang BK', 'category' => 'Fasilitas', 'available' => 2, 'condition' => 'Baik'],
                        ['image' => 'bbc.jpg', 'title' => 'Papan Tulis', 'category' => 'Alat Tulis', 'available' => 25, 'condition' => 'Baik'],
                        ['image' => 'bbc.jpg', 'title' => 'Aula', 'category' => 'Fasilitas', 'available' => 2, 'condition' => 'Sangat Baik'],
                    ];
                @endphp

                @foreach($assets as $asset)
                    <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-costume-primary hover:shadow-xl transition-all duration-300 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                        data-animate>
                        <div class="relative h-48 bg-linear-to-br from-slate-100 to-slate-200 overflow-hidden">
                            <img src="{{ asset($asset['image']) }}" alt="{{ $asset['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="absolute top-3 right-3 px-3 py-1.5 @if($asset['available'] > 10) bg-emerald-500 @elseif($asset['available'] > 5) bg-amber-500 @else bg-orange-500 @endif text-white text-xs font-bold rounded-full shadow-lg">
                                {{ $asset['available'] }} Tersedia
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-3 py-1 bg-blue-50 text-costume-primary text-xs font-semibold rounded-full">
                                    {{ $asset['category'] }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $asset['title'] }}</h3>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ $asset['condition'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================================== --}}
    {{-- PINJAM SECTION --}}
    {{-- ===================================== --}}
    <section class="py-24 bg-white" id="pinjam">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="text-center mb-16 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700"
                data-animate>
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

            {{-- Popular Items Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @php
                    $popularItems = [
                        ['image' => 'monitor.png', 'title' => 'Monitor Dell 24"', 'category' => 'Elektronik', 'available' => 15, 'rating' => '4.8', 'desc' => 'Monitor Full HD untuk presentasi dan editing', 'maxDays' => 7],
                        ['image' => 'Laptop.png', 'title' => 'Laptop Asus ROG', 'category' => 'Elektronik', 'available' => 8, 'rating' => '4.9', 'desc' => 'Laptop performa tinggi untuk rendering dan coding', 'maxDays' => 5],
                        ['image' => 'bbc.jpg', 'title' => 'Proyektor Epson', 'category' => 'Multimedia', 'available' => 5, 'rating' => '4.7', 'desc' => 'Proyektor HD dengan gambar jernih untuk presentasi', 'maxDays' => 3],
                    ];
                @endphp

                @foreach($popularItems as $item)
                    <div class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-costume-primary hover:shadow-xl hover:-translate-y-1 transition-all duration-300 opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0"
                        data-animate>
                        <div class="relative h-56 bg-linear-to-br from-slate-100 to-slate-200 overflow-hidden">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                            {{-- Availability Badge --}}
                            <div class="absolute top-3 left-3 px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full shadow-lg">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-2 h-2 @if($item['available'] > 10) bg-emerald-500 @else bg-amber-500 @endif rounded-full animate-pulse">
                                    </div>
                                    <span class="text-xs font-bold text-slate-900">{{ $item['available'] }} Tersedia</span>
                                </div>
                            </div>

                            {{-- Rating Badge --}}
                            <div class="absolute top-3 right-3 px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full shadow-lg">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                    <span class="text-xs font-bold text-slate-900">{{ $item['rating'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-4">
                                <span class="px-3 py-1 bg-blue-50 text-costume-primary text-xs font-semibold rounded-full">
                                    {{ $item['category'] }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $item['title'] }}</h3>
                            <p class="text-sm text-slate-600 mb-4">{{ $item['desc'] }}</p>

                            {{-- Features --}}
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Kondisi: Sangat Baik</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <svg class="w-4 h-4 text-costume-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Maksimal: {{ $item['maxDays'] }} hari</span>
                                </div>
                            </div>

                            {{-- Borrow Button --}}
                            <a href="{{ route('auth.login') }}"
                                class="block w-full py-3.5 bg-costume-primary text-white text-center rounded-xl font-semibold hover:bg-costume-primary/90 transition-all shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 group">
                                <span class="flex items-center justify-center gap-2">
                                    Pinjam Sekarang
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- View All Button --}}
            {{-- <div
                class="text-center opacity-0 translate-y-5 [&.visible]:opacity-100 [&.visible]:translate-y-0 transition-all duration-700"
                data-animate>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 px-10 py-4 bg-white text-slate-700 rounded-xl font-semibold border-2 border-slate-200 hover:border-costume-primary hover:text-costume-primary transition-all shadow-sm hover:shadow-lg group">
                    Lihat Semua Aset
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div> --}}
        </div>

        <div class="flex items-center justify-center gap-2">
            <a href="/from"
                class="block w-50 py-3.5 bg-costume-primary text-white text-center rounded-xl font-semibold hover:bg-costume-primary/90 transition-all shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 group">
                <span class="flex items-center justify-center gap-2">
                    Pinjam Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>
            </a>

        </div>
    </section>


@endsection

@push('styles')
    <style>
        /* Custom Tailwind Animations */
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-2rem);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(2rem);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('[data-animate]').forEach(el => {
            observer.observe(el);
        });
    </script>
@endpush