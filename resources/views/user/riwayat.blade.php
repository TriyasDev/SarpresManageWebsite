@extends('layouts.user')

@section('title', 'Riwayat Peminjaman - KlikAset')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Inter', sans-serif; }
    footer { display: none !important; }
</style>
@endpush

@section('content')
<div class="flex min-h-screen bg-slate-50">
    @include('partials.sidebar-user')

    <div class="flex-1 lg:ml-64">
        <div class="lg:hidden sticky top-0 z-20 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 py-3 flex items-center justify-between">
            <button onclick="openSidebarUser()" class="p-2 rounded-lg hover:bg-slate-100 transition">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <span class="font-bold text-slate-800">Riwayat</span>
            <div class="w-8"></div>
        </div>

        <main class="p-4 md:p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-costume-primary/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-costume-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Total Peminjaman</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $loans->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Total Poin Diperoleh</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($totalPointsEarned ?? 0) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Rata-rata Durasi</p>
                            <p class="text-2xl font-bold text-slate-800">{{ round($avgDuration ?? 0) }} hari</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex flex-wrap justify-between items-center gap-3">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('history') }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200
                        {{ !request('status') ? 'bg-costume-primary text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('history', ['status' => 'disetujui,dipinjam']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200
                        {{ request('status') == 'disetujui,dipinjam' ? 'bg-costume-primary text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Aktif
                    </a>
                    <a href="{{ route('history', ['status' => 'dikembalikan']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200
                        {{ request('status') == 'dikembalikan' ? 'bg-costume-primary text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Selesai
                    </a>
                    <a href="{{ route('history', ['status' => 'ditolak']) }}"
                        class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200
                        {{ request('status') == 'ditolak' ? 'bg-costume-primary text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Ditolak
                    </a>
                </div>
                <form method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari aset..." value="{{ request('search') }}"
                        class="pl-9 pr-3 py-1.5 text-sm rounded-xl border border-slate-200 focus:border-costume-primary focus:ring-1 focus:ring-costume-primary outline-none w-48 md:w-64 transition">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">#</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Aset</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Tanggal Pinjam</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Tanggal Kembali</th>
                                <th class="text-center py-3 px-4 font-semibold text-slate-600">Status</th>
                                <th class="text-center py-3 px-4 font-semibold text-slate-600">Poin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($loans as $loan)
                                @php
                                    $barang = $loan->first_barang;
                                    $statusMap = [
                                        'menunggu'    => ['label' => 'Menunggu', 'class' => 'bg-amber-100 text-amber-800'],
                                        'disetujui'   => ['label' => 'Disetujui', 'class' => 'bg-blue-100 text-blue-800'],
                                        'dipinjam'    => ['label' => 'Dipinjam', 'class' => 'bg-blue-100 text-blue-800'],
                                        'dikembalikan'=> ['label' => 'Dikembalikan', 'class' => 'bg-green-100 text-green-800'],
                                        'ditolak'     => ['label' => 'Ditolak', 'class' => 'bg-red-100 text-red-800'],
                                    ];
                                    $status = $statusMap[$loan->status] ?? ['label' => ucfirst($loan->status), 'class' => 'bg-gray-100 text-gray-800'];
                                    $point = $loan->point_earned ?? 0;
                                @endphp
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 text-slate-400">{{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}</td>
                                    <td class="py-3 px-4 font-medium text-slate-800">{{ $barang->nama_barang ?? 'Aset tidak diketahui' }}</td>
                                    <td class="py-3 px-4 text-slate-600">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-slate-600">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center font-semibold {{ $point >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $point }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Belum ada riwayat peminjaman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($loans->hasPages())
                    <div class="px-4 py-3 border-t border-slate-100">
                        {{ $loans->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
