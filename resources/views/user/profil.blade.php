@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-2xl mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h1 class="text-xl font-bold text-gray-800 mb-6">Profil Saya</h1>

                <div class="flex items-center gap-4 mb-6">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}"
                            class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                    @else
                        <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->nama ?? $user->username, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-800 text-lg">{{ $user->nama ?? $user->username }}</p>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Nama Lengkap</label>
                        <p class="text-gray-800 mt-1">{{ $user->nama ?? $user->username }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Username</label>
                        <p class="text-gray-800 mt-1">{{ $user->username }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Email</label>
                        <p class="text-gray-800 mt-1">{{ $user->email }}</p>
                    </div>
                    @if($user->kelas)
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Kelas</label>
                        <p class="text-gray-800 mt-1">{{ $user->kelas }}</p>
                    </div>
                    @endif
                    @if($user->nipd)
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">NIPD</label>
                        <p class="text-gray-800 mt-1">{{ $user->nipd }}</p>
                    </div>
                    @endif
                    @if($user->no_telpon)
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">No. Telepon</label>
                        <p class="text-gray-800 mt-1">{{ $user->no_telpon }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Bergabung sejak</label>
                        <p class="text-gray-800 mt-1">{{ $user->created_at->format('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Total Poin</label>
                        <p class="text-gray-800 mt-1 font-bold text-blue-600">{{ number_format($user->points ?? 0) }} Poin</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Tier</label>
                        <p class="text-gray-800 mt-1">{{ $user->tier ?? 'Reliant' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
