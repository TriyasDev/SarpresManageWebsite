@extends('layouts.user')

@section('title', 'Profil Saya - KlikAset')

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
            <span class="font-bold text-slate-800">Profil</span>
            <div class="w-8"></div>
        </div>

        <main class="p-4 md:p-6">
            <div class="max-w-3xl mx-auto space-y-6">
                {{-- Header Avatar dan info ringkas --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm text-center">
                    <div class="relative inline-block">
                        <div class="w-28 h-28 rounded-full bg-gradient-to-br from-costume-primary to-costume-second flex items-center justify-center text-white text-4xl font-bold shadow-lg ring-4 ring-white">
                            {{ strtoupper(substr($user->nama ?? $user->username, 0, 1)) }}
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mt-4">{{ $user->nama ?? $user->username }}</h2>
                    <p class="text-slate-500 text-sm">{{ $user->email }}</p>
                    <div class="flex flex-wrap justify-center gap-2 mt-3">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-costume-primary/10 text-costume-primary">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            {{ ucfirst($user->role ?? 'peminjam') }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" /></svg>
                            {{ $user->tier ?? 'Reliant' }}
                        </span>
                    </div>
                </div>

                {{-- Informasi Pribadi --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-costume-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Pribadi
                    </h3>
                    <div class="space-y-3">
                        <div class="flex flex-wrap justify-between py-2 border-b border-slate-100">
                            <span class="text-sm font-medium text-slate-500">Nama Lengkap</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->nama ?? '-' }}</span>
                        </div>
                        <div class="flex flex-wrap justify-between py-2 border-b border-slate-100">
                            <span class="text-sm font-medium text-slate-500">Username</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->username }}</span>
                        </div>
                        <div class="flex flex-wrap justify-between py-2 border-b border-slate-100">
                            <span class="text-sm font-medium text-slate-500">Email</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->email }}</span>
                        </div>
                        @if($user->kelas)
                        <div class="flex flex-wrap justify-between py-2 border-b border-slate-100">
                            <span class="text-sm font-medium text-slate-500">Kelas</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->kelas }}</span>
                        </div>
                        @endif
                        @if($user->nipd)
                        <div class="flex flex-wrap justify-between py-2 border-b border-slate-100">
                            <span class="text-sm font-medium text-slate-500">NIPD</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->nipd }}</span>
                        </div>
                        @endif
                        @if($user->no_telpon)
                        <div class="flex flex-wrap justify-between py-2 border-b border-slate-100">
                            <span class="text-sm font-medium text-slate-500">No. Telepon</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->no_telpon }}</span>
                        </div>
                        @endif
                        <div class="flex flex-wrap justify-between py-2">
                            <span class="text-sm font-medium text-slate-500">Bergabung sejak</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $user->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Poin & Tier dengan progres --}}
                @php
                    $currentPoints = $user->points ?? 0;
                    $currentTier = $user->tier ?? 'Reliant';
                    $tierRequirements = [
                        'Negligent' => 0,
                        'Reliant' => 0,
                        'Steward' => 500,
                        'Sentinel' => 1500,
                        'Exemplar' => 3500,
                        'Paragon' => 7000,
                    ];
                    $tiers = ['Negligent', 'Reliant', 'Steward', 'Sentinel', 'Exemplar', 'Paragon'];
                    $currentIndex = array_search($currentTier, $tiers);
                    $nextTier = null;
                    $percentage = 0;
                    $pointsToNext = 0;
                    $currentMin = $tierRequirements[$currentTier] ?? 0;

                    if ($currentIndex !== false && $currentIndex < count($tiers) - 1) {
                        $nextTier = $tiers[$currentIndex + 1];
                        $nextMin = $tierRequirements[$nextTier];
                        $pointsToNext = max(0, $nextMin - $currentPoints);
                        $range = $nextMin - $currentMin;
                        $percentage = $range > 0 ? min(100, max(0, ($currentPoints - $currentMin) / $range * 100)) : 0;
                    }
                @endphp

                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        Poin & Peringkat
                    </h3>
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div class="text-center p-4 bg-slate-50 rounded-xl">
                            <p class="text-3xl font-bold text-costume-primary">{{ number_format($currentPoints) }}</p>
                            <p class="text-xs text-slate-500 mt-1">Total Poin</p>
                        </div>
                        <div class="text-center p-4 bg-slate-50 rounded-xl">
                            <p class="text-3xl font-bold text-amber-600">{{ $currentTier }}</p>
                            <p class="text-xs text-slate-500 mt-1">Tier Saat Ini</p>
                        </div>
                    </div>

                    @if($nextTier)
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Menuju <span class="font-semibold">{{ $nextTier }}</span></span>
                            <span class="text-slate-600">{{ number_format($currentPoints) }} / {{ number_format($tierRequirements[$nextTier]) }} poin</span>
                        </div>
                        <div class="bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-costume-primary to-costume-second rounded-full h-2 transition-all duration-700" style="width: {{ $percentage }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500 text-right">Butuh {{ number_format($pointsToNext) }} poin lagi</p>
                    </div>
                    @else
                    <div class="text-center p-3 bg-green-50 rounded-xl">
                        <p class="text-sm text-green-700">🏆 Selamat! Anda telah mencapai tier tertinggi.</p>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
