@extends('layouts.app') {{-- sesuaikan dengan nama layout utama kamu --}}

@section('content')

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-2xl mx-auto px-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h1 class="text-xl font-bold text-gray-800 mb-6">Profil Saya</h1>

                <div class="flex items-center gap-4 mb-6">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                            class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                    @else
                        <div
                            class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-800 text-lg">{{ $user->name }}</p>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    </div>
                </div>

                {{-- Ganti/tambah field sesuai kolom di tabel users kamu --}}
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Nama</label>
                        <p class="text-gray-800 mt-1">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Email</label>
                        <p class="text-gray-800 mt-1">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase tracking-wide font-medium">Bergabung sejak</label>
                        <p class="text-gray-800 mt-1">{{ $user->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection