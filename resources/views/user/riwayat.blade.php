@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - KlikAset')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --sidebar-w: 220px;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        /* ===== SIDEBAR (same as dashboard) ===== */
        #sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(165deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
            transition: transform 0.3s cubic-bezier(.4, 0, .2, 1);
            box-shadow: 4px 0 24px rgba(37, 99, 235, 0.18);
        }

        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                z-index: 50;
                transform: translateX(-100%);
            }

            #sidebar.open {
                transform: translateX(0);
            }
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 13px;
            border-radius: 10px;
            color: #bfdbfe;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.18s;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.18s;
            border-radius: 10px;
        }

        .nav-link:hover::before {
            opacity: 1;
        }

        .nav-link:hover {
            color: #fff;
            transform: translateX(3px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        }

        .nav-link .nav-indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: #fff;
            border-radius: 0 3px 3px 0;
            transition: height 0.2s;
        }

        .nav-link.active .nav-indicator {
            height: 60%;
        }

        /* ===== FILTER TABS ===== */
        .filter-tab {
            padding: 6px 16px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s;
            border: 1.5px solid transparent;
            white-space: nowrap;
        }

        .filter-tab.active {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .filter-tab:not(.active) {
            background: #fff;
            color: #6b7280;
            border-color: #e5e7eb;
        }

        .filter-tab:not(.active):hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 99px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-green {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-yellow {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ===== TABLE ===== */
        .tbl-row {
            transition: background 0.12s;
        }

        .tbl-row:hover {
            background: #f8faff;
            cursor: pointer;
        }

        .btn-detail {
            border: 1.5px solid #e2e8f0;
            background: #fff;
            color: #374151;
            border-radius: 7px;
            padding: 5px 14px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }

        .btn-detail:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: #eff6ff;
        }

        /* ===== PAGINATION ===== */
        .pg-btn {
            min-width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
            font-family: inherit;
        }

        .pg-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .pg-btn.active {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        .pg-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ===== SEARCH ===== */
        .search-input {
            background: #f8faff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 8px 12px 8px 36px;
            font-size: 12.5px;
            color: #374151;
            transition: all 0.18s;
            font-family: inherit;
            width: 200px;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            width: 260px;
        }

        /* ===== OVERLAY ===== */
        #overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            z-index: 40;
            backdrop-filter: blur(2px);
        }

        #overlay.show {
            display: block;
        }

        /* ===== MODAL ===== */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ===== STAT PILLS ===== */
        .stat-pill {
            background: #fff;
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }

        .stat-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        /* ===== NOTIF DOT ===== */
        .notif-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: -2px;
            right: -2px;
            box-shadow: 0 0 0 2px #fff;
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(239, 68, 68, 0);
            }

            50% {
                box-shadow: 0 0 0 2px #fff, 0 0 0 5px rgba(239, 68, 68, 0.3);
            }
        }

        /* ===== FADE UP ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(14px);
            animation: fadeUp 0.4s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 {
            animation-delay: 0.05s;
        }

        .delay-2 {
            animation-delay: 0.1s;
        }

        .delay-3 {
            animation-delay: 0.15s;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            padding: 48px 24px;
            text-align: center;
        }

        /* ===== ROW ANIM ===== */
        .tbl-row {
            animation: rowIn 0.25s ease both;
        }

        @keyframes rowIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div id="overlay" onclick="closeSidebar()"></div>

    <div class="flex min-h-screen bg-slate-100">

        {{-- ===== SIDEBAR ===== --}}
        <aside id="sidebar" class="flex flex-col py-5 px-3 min-h-screen shrink-0">
            <div class="flex items-center gap-2.5 mb-8 px-2">
                <div class="bg-white rounded-xl w-9 h-9 flex items-center justify-center shadow-lg shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 6a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm0 7a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3v-2z" />
                    </svg>
                </div>
                <span class="text-white font-bold text-[17px] tracking-tight">KlikAset</span>
            </div>

            <nav class="flex flex-col gap-1 flex-1">
                <p class="text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 mb-1">Menu</p>

                <a href="{{route('dashboard') }}" class="nav-link">
                    <span class="nav-indicator"></span>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('account.history') }}" class="nav-link active">
                    <span class="nav-indicator"></span>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat
                </a>
            </nav>

            <div class="mt-auto border-t border-white/10 pt-4 px-1">
                <div class="flex items-center gap-2.5 mb-3 px-2">
                    <div
                        class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm shrink-0 ring-2 ring-white/30">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-white font-semibold text-[12px] truncate">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-blue-200 text-[10.5px] truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-full text-left">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===== MAIN ===== --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Mobile Topbar --}}
            <header class="md:hidden bg-blue-600 flex items-center justify-between px-4 py-3 sticky top-0 z-30 shadow-lg">
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()" class="text-white p-1 rounded-lg hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-white font-bold text-sm">Riwayat</span>
                </div>
                <div class="relative">
                    <button class="text-white p-1 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <span class="notif-dot"></span>
                </div>
            </header>

            {{-- Desktop Topbar --}}
            <header class="hidden md:flex items-center justify-between bg-white border-b border-slate-100 px-6 py-3.5">
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <a href="{{route('dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-700 font-semibold">Riwayat Peminjaman</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <button
                            class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                        <span class="notif-dot"></span>
                    </div>
                </div>
            </header>

            {{-- ===== CONTENT ===== --}}
            <main class="flex-1 p-4 md:p-6 space-y-4 overflow-auto">

                {{-- Stat pills --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 fade-up delay-1">
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden fade-up delay-2">
    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-slate-100">
        <div>
            <p class="font-bold text-gray-800 text-sm">Riwayat Peminjaman</p>
            <p class="text-xs text-gray-400 mt-0.5" id="tableSubtitle">Menampilkan semua riwayat</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <div class="flex items-center gap-1.5 bg-slate-100 rounded-xl p-1">
                <a href="{{ route('account.history', ['status' => '']) }}" class="filter-tab {{ request('status') == '' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('account.history', ['status' => 'dipinjam,disetujui']) }}" class="filter-tab {{ request('status') == 'dipinjam,disetujui' ? 'active' : '' }}">Dipinjam</a>
                <a href="{{ route('account.history', ['status' => 'dikembalikan']) }}" class="filter-tab {{ request('status') == 'dikembalikan' ? 'active' : '' }}">Dikembalikan</a>
            </div>
            <div class="relative">
                <svg class="w-3.5 h-3.5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <form method="GET" action="{{ route('account.history') }}">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aset..." class="search-input">
                </form>
            </div>
        </div>
    </div>
                </div>

                {{-- Table Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden fade-up delay-2">

                    {{-- Toolbar --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-slate-100">
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Riwayat Peminjaman</p>
                            <p class="text-xs text-gray-400 mt-0.5" id="tableSubtitle">Menampilkan semua riwayat</p>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            {{-- Filter Tabs --}}
                            <div class="flex items-center gap-1.5 bg-slate-100 rounded-xl p-1">
                                <button class="filter-tab active" onclick="filterData('semua',this)">Semua</button>
                                <button class="filter-tab" onclick="filterData('Dipinjam',this)">Dipinjam</button>
                                <button class="filter-tab" onclick="filterData('Dikembalikan',this)">Dikembalikan</button>
                            </div>
                            {{-- Search --}}
                            <div class="relative">
                                <svg class="w-3.5 h-3.5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" id="searchInput" placeholder="Cari aset..." class="search-input"
                                    oninput="handleSearch(this.value)">
                            </div>
                        </div>
                    </div>

                    {{-- Desktop Table --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-[12.5px]">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold w-10">#</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Ruangan / Sarpras</th>
                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Tanggal</th>
                    <th class="text-center px-5 py-3 text-gray-500 font-semibold">Status</th>
                    <th class="text-center px-5 py-3 text-gray-500 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody id="desktopBody" class="divide-y divide-slate-50">
@forelse($loans as $index => $loan)
    @php
        $barang = $loan->first_barang;
        $statusLabel = match($loan->status) {
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'dipinjam' => 'Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'ditolak' => 'Ditolak',
            default => ucfirst($loan->status)
        };
        $badgeClass = match($loan->status) {
            'menunggu' => 'badge-yellow',
            'disetujui' => 'badge-blue',
            'dipinjam' => 'badge-blue',
            'dikembalikan' => 'badge-green',
            'ditolak' => 'badge-red',
            default => 'badge-gray'
        };
    @endphp
    <tr class="tbl-row">
        <td class="px-5 py-3 text-gray-400 text-[11px] font-mono">{{ $loans->firstItem() + $index }}</td>
        <td class="px-5 py-3">
            <p class="font-semibold text-gray-800">{{ $barang ? $barang->nama_barang : '-' }}</p>
            <p class="text-gray-400 text-[11px]">{{ $barang ? $barang->kategori : '-' }}</p>
        </td>
        <td class="px-5 py-3 text-gray-600">
            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}<br>
            <span class="text-[10px] text-gray-400">s/d {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</span>
        </td>
        <td class="px-5 py-3 text-center">
            <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
        </td>
        <td class="px-5 py-3 text-center">
            <button class="btn-detail" onclick="openDetailModalFromData('{{ addslashes($barang ? $barang->nama_barang : '-') }}','{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}','{{ $statusLabel }}','{{ $barang ? $barang->kategori : '-' }}','{{ addslashes($loan->catatan) }}','{{ $loan->point_earned }}','{{ $loan->is_late ? 'Terlambat' : 'Tepat Waktu' }}')">
                Lihat Detail
            </button>
        </td>
    </tr>
@endforelse
            </tbody>
        </table>
    </div>

                    {{-- Mobile Cards --}}
    <div class="md:hidden divide-y divide-slate-100" id="mobileCards">
        @forelse($loans as $loan)
            @php
                $detail = $loan->detailPeminjaman->first();
                $barang = $detail ? $detail->barang : null;
                $statusLabel = match($loan->status) {
                    'menunggu' => 'Menunggu',
                    'disetujui' => 'Disetujui',
                    'dipinjam' => 'Dipinjam',
                    'dikembalikan' => 'Dikembalikan',
                    'ditolak' => 'Ditolak',
                    default => ucfirst($loan->status)
                };
                $badgeClass = match($loan->status) {
                    'menunggu' => 'badge-yellow',
                    'disetujui' => 'badge-blue',
                    'dipinjam' => 'badge-blue',
                    'dikembalikan' => 'badge-green',
                    'ditolak' => 'badge-red',
                    default => 'badge-gray'
                };
            @endphp
            <div class="px-4 py-3" onclick="openDetailModalFromData('{{ addslashes($barang->nama_barang ?? '-') }}','{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}','{{ $statusLabel }}','{{ $barang->kategori ?? '-' }}','{{ addslashes($loan->catatan) }}','{{ $loan->point_earned }}','{{ $loan->is_late ? 'Terlambat' : 'Tepat Waktu' }}')">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-semibold text-gray-800 text-[13px]">{{ $barang->nama_barang ?? '-' }}</p>
                        <p class="text-[11px] text-gray-400">{{ $barang->kategori ?? '-' }} · {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</p>
                    </div>
                    <span class="badge {{ $badgeClass }} ml-2 shrink-0">{{ $statusLabel }}</span>
                </div>
                <button class="btn-detail mt-2" onclick="event.stopPropagation(); openDetailModalFromData('{{ addslashes($barang->nama_barang ?? '-') }}','{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }} - {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}','{{ $statusLabel }}','{{ $barang->kategori ?? '-' }}','{{ addslashes($loan->catatan) }}','{{ $loan->point_earned }}','{{ $loan->is_late ? 'Terlambat' : 'Tepat Waktu' }}')">
                    Lihat Detail
                </button>
            </div>
        @empty
            <div class="px-4 py-6 text-center text-gray-400">Belum ada riwayat peminjaman</div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
        <p class="text-[11.5px] text-gray-500">Menampilkan {{ $loans->firstItem() ?? 0 }} - {{ $loans->lastItem() ?? 0 }} dari {{ $loans->total() }} data</p>
        <div class="flex items-center gap-1.5">
            {{ $loans->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>

                    {{-- Empty State --}}
                    <div id="emptyState" class="hidden empty-state">
                        <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-gray-400 font-semibold text-sm">Tidak ada data ditemukan</p>
                        <p class="text-gray-300 text-xs mt-1">Coba ubah filter atau kata pencarian</p>
                    </div>

                    {{-- Bottom Bar --}}
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 px-5 py-3.5 border-t border-slate-100 bg-slate-50/50">
                        <p class="text-[11.5px] text-gray-500" id="infoText"></p>
                        <div class="flex items-center gap-1.5" id="pagination"></div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    {{-- ===== MODAL DETAIL ===== --}}
    <div id="detailModal" class="hidden fixed inset-0 z-60 flex items-center justify-center p-4"
        style="background:rgba(15,23,42,0.5);backdrop-filter:blur(4px)">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" style="animation:slideUp .25s ease">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-4">
                <div class="flex items-center justify-between">
                    <p class="text-white font-bold text-sm">Detail Peminjaman</p>
                    <button onclick="closeModal()" class="text-white/70 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-5 space-y-3 text-[13px]" id="modalContent"></div>
            <div class="px-5 pb-5 flex gap-2">
                <button onclick="closeModal()"
                    class="flex-1 bg-slate-100 hover:bg-slate-200 text-gray-700 font-bold py-2.5 rounded-xl transition-all text-sm">Tutup</button>
                <button
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition-all text-sm">Pinjam
                    Lagi</button>
            </div>
        </div>
    </div>

@push('scripts')
        <style>
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(0.97);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
    function openDetailModalFromData(name, date, status, type, note, point, timeliness) {
    const statusColors = {
        'Dipinjam': 'badge-blue',
        'Disetujui': 'badge-blue',
        'Menunggu': 'badge-yellow',
        'Dikembalikan': 'badge-green',
        'Ditolak': 'badge-red'
    };
    const cls = statusColors[status] || 'badge-blue';
    document.getElementById('modalContent').innerHTML = `
        <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-gray-500">Nama Aset</span>
            <span class="font-bold text-gray-800">${name}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-gray-500">Jenis</span>
            <span class="font-semibold text-gray-700">${type}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-gray-500">Tanggal</span>
            <span class="font-semibold text-gray-700 text-right max-w-[55%]">${date}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-gray-500">Status</span>
            <span class="badge ${cls}">${status}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-gray-500">Catatan</span>
            <span class="font-semibold text-gray-700">${note || '-'}</span>
        </div>
        <div class="flex justify-between py-2 border-b border-slate-100">
            <span class="text-gray-500">Poin Didapat</span>
            <span class="font-semibold text-gray-700">${point || 0}</span>
        </div>
        <div class="flex justify-between py-2">
            <span class="text-gray-500">Ketepatan</span>
            <span class="font-semibold text-gray-700">${timeliness}</span>
        </div>
    `;
    document.getElementById('detailModal').classList.remove('hidden');
}
</style>
@endpush
@endsection
