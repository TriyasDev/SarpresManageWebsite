@extends('layouts.app')

@section('title', 'Peringkat - KlikAset')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    footer { display: none !important; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 py-6 px-4 md:px-8">
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Header --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <h1 class="text-2xl font-bold text-slate-800">🏆 Peringkat Peminjam</h1>
            <p class="text-slate-500 text-sm mt-1">Persaingan sehat, raih poin terbanyak!</p>
        </div>

        {{-- Statistik Pribadi (hanya jika user login) --}}
        @auth
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-5 text-white shadow-md">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs opacity-80">Peringkat Anda</p>
                        <p class="text-2xl font-bold">#{{ $currentUserRank ?? '?' }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Total Poin Anda</p>
                        <p class="text-2xl font-bold text-slate-800">{{ number_format($currentUserPoints ?? 0) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Total Pinjaman</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $currentUserTotalBorrowed ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endauth

        {{-- Podium Top 3 --}}
        @php
            $top3 = $rankings->take(3);
            $podiumColors = ['from-amber-500 to-amber-600', 'from-slate-400 to-slate-500', 'from-amber-700 to-amber-800'];
            $ringColors = ['ring-amber-400', 'ring-slate-300', 'ring-amber-600'];
            $order = [2, 1, 3]; // Urutan tampilan: posisi 2 di kiri, 1 di tengah, 3 di kanan
        @endphp
        @if($top3->count() >= 3)
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-800">🏆 Puncak Peringkat</h2>
                <p class="text-slate-500 text-sm mt-1">Tiga terbaik dengan poin tertinggi</p>
            </div>
            <div class="flex flex-col md:flex-row justify-center items-end gap-5">
                @foreach($order as $pos)
                    @php
                        $index = $pos - 1;
                        if ($index >= $top3->count()) continue;
                        $rank = $top3[$index];
                        $rankNumber = $pos;
                        $initial = strtoupper(substr($rank->nama ?? $rank->username, 0, 1));
                    @endphp
                    <div class="flex-1 text-center transform transition-all duration-300 hover:-translate-y-1">
                        <div class="relative inline-block mx-auto">
                            <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br {{ $podiumColors[$index] }} flex items-center justify-center text-white text-3xl font-bold shadow-lg ring-4 {{ $ringColors[$index] }} ring-offset-2">
                                {{ $initial }}
                            </div>
                            <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center text-sm font-black text-slate-700 border">
                                #{{ $rankNumber }}
                            </div>
                        </div>
                        <p class="font-bold text-slate-800 mt-3">{{ $rank->nama ?? $rank->username }}</p>
                        <p class="text-sm text-slate-500">{{ number_format($rank->points ?? 0) }} poin</p>
                        <div class="mt-2 w-16 h-1 mx-auto rounded-full bg-gradient-to-r from-costume-primary/40 to-costume-primary"></div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Daftar Lengkap Peringkat (Card List) --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-slate-800">Papan Peringkat</h2>
                    <p class="text-xs text-slate-500">Semua peminjam berdasarkan poin</p>
                </div>
                <div class="text-xs text-slate-400">
                    Total {{ $rankings->total() }} peserta
                </div>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($rankings as $index => $rank)
                    @php
                        $rankNumber = $rankings->firstItem() + $index;
                        $isCurrentUser = auth()->check() && ($rank->id == auth()->id());
                        $initial = strtoupper(substr($rank->nama ?? $rank->username, 0, 1));
                        $bgClass = $isCurrentUser ? 'bg-costume-primary/5' : 'hover:bg-slate-50';
                    @endphp
                    <div class="flex items-center gap-4 px-6 py-4 transition-all duration-200 {{ $bgClass }}">
                        <div class="w-10 text-center">
                            @if($rankNumber <= 3)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                    {{ $rankNumber == 1 ? 'bg-amber-100 text-amber-700' : ($rankNumber == 2 ? 'bg-slate-100 text-slate-600' : 'bg-amber-100 text-amber-800') }}
                                    font-bold text-sm">#{{ $rankNumber }}</span>
                            @else
                                <span class="text-slate-400 font-medium text-sm">#{{ $rankNumber }}</span>
                            @endif
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-costume-primary to-costume-second flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ $initial }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-slate-800">{{ $rank->nama ?? $rank->username }}</p>
                                @if($isCurrentUser)
                                    <span class="text-[10px] font-medium bg-costume-primary text-white px-2 py-0.5 rounded-full">Anda</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 mt-1">
                                <div class="flex items-center gap-1 text-xs text-slate-500">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    <span>{{ $rank->total_borrowed ?? 0 }} pinjaman</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-costume-primary">{{ number_format($rank->points ?? 0) }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wide">poin</p>
                        </div>
                    </div>
                @endforeach
            </div>
            @if($rankings->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $rankings->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
