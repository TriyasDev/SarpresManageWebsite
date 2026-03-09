@extends('layouts.app')

@section('title', 'Peringkat - KlikAset')

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

        /* ===== PODIUM ===== */
        .podium-wrap {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 12px;
            padding: 0 16px 0;
        }

        .podium-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
            max-width: 140px;
        }

        .podium-avatar {
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            position: relative;
            flex-shrink: 0;
        }

        .podium-avatar .crown {
            position: absolute;
            top: -18px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 22px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
            animation: crownFloat 2s ease-in-out infinite;
        }

        @keyframes crownFloat {

            0%,
            100% {
                transform: translateX(-50%) translateY(0);
            }

            50% {
                transform: translateX(-50%) translateY(-4px);
            }
        }

        .podium-block {
            width: 100%;
            border-radius: 14px 14px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.7);
        }

        /* ===== RANK ROW ===== */
        .rank-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 14px;
            transition: all 0.18s;
            position: relative;
            border: 1.5px solid transparent;
        }

        .rank-row:hover {
            background: #f0f6ff;
            border-color: #dbeafe;
            transform: translateX(3px);
        }

        .rank-row.is-me {
            background: linear-gradient(135deg, #eff6ff, #e0f2fe);
            border-color: #93c5fd;
        }

        .rank-row.is-me::before {
            content: 'Kamu';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: #2563eb;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
        }

        .rank-number {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .rank-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            color: #fff;
            flex-shrink: 0;
        }

        .rank-bar-bg {
            flex: 1;
            height: 5px;
            background: #e2e8f0;
            border-radius: 99px;
            overflow: hidden;
            min-width: 40px;
        }

        .rank-bar-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 1s cubic-bezier(.4, 0, .2, 1);
        }

        /* ===== MY RANK CARD ===== */
        .my-rank-card {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 20px;
            padding: 20px 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .my-rank-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .my-rank-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
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

        /* row stagger */
        .rank-row {
            animation: rowIn 0.3s ease both;
        }

        @keyframes rowIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
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

                <a href="{{ route('user.dashboard') }}" class="nav-link">
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

                <a href="{{ route('user.rank') }}" class="nav-link active">
                    <span class="nav-indicator"></span>
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Peringkat
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
                    <button onclick="openSidebar()" class="text-white p-1 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="text-white font-bold text-sm">Peringkat</span>
                </div>
                <a href="{{ route('user.profile') }}"
                    class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </a>
            </header>

            {{-- Desktop Topbar --}}
            <header class="hidden md:flex items-center justify-between bg-white border-b border-slate-100 px-6 py-3.5">
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <a href="{{ route('user.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-700 font-semibold">Peringkat</span>
                </div>
                <a href="{{ route('user.profile') }}"
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </a>
            </header>

            {{-- ===== CONTENT ===== --}}
            <main class="flex-1 p-4 md:p-6 space-y-5 overflow-auto">

                {{-- My Rank Card --}}
                <div class="my-rank-card fade-up delay-1">
                    <div class="relative z-10 flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-extrabold text-xl ring-2 ring-white/30 shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-blue-200 text-xs font-medium">Posisi kamu saat ini</p>
                            <p class="text-white font-extrabold text-lg truncate">{{ auth()->user()->name ?? 'Kamu' }}</p>
                            <div class="flex items-center gap-3 mt-1 flex-wrap">
                                <span class="text-yellow-300 font-bold text-sm">🏅 Rank #1</span>
                                {{-- Ganti dengan data asli nanti: $user->poin --}}
                                <span class="text-blue-200 text-xs">1.200 Poin</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-white/60 text-[10px] font-medium uppercase tracking-wide">Total Pinjaman</p>
                            <p class="text-white font-extrabold text-2xl">50</p>
                            <p class="text-blue-200 text-[10px]">kali pinjam</p>
                        </div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-blue-200">Paragon II → Paragon III</span>
                            <span class="text-white font-semibold">1200 / 1500 Poin</span>
                        </div>
                        <div class="h-2 bg-white/20 rounded-full overflow-hidden">
                            <div class="h-full bg-white rounded-full transition-all duration-1000" id="myRankBar"
                                style="width:0%"></div>
                        </div>
                    </div>
                </div>

                {{-- Podium Top 3 --}}
                <div
                    class="bg-white rounded-2xl shadow-sm border border-slate-100 pt-8 pb-0 fade-up delay-2 overflow-hidden">
                    <p class="text-center text-xs text-gray-400 font-semibold uppercase tracking-widest mb-6">🏆 Top 3
                        Peringkat</p>

                    <div class="podium-wrap">
                        {{-- Rank 2 --}}
                        <div class="podium-item">
                            <div class="podium-avatar w-14 h-14 text-xl"
                                style="background:linear-gradient(135deg,#94a3b8,#cbd5e1);box-shadow:0 4px 16px rgba(148,163,184,0.4)">
                                B
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-gray-800 text-[13px] truncate max-w-[100px]">Budi Santoso</p>
                                <p class="text-gray-400 text-[11px]">1.150 Poin</p>
                            </div>
                            <div class="podium-block h-20" style="background:linear-gradient(135deg,#94a3b8,#cbd5e1)">2
                            </div>
                        </div>

                        {{-- Rank 1 --}}
                        <div class="podium-item" style="margin-bottom:-8px">
                            <div class="podium-avatar w-18 h-18 text-2xl relative"
                                style="width:72px;height:72px;background:linear-gradient(135deg,#f59e0b,#fbbf24);box-shadow:0 6px 24px rgba(245,158,11,0.5)">
                                <span class="crown">👑</span>
                                A
                            </div>
                            <div class="text-center">
                                <p class="font-extrabold text-gray-900 text-[13px] truncate max-w-[110px]">Ahmad Rizki</p>
                                <p class="text-amber-500 font-semibold text-[11px]">1.200 Poin</p>
                            </div>
                            <div class="podium-block h-28" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">1
                            </div>
                        </div>

                        {{-- Rank 3 --}}
                        <div class="podium-item">
                            <div class="podium-avatar w-14 h-14 text-xl"
                                style="background:linear-gradient(135deg,#cd7f32,#e8a96e);box-shadow:0 4px 16px rgba(205,127,50,0.4)">
                                C
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-gray-800 text-[13px] truncate max-w-[100px]">Citra Dewi</p>
                                <p class="text-gray-400 text-[11px]">1.100 Poin</p>
                            </div>
                            <div class="podium-block h-14" style="background:linear-gradient(135deg,#cd7f32,#e8a96e)">3
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Full Top 10 List --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden fade-up delay-3">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-gray-800 text-sm">Papan Peringkat</p>
                            <p class="text-xs text-gray-400 mt-0.5">Top 10 pengguna terbaik</p>
                        </div>
                        <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-3 py-1.5 rounded-xl">Periode: Maret
                            2026</span>
                    </div>

                    <div class="p-4 space-y-2" id="rankList">
                        {{--
                        Ganti data dummy di bawah dengan data asli dari controller:
                        @foreach($topUsers as $i => $u)
                        ... gunakan $u->name, $u->poin, $u->total_pinjaman
                        @endforeach
                        --}}
                    </div>
                </div>

            </main>
        </div>
    </div>

    @push('scripts')

    @endpush
@endsection