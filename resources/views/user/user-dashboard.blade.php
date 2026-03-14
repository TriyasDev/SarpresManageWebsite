@extends('layouts.app')

@section('title', 'Dashboard - KlikAset')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        *,
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        :root {
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --blue-light: #dbeafe;
            --gold: #f59e0b;
            --green: #10b981;
            --sidebar-w: 220px;
        }

        /* ===== SCROLLBAR ===== */
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

        /* ===== SIDEBAR ===== */
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

        /* ===== NAV LINKS ===== */
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

        /* ===== STAT CARD ===== */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px;
            border: 1px solid #f1f5f9;
            transition: all 0.22s cubic-bezier(.4, 0, .2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--blue-light);
            opacity: 0.4;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.1);
        }

        .stat-card:hover::after {
            transform: scale(1.5);
        }

        /* ===== MINI CARD ===== */
        .mini-card {
            background: #fff;
            border-radius: 14px;
            padding: 16px;
            border: 1px solid #f1f5f9;
            transition: all 0.22s;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mini-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        /* ===== ICON BOX ===== */
        .icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ===== BTN ===== */
        .btn-primary {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.18s;
            font-family: inherit;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
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

        /* ===== RANK CARD ===== */
        .rank-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 16px;
            padding: 22px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .rank-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .rank-card::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: 30px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        /* ===== PROGRESS BAR ===== */
        .progress-bar-bg {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 99px;
            height: 6px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: #fff;
            border-radius: 99px;
            transition: width 1.2s cubic-bezier(.4, 0, .2, 1);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        /* ===== LEADERBOARD ITEM ===== */
        .lb-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 0;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.12s;
            border-radius: 8px;
            padding: 7px 8px;
        }

        .lb-item:last-child {
            border-bottom: none;
        }

        .lb-item:hover {
            background: #f8faff;
        }

        /* ===== AVATAR ===== */
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            flex-shrink: 0;
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

        /* ===== PAGE LOAD ANIMATION ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(16px);
            animation: fadeUp 0.45s ease forwards;
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

        .delay-4 {
            animation-delay: 0.2s;
        }

        .delay-5 {
            animation-delay: 0.25s;
        }

        /* ===== COUNT UP ===== */
        .counter {
            display: inline-block;
        }

        /* ===== TOOLTIP ===== */
        [data-tip] {
            position: relative;
        }

        [data-tip]::after {
            content: attr(data-tip);
            position: absolute;
            bottom: 110%;
            left: 50%;
            transform: translateX(-50%);
            background: #1e293b;
            color: #fff;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
        }

        [data-tip]:hover::after {
            opacity: 1;
        }

        /* ===== NOTIFICATION DOT ===== */
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

        /* ===== TOPBAR ===== */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Coin shimmer */
        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .shimmer-gold {
            background: linear-gradient(90deg, #f59e0b 0%, #fcd34d 40%, #f59e0b 60%, #d97706 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 2.5s linear infinite;
        }
    </style>
@endpush

@section('content')
    <div id="overlay" onclick="closeSidebar()"></div>

    <div class="flex min-h-screen bg-slate-100">

        {{-- ===== SIDEBAR ===== --}}
        <aside id="sidebar" class="flex flex-col py-5 px-3 min-h-screen shrink-0">

            {{-- Logo --}}
            <div class="flex items-center gap-2.5 mb-8 px-2">
                <div class="bg-white rounded-xl w-9 h-9 flex items-center justify-center shadow-lg shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 6a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm0 7a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3v-2z" />
                    </svg>
                </div>
                <span class="text-white font-bold text-[17px] tracking-tight">KlikAset</span>
            </div>

            {{-- Nav --}}
            <nav class="flex flex-col gap-1 flex-1">
                <p class="text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 mb-1">Menu</p>

                <a href="{{ route('user.dashboard') }}" class="nav-link active">
                    <span class="nav-indicator"></span>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('user.riwayat') }}" class="nav-link">
                    <span class="nav-indicator"></span>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat
                </a>

            </nav>

            {{-- User + Logout --}}
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

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- ===== PAGE CONTENT ===== --}}
            <main class="flex-1 p-4 md:p-6 space-y-5 overflow-auto">

                {{-- ROW 1: Stat Cards + Rank --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Total Poin --}}
                    <div class="stat-card fade-up delay-1" data-tip="Akumulasi poin kamu">
                        <div class="flex items-start justify-between mb-3">
                            <div class="icon-box bg-amber-50">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
                            <span class="badge badge-yellow">+120 minggu ini</span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Total Poin</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter shimmer-gold" data-target="1200">0</p>
                        <div class="mt-3 flex items-center gap-2">
                            <div class="flex-1 bg-amber-100 rounded-full h-1.5">
                                <div class="bg-amber-400 h-1.5 rounded-full" style="width:80%" id="pointBar"></div>
                            </div>
                            <span class="text-[10px] text-gray-400">1200/1500</span>
                        </div>
                    </div>

                    {{-- Pinjaman Aktif --}}
                    <div class="stat-card fade-up delay-2">
                        <div class="flex items-start justify-between mb-3">
                            <div class="icon-box bg-blue-50">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="badge badge-blue">Aktif</span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Pinjaman Aktif</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter" data-target="2">0</p>
                        <p class="text-xs text-gray-400 mt-2">Batas pengembalian: <span
                                class="font-semibold text-orange-500">3 hari lagi</span></p>
                    </div>

                    {{-- Rank --}}
                    <div class="rank-card fade-up delay-3">
                        <div class="relative z-10">
                            <p class="text-blue-200 text-xs font-medium mb-1">Rank Saat Ini</p>
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-2xl font-extrabold text-white">Paragon II</p>
                                <div
                                    class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm ring-2 ring-white/30">
                                    <svg class="w-6 h-6 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 3l1.5 4.5L12 5l5.5 2.5L19 3l1 7-4 3 .5 7H7.5L8 13l-4-3 1-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs">
                                    <span class="text-blue-200">Menuju Paragon III</span>
                                    <span class="text-white font-semibold">1200 / 1500</span>
                                </div>
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" id="rankBar" style="width:0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ROW 2: Mini Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Pengingat --}}
                    <div class="mini-card fade-up delay-3">
                        <div class="icon-box bg-yellow-400 relative">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="notif-dot" style="top:-3px;right:-3px"></span>
                        </div>
                        <div>
                            <p class="text-gray-800 font-bold text-[13px]">Pengingat</p>
                            <p class="text-gray-500 text-[11px] mt-0.5">2 tugas menunggu</p>
                            <p class="text-gray-400 text-[10.5px] mt-1 leading-tight">Aula, 24 Feb 2026<br>®
                                Laptop-Asus123fb</p>
                        </div>
                        <button class="btn-primary mt-auto" onclick="openPengingatModal()">Lihat Tugas</button>
                    </div>

                    {{-- Panduan --}}
                    <div class="mini-card fade-up delay-4">
                        <div class="icon-box bg-indigo-500">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 9v4m0 4h.01M12 3C6.477 3 2 7.477 2 12s4.477 9 10 9 10-4.477 10-10S17.523 3 12 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-800 font-bold text-[13px]">Panduan</p>
                            <p class="text-gray-800 font-bold text-[13px]">Peminjaman</p>
                        </div>
                        <button class="btn-primary mt-auto" onclick="openPanduanModal()">Lihat Panduan</button>
                    </div>

                    {{-- Top Peringkat --}}
                    <div class="mini-card fade-up delay-5">
                        <p class="text-gray-800 font-bold text-[13px]">🏆 Top Peringkat</p>
                        <div class="space-y-1">
                            @php
                                $topUsers = [
                                    ['name' => 'Ahmad Rizki', 'poin' => 1200, 'rank' => 1],
                                    ['name' => 'Budi Santoso', 'poin' => 1150, 'rank' => 2],
                                    ['name' => 'Citra Dewi', 'poin' => 1100, 'rank' => 3],
                                ];
                                $medals = ['🥇', '🥈', '🥉'];
                            @endphp
                            @foreach($topUsers as $i => $u)
                                <div class="lb-item">
                                    <span class="text-sm">{{ $medals[$i] }}</span>
                                    <div class="avatar"
                                        style="background: {{ ['linear-gradient(135deg,#3b82f6,#6366f1)', 'linear-gradient(135deg,#10b981,#06b6d4)', 'linear-gradient(135deg,#f59e0b,#ef4444)'][$i] }}">
                                        {{ strtoupper(substr($u['name'], 0, 1)) }}
                                    </div>
                                    <p class="text-[11.5px] font-semibold text-gray-800 flex-1 truncate">{{ $u['name'] }}</p>
                                    <span class="text-[11px] text-gray-500 shrink-0">{{ number_format($u['poin']) }}<sub
                                            class="text-[9px]"> Pn</sub></span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('user.rank') }}"
                            class="text-[11px] text-blue-600 hover:underline font-semibold text-right block mt-1">Lihat
                            Semua →</a>
                    </div>
                </div>

                {{-- ROW 3: Tabel Pinjaman Aktif --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden fade-up delay-5">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Daftar Pinjaman Aktif</p>
                            <p class="text-xs text-gray-400 mt-0.5">Peminjaman yang sedang berjalan</p>
                        </div>
                        <a href="{{ route('user.riwayat') }}"
                            class="text-xs text-blue-600 font-semibold hover:underline flex items-center gap-1">
                            Lihat Semua Riwayat
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    {{-- Desktop Table --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-[12.5px]">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">#</th>
                                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Ruangan / Sarpras</th>
                                    <th class="text-left px-5 py-3 text-gray-500 font-semibold">Tanggal</th>
                                    <th class="text-center px-5 py-3 text-gray-500 font-semibold">Status</th>
                                    <th class="text-center px-5 py-3 text-gray-500 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                {{-- Ganti dengan @forelse($pinjaman as $item) nanti --}}
                                <tr class="tbl-row">
                                    <td class="px-5 py-3 text-gray-400 text-[11px] font-mono">01</td>
                                    <td class="px-5 py-3">
                                        <p class="font-semibold text-gray-800">Aula Pertemuan</p>
                                        <p class="text-gray-400 text-[11px]">Ruangan</p>
                                    </td>
                                    <td class="px-5 py-3 text-gray-600">24 Feb 2026, 14.00 – 16.00</td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="badge badge-blue">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                                            Dipinjam
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <button class="btn-detail"
                                            onclick="openDetailModal('Aula Pertemuan','24 Feb 2026, 14.00–16.00','Dipinjam','Ruangan')">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                                <tr class="tbl-row">
                                    <td class="px-5 py-3 text-gray-400 text-[11px] font-mono">02</td>
                                    <td class="px-5 py-3">
                                        <p class="font-semibold text-gray-800">Laptop-Asus123fb</p>
                                        <p class="text-gray-400 text-[11px]">Perangkat</p>
                                    </td>
                                    <td class="px-5 py-3 text-gray-600">24 Feb 2026, 14.00 – 16.00</td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="badge badge-blue">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                                            Dipinjam
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <button class="btn-detail"
                                            onclick="openDetailModal('Laptop-Asus123fb','24 Feb 2026, 14.00–16.00','Dipinjam','Perangkat')">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                                <tr class="tbl-row">
                                    <td class="px-5 py-3 text-gray-400 text-[11px] font-mono">03</td>
                                    <td class="px-5 py-3">
                                        <p class="font-semibold text-gray-800">Monitor Samsung</p>
                                        <p class="text-gray-400 text-[11px]">Perangkat</p>
                                    </td>
                                    <td class="px-5 py-3 text-gray-600">24 Feb 2026, 14.00 – 16.00</td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="badge badge-yellow">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 inline-block"></span>
                                            Menunggu
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <button class="btn-detail"
                                            onclick="openDetailModal('Monitor Samsung','24 Feb 2026, 14.00–16.00','Menunggu Persetujuan','Perangkat')">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="md:hidden divide-y divide-slate-100">
                        @foreach([['Aula Pertemuan', 'Ruangan', 'Dipinjam', 'badge-blue'], ['Laptop-Asus123fb', 'Perangkat', 'Dipinjam', 'badge-blue'], ['Monitor Samsung', 'Perangkat', 'Menunggu', 'badge-yellow']] as $item)
                            <div class="px-4 py-3">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-[13px]">{{ $item[0] }}</p>
                                        <p class="text-[11px] text-gray-400">{{ $item[1] }} · 24 Feb 2026, 14.00–16.00</p>
                                    </div>
                                    <span class="badge {{ $item[3] }} ml-2 shrink-0">{{ $item[2] }}</span>
                                </div>
                                <button class="btn-detail"
                                    onclick="openDetailModal('{{ $item[0] }}','24 Feb 2026, 14.00–16.00','{{ $item[2] }}','{{ $item[1] }}')">
                                    Lihat Detail
                                </button>
                            </div>
                        @endforeach
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
                    <button onclick="closeModal('detailModal')" class="text-white/70 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-5 space-y-3 text-[13px]" id="detailModalContent"></div>
            <div class="px-5 pb-5">
                <button onclick="closeModal('detailModal')"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition-all text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- ===== MODAL PENGINGAT ===== --}}
    <div id="pengingatModal" class="hidden fixed inset-0 z-60 flex items-center justify-center p-4"
        style="background:rgba(15,23,42,0.5);backdrop-filter:blur(4px)">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm" style="animation:slideUp .25s ease">
            <div class="bg-gradient-to-r from-yellow-500 to-amber-400 px-5 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <p class="text-white font-bold text-sm">Pengingat &amp; Tugas</p>
                    <button onclick="closeModal('pengingatModal')" class="text-white/70 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-5 space-y-3">
                <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-yellow-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[12.5px] font-semibold text-gray-800">Kembalikan Aula Pertemuan</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">24 Februari 2026 · Jam 16.00</p>
                    </div>
                </div>
                <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-yellow-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[12.5px] font-semibold text-gray-800">Kembalikan Laptop-Asus123fb</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">24 Februari 2026 · Jam 16.00</p>
                    </div>
                </div>
            </div>
            <div class="px-5 pb-5">
                <button onclick="closeModal('pengingatModal')"
                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2.5 rounded-xl transition-all text-sm">Mengerti</button>
            </div>
        </div>
    </div>

    {{-- ===== MODAL PANDUAN ===== --}}
    <div id="panduanModal" class="hidden fixed inset-0 z-60 flex items-center justify-center p-4"
        style="background:rgba(15,23,42,0.5);backdrop-filter:blur(4px)">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm" style="animation:slideUp .25s ease">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-5 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <p class="text-white font-bold text-sm">Panduan Peminjaman</p>
                    <button onclick="closeModal('panduanModal')" class="text-white/70 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-5 space-y-2.5 text-[12.5px] text-gray-700">
                @foreach(['Pilih aset yang ingin dipinjam dari katalog', 'Isi form peminjaman dengan lengkap dan benar', 'Tunggu persetujuan dari admin', 'Ambil aset sesuai jadwal yang disetujui', 'Kembalikan aset tepat waktu untuk menjaga poin'] as $i => $step)
                    <div class="flex gap-3 items-start">
                        <div
                            class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-[10px] shrink-0 mt-0.5">
                            {{ $i + 1 }}</div>
                        <p>{{ $step }}</p>
                    </div>
                @endforeach
            </div>
            <div class="px-5 pb-5">
                <button onclick="closeModal('panduanModal')"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl transition-all text-sm">Mengerti</button>
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
        </style>
        <script>
            // Sidebar
            function openSidebar() {
                document.getElementById('sidebar').classList.add('open');
                document.getElementById('overlay').classList.add('show');
            }
            function closeSidebar() {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('overlay').classList.remove('show');
            }

            // Modals
            function openDetailModal(name, date, status, type) {
                const statusColors = {
                    'Dipinjam': 'badge-blue',
                    'Menunggu Persetujuan': 'badge-yellow',
                    'Menunggu': 'badge-yellow',
                    'Dikembalikan': 'badge-green'
                };
                const cls = statusColors[status] || 'badge-blue';
                document.getElementById('detailModalContent').innerHTML = `
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
              <div class="flex justify-between py-2 items-center">
                <span class="text-gray-500">Status</span>
                <span class="badge ${cls}">${status}</span>
              </div>
            `;
                document.getElementById('detailModal').classList.remove('hidden');
            }
            function openPengingatModal() { document.getElementById('pengingatModal').classList.remove('hidden'); }
            function openPanduanModal() { document.getElementById('panduanModal').classList.remove('hidden'); }
            function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

            // Close modal on backdrop click
            ['detailModal', 'pengingatModal', 'panduanModal'].forEach(id => {
                document.getElementById(id).addEventListener('click', function (e) {
                    if (e.target === this) closeModal(id);
                });
            });

            // Counter animation
            function animateCounter(el) {
                const target = parseInt(el.dataset.target);
                const duration = 1200;
                const start = performance.now();
                function update(now) {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(eased * target).toLocaleString('id-ID');
                    if (progress < 1) requestAnimationFrame(update);
                }
                requestAnimationFrame(update);
            }

            // Rank bar animation
            window.addEventListener('load', () => {
                document.querySelectorAll('.counter').forEach(animateCounter);
                setTimeout(() => {
                    document.getElementById('rankBar').style.width = '80%';
                }, 600);
            });
        </script>
    @endpush
@endsection
