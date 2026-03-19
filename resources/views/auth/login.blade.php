@extends('layouts.auth')
@section('title', 'Login - KlikAset')

@section('content')
<div class="max-w-7xl mx-auto min-h-screen flex items-center justify-center p-4">

    <!-- Main Container -->
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-6xl min-h-[600px] lg:h-[700px] flex border border-slate-200">

        <!-- Left Side - Simplified Image Slider -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden rounded-l-3xl bg-gradient-to-br from-blue-600 to-blue-800">

            <!-- Single Background Image - Lazy Load -->
            <div class="absolute inset-0 w-full h-full">
                <img
                    src="{{ asset('images/assets/universitas0.webp') }}"
                    alt="KlikAset"
                    class="w-full h-full object-cover opacity-20"
                    loading="lazy"
                    style="object-position: center 60%;">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 to-transparent"></div>
            </div>

            <!-- Content Overlay -->
            <div class="absolute bottom-12 left-8 right-8 z-10 text-white">
                <h1 class="text-4xl font-bold mb-3 leading-tight">
                    KlikA<span class="text-blue-300">set.</span>
                </h1>
                <p class="text-white/90 text-lg leading-relaxed max-w-sm">
                    Mempermudah pendataan dan peminjaman aset sekolah
                </p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center p-8 lg:p-12 relative">

            <!-- Back Button -->
            <a href="/" class="absolute top-6 right-6 text-slate-600 hover:text-blue-600 transition-colors text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>

            <div class="max-w-md mx-auto w-full">

                <!-- Title -->
                <div class="mb-8">
                    <h2 class="text-slate-900 text-3xl font-bold mb-2">Masuk ke Akun</h2>
                    <p class="text-slate-600 text-sm">
                        Belum punya akun?
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">Hubungi Admin</a>
                    </p>
                </div>

                <!-- Alert Error -->
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
                @endif

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-sm">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('auth.login') }}" method="POST" class="space-y-5" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-slate-900 placeholder-slate-400"
                            placeholder="nama@email.com"
                        >
                        @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 pr-12 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-slate-900"
                                placeholder="••••••••"
                            >
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                                aria-label="Toggle password visibility"
                            >
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-2 focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-slate-600">Ingat saya</span>
                        </label>

                        <a href="{{ route('auth.lupa_password') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="btnText">Masuk</span>
                        <span id="btnLoader" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
// Optimized JavaScript - Minimal & Fast
(function() {
    'use strict';

    // Password Toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            if (type === 'text') {
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
            } else {
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        });
    }

    // Form Submit Handler with Loading State
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');

    if (loginForm && submitBtn) {
        loginForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
        });
    }

})();
</script>

@endsection
