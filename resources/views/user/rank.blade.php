@extends('layouts.app')

@section('title', 'Peringkat - KlikAset')

@push('styles')
<style>
    /* ... styles dari rank.blade.php yang sudah ada ... */
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-4xl mx-auto px-6">
        {{-- My Rank Card --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 mb-6 text-white">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($user->nama ?? $user->username, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="text-blue-100 text-sm">Posisi Kamu</p>
                    <p class="text-2xl font-bold">#{{ $position }}</p>
                    <p class="text-sm">{{ $user->nama ?? $user->username }}</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 text-sm">Total Poin</p>
                    <p class="text-2xl font-bold">{{ number_format($user->points ?? 0) }}</p>
                    <p class="text-sm">{{ $user->tier }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-sm mb-1">
                    <span>Menuju {{ $nextTier ?? 'Puncak' }}</span>
                    <span>{{ $currentPoints }} / {{ $nextTier ? $tierRequirements[$nextTier]['min_points'] : $currentPoints }}</span>
                </div>
                <div class="h-2 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        </div>

        {{-- Top 3 Podium --}}
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-center font-bold text-lg mb-6">🏆 Top 3 Peringkat</h2>
            <div class="flex justify-center items-end gap-4">
                @foreach($rankings->take(3) as $index => $rank)
                    @php
                        $rankNumber = $index + 1;
                        $colors = [
                            1 => ['bg' => 'bg-yellow-500', 'height' => 'h-28', 'crown' => '👑'],
                            2 => ['bg' => 'bg-gray-400', 'height' => 'h-20', 'crown' => '🥈'],
                            3 => ['bg' => 'bg-amber-600', 'height' => 'h-16', 'crown' => '🥉'],
                        ];
                    @endphp
                    <div class="text-center flex-1">
                        <div class="relative">
                            <div class="w-16 h-16 mx-auto rounded-full {{ $colors[$rankNumber]['bg'] }} flex items-center justify-center text-white text-xl font-bold mb-2">
                                {{ strtoupper(substr($rank->nama ?? $rank->username, 0, 1)) }}
                            </div>
                            <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 text-xl">{{ $colors[$rankNumber]['crown'] }}</div>
                        </div>
                        <p class="font-semibold text-sm">{{ $rank->nama ?? $rank->username }}</p>
                        <p class="text-xs text-gray-500">{{ number_format($rank->points) }} Poin</p>
                        <div class="mt-2 {{ $colors[$rankNumber]['height'] }} {{ $colors[$rankNumber]['bg'] }} rounded-t-lg flex items-center justify-center text-white font-bold text-xl">
                            {{ $rankNumber }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Full Ranking List --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="font-bold">Papan Peringkat</h2>
                <p class="text-xs text-gray-500">Top {{ $rankings->count() }} peminjam terbaik</p>
            </div>
            <div class="divide-y">
                @foreach($rankings as $index => $rank)
                    <div class="flex items-center gap-4 p-4 hover:bg-gray-50 {{ $rank->id_user == $user->id_user ? 'bg-blue-50' : '' }}">
                        <div class="w-8 text-center font-bold text-gray-500">#{{ $loop->iteration }}</div>
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($rank->nama ?? $rank->username, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">{{ $rank->nama ?? $rank->username }}</p>
                            <p class="text-xs text-gray-500">Total pinjam: {{ $rank->total_borrowed ?? 0 }} kali</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-blue-600">{{ number_format($rank->points) }}</p>
                            <p class="text-xs text-gray-500">Poin</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
