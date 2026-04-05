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
            {{-- Kartu Peringkat Saya (modern dengan efek glass) --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-costume-primary to-costume-second rounded-2xl p-6 text-white shadow-xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-8 -mb-8"></div>
                <div class="relative z-10 flex justify-between items-start flex-wrap gap-3">
                    <div>
                        <p class="text-white/70 text-sm uppercase tracking-wide">Peringkat Kamu</p>
                        <p class="text-5xl font-bold tracking-tight">#{{ $position ?? 1 }}</p>
                        <p class="text-lg font-medium mt-2">{{ $user->nama ?? $user->username ?? 'Pengguna' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-white/70 text-sm uppercase tracking-wide">Total Poin</p>
                        <p class="text-4xl font-bold">{{ number_format($currentPoints ?? 0) }}</p>
                        <p class="text-sm mt-1 px-3 py-0.5 bg-white/20 rounded-full inline-block">{{ $currentTier ?? 'Bronze' }}</p>
                    </div>
                </div>
                <div class="relative z-10 mt-5 space-y-1">
                    <div class="flex justify-between text-sm">
                        <span>Menuju {{ $nextTier ?? 'Silver' }}</span>
                        <span>{{ number_format($currentPoints ?? 0) }} / {{ number_format($nextTier ? ($tierRequirements[$nextTier]['min_points'] ?? 1000) : 1000) }}</span>
                    </div>
                    <div class="bg-white/30 rounded-full h-2 overflow-hidden">
                        <div class="bg-white rounded-full h-2 transition-all duration-700" style="width: {{ $percentage ?? 0 }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Top 3 Podium Modern (tanpa emoji berlebihan) --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="text-center mb-8">
                    <h2 class="text-xl font-bold text-slate-800">Puncak Peringkat</h2>
                    <p class="text-slate-500 text-sm mt-1">Tiga terbaik dengan poin tertinggi</p>
                </div>
                <div class="flex flex-col md:flex-row justify-center items-end gap-5">
                    @php
                        $top3 = $rankings->take(3);
                        $podiumColors = ['from-amber-500 to-amber-600', 'from-slate-400 to-slate-500', 'from-amber-700 to-amber-800'];
                        $ringColors = ['ring-amber-400', 'ring-slate-300', 'ring-amber-600'];
                        $order = [2, 1, 3]; // Untuk urutan tampilan: peringkat 2 di kiri, 1 di tengah, 3 di kanan
                    @endphp
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

            {{-- Daftar Lengkap Peringkat dengan desain card list yang lebih rapi --}}
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
                            $isCurrentUser = ($rank->id_user ?? $rank->id) == ($user->id_user ?? $user->id ?? auth()->id());
                            $rankNumber = $rankings->firstItem() + $index;
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
        </main>
    </div>
</div>
@endsection
