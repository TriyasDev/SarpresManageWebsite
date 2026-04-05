@extends('layouts.user')

@section('title', 'Peringkat - KlikAset')

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
        {{-- Mobile header --}}
        <div class="lg:hidden sticky top-0 z-20 bg-white/80 backdrop-blur-sm border-b border-slate-200 px-4 py-3 flex items-center justify-between">
            <button onclick="openSidebarUser()" class="p-2 rounded-lg hover:bg-slate-100 transition">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <span class="font-bold text-slate-800">Peringkat</span>
            <div class="w-8"></div>
        </div>

        <main class="p-4 md:p-6 space-y-6">
            {{-- Header --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                <h1 class="text-2xl font-bold text-slate-800">Peringkat Peminjam</h1>
                <p class="text-slate-500 text-sm mt-1">Persaingan sehat, raih poin terbanyak!</p>
            </div>

            {{-- Kartu Statistik Pribadi --}}
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
                            <p class="text-2xl font-bold">#{{ $currentUserRank ?? $rankings->search(function($item) { return $item->id == auth()->id(); }) + 1 ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-costume-primary/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-costume-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase">Total Poin Anda</p>
                            <p class="text-2xl font-bold text-slate-800">{{ number_format($currentUserPoints ?? auth()->user()->points ?? 0) }}</p>
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
                            <p class="text-2xl font-bold text-slate-800">{{ $currentUserTotalBorrowed ?? auth()->user()->total_borrowed ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Peringkat --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Peringkat</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Peminjam</th>
                                <th class="text-center py-3 px-4 font-semibold text-slate-600">Total Poin</th>
                                <th class="text-center py-3 px-4 font-semibold text-slate-600">Total Pinjam</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($rankings as $index => $rank)
                                @php
                                    $rankNumber = $rankings->firstItem() + $index;
                                    $isCurrentUser = ($rank->id == auth()->id());
                                    $medal = '';
                                    $rankClass = '';
                                    if ($rankNumber == 1) {
                                        $medal = '🏆';
                                        $rankClass = 'bg-amber-50';
                                    } elseif ($rankNumber == 2) {
                                        $medal = '🥈';
                                        $rankClass = 'bg-slate-50';
                                    } elseif ($rankNumber == 3) {
                                        $medal = '🥉';
                                        $rankClass = 'bg-orange-50';
                                    }
                                    $avatar = strtoupper(substr($rank->nama ?? $rank->username, 0, 1));
                                @endphp
                                <tr class="{{ $rankClass }} {{ $isCurrentUser ? 'bg-costume-primary/5 border-l-4 border-costume-primary' : 'hover:bg-slate-50' }} transition">
                                    <td class="py-3 px-4 font-bold">
                                        @if($medal)
                                            <span class="inline-flex items-center gap-1">{{ $medal }} #{{ $rankNumber }}</span>
                                        @else
                                            <span class="text-slate-500">#{{ $rankNumber }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-costume-primary/10 flex items-center justify-center text-costume-primary font-semibold text-sm">
                                                {{ $avatar }}
                                            </div>
                                            <span class="font-medium text-slate-800">{{ $rank->nama ?? $rank->username }}</span>
                                            @if($isCurrentUser)
                                                <span class="text-xs bg-costume-primary text-white px-2 py-0.5 rounded-full">Anda</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center font-semibold text-slate-700">
                                        {{ number_format($rank->points ?? 0) }}
                                    </td>
                                    <td class="py-3 px-4 text-center text-slate-600">
                                        {{ $rank->total_borrowed ?? 0 }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12 text-slate-400">
                                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Belum ada data peringkat
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($rankings->hasPages())
                    <div class="px-4 py-3 border-t border-slate-100">
                        {{ $rankings->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
