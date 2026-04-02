@extends('layouts.app')

@section('title', 'Pinjaman Aktif - KlikAset')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    *, body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    :root {
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --sidebar-w: 220px;
    }

    /* Sidebar styling */
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
    }

    .nav-link:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(3px);
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        font-weight: 600;
    }

    .loan-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        transition: all 0.2s;
    }

    .loan-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-yellow {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-green {
        background: #d1fae5;
        color: #065f46;
    }
</style>
@endpush

@section('content')
<div id="overlay" onclick="closeSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:40"></div>

<div class="flex min-h-screen bg-slate-100">
    {{-- Sidebar --}}
    <aside id="sidebar" class="flex flex-col py-5 px-3 min-h-screen shrink-0">
        <div class="flex items-center gap-2.5 mb-8 px-2">
            <div class="bg-white rounded-xl w-9 h-9 flex items-center justify-center shadow-lg shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 6a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm0 7a3 3 0 013-3h12a3 3 0 013 3v2a3 3 0 01-3 3H6a3 3 0 01-3-3v-2z"/>
                </svg>
            </div>
            <span class="text-white font-bold text-[17px] tracking-tight">KlikAset</span>
        </div>

        <nav class="flex flex-col gap-1 flex-1">
            <p class="text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 mb-1">Menu</p>

            <a href="{{ route('my.dashboard') }}" class="nav-link">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('loans') }}" class="nav-link active">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pinjaman Aktif
            </a>

            <a href="{{ route('history') }}" class="nav-link">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat
            </a>
        </nav>

        {{-- User Info & Logout --}}
        <div class="mt-auto border-t border-white/10 pt-4 px-1">
            <div class="flex items-center gap-2.5 mb-3 px-2">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm shrink-0">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Mobile Menu Button --}}
        <div class="md:hidden bg-white border-b border-slate-200 px-4 py-3">
            <button onclick="openSidebar()" class="text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Page Content --}}
        <main class="flex-1 p-4 md:p-6 space-y-5">
            <div class="bg-white rounded-2xl p-6 border border-slate-200">
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Pinjaman Aktif</h1>
                <p class="text-sm text-slate-600">Daftar aset yang sedang Anda pinjam</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($activeLoans as $loan)
                    <div class="loan-card">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900 text-base mb-1">
                                    {{ $loan->first_barang->nama_barang ?? 'Aset tidak ditemukan' }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    {{ $loan->first_barang->kategori ?? '-' }}
                                </p>
                            </div>
                            @if($loan->status === 'disetujui')
                                <span class="badge badge-blue">Disetujui</span>
                            @elseif($loan->status === 'dipinjam')
                                <span class="badge badge-yellow">Dipinjam</span>
                            @else
                                <span class="badge badge-green">{{ ucfirst($loan->status) }}</span>
                            @endif
                        </div>

                        <div class="space-y-2 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span>Tanggal Pinjam:</span>
                                <span class="font-semibold">{{ $loan->tanggal_pinjam->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tanggal Kembali:</span>
                                <span class="font-semibold text-orange-600">{{ $loan->tanggal_kembali->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Jumlah:</span>
                                <span class="font-semibold">{{ $loan->detailPeminjaman->first()->jumlah ?? 1 }} unit</span>
                            </div>
                        </div>

                        @if($loan->catatan)
                            <div class="mt-3 pt-3 border-t border-slate-100">
                                <p class="text-xs text-slate-500">
                                    <span class="font-semibold">Catatan:</span> {{ $loan->catatan }}
                                </p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-slate-500 font-medium mb-2">Tidak ada pinjaman aktif</p>
                            <p class="text-sm text-slate-400 mb-4">Anda belum memiliki peminjaman yang sedang berjalan</p>
                            <a href="{{ route('borrow') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition-all">
                                Ajukan Peminjaman
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('overlay').style.display = 'block';
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').style.display = 'none';
    }
</script>
@endpush
@endsection
