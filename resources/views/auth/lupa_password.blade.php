@extends('layouts.auth')

@section('title', 'Lupa Password - KlikAset')

@section('content')
<!-- Logo & Title -->
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-4 shadow-lg">
        <x-icon-logo-klikaset class="w-12 h-12"/>
    </div>
    <h1 class="text-white text-3xl font-bold mb-2">Lupa Password?</h1>
    <p class="text-white/70 text-sm max-w-xs mx-auto">Masukkan email Anda dan kami akan mengirimkan instruksi untuk reset password</p>
</div>

<!-- Forgot Password Card -->
<div class="bg-white rounded-[30px] shadow-2xl p-8">

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
        <p class="text-green-600 text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
        <p class="text-red-600 text-sm">{{ session('error') }}</p>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('lupa_password.send') }}" method="POST" class="space-y-5">
        @csrf

        <!-- Email Input -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-costume-primary focus:border-transparent transition-all duration-200 text-gray-900"
                placeholder="nama@email.com"
            >
            @error('email')
            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full bg-costume-primary hover:bg-costume-second text-white font-bold py-3.5 rounded-2xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
        >
            Kirim Link Reset Password
        </button>

    </form>

    <!-- Back to Login -->
    <div class="mt-6 text-center">
        <a href="{{ route('auth.login') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-costume-primary font-medium transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke login
        </a>
    </div>

</div>

<!-- Footer -->
<p class="text-center text-white/50 text-xs mt-6">
    © {{ date('Y') }} KlikAset. All rights reserved.
</p>
@endsection
