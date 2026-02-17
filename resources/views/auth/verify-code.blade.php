@extends('layouts.auth')
@section('title', 'Verifikasi Kode - KlikAset')

@section('content')
<div class="max-w-7xl mx-auto h-screen flex items-center justify-center p-4">

    <!-- Main Container -->
    <div class="bg-white rounded-[30px] shadow-2xl overflow-hidden w-full max-w-6xl h-[700px] flex border border-slate-200">

        <!-- Left Side - Image Slider -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden rounded-l-[30px]">
            <div id="imageSlider" class="absolute inset-0 w-full h-full bg-slate-100">
                <!-- Slide 1 -->
                <div class="slider-item active absolute inset-0 w-full h-full transition-transform duration-700 ease-in-out">
                    <img src="{{ asset('images/assets/universitas0.webp') }}"
                         alt="KlikAset - Slide 1"
                         class="w-full h-full object-cover"
                         style="object-position: center 60%;"
                         loading="eager">
                    <div class="absolute inset-0 bg-linear-to-t"></div>
                </div>

                <!-- Slide 2 -->
                <div class="slider-item absolute inset-0 w-full h-full transition-transform duration-700 ease-in-out translate-x-full">
                    <img src="{{ asset('images/assets/universitas1.webp') }}"
                         alt="KlikAset - Slide 2"
                         class="w-full h-full object-cover"
                         style="object-position: center 50%;"
                         loading="eager">
                    <div class="absolute inset-0 bg-linear-to-t"></div>
                </div>

                <!-- Slide 3 -->
                <div class="slider-item absolute inset-0 w-full h-full transition-transform duration-700 ease-in-out translate-x-full">
                    <img src="{{ asset('images/assets/universitas2.webp') }}"
                         alt="KlikAset - Slide 3"
                         class="w-full h-full object-cover"
                         style="object-position: center 100%;"
                         loading="eager">
                    <div class="absolute inset-0 bg-linear-to-t"></div>
                </div>
            </div>

            <!-- Text Overlay -->
            <div class="absolute bottom-12 left-8 right-8 z-10 text-white">
                <h2 class="text-4xl font-bold mb-3 leading-tight">Cek Email Anda</h2>
                <p class="text-white/90 text-lg leading-relaxed max-w-sm">
                    Kami telah mengirimkan kode verifikasi 6 digit ke email Anda
                </p>

                <!-- Dots Indicator -->
                <div class="flex gap-2 mt-6">
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                    <div class="dot w-8 h-1 bg-white rounded-full transition-all duration-300"></div>
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center p-12 relative">

            <!-- Back Button -->
            <a href="{{ route('auth.lupa_password') }}" class="absolute top-8 right-8 text-slate-600 hover:text-costume-primary transition-colors duration-200 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>

            <div class="max-w-md mx-auto w-full">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-costume-primary to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <div class="mb-8 text-center">
                    <h2 class="text-slate-900 text-3xl font-bold mb-2">Masukkan Kode</h2>
                    <p class="text-slate-600 text-sm">
                        Kami telah mengirimkan kode verifikasi ke <br>
                        <span class="font-semibold text-costume-primary">{{ session('reset_email') }}</span>
                    </p>
                    <p class="text-slate-500 text-xs mt-2">
                        ⏰ Kode berlaku selama 15 menit
                    </p>
                </div>

                <!-- Alert Success -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
                    <p class="text-green-600 text-sm">{{ session('success') }}</p>
                </div>
                @endif

                <!-- Alert Error -->
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
                    @foreach($errors->all() as $error)
                    <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('auth.verify_code_submit') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Code Input -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-slate-700 mb-3 text-center">Kode Verifikasi</label>
                        <div class="flex justify-center">
                            <input
                                type="text"
                                id="code"
                                name="code"
                                maxlength="6"
                                required
                                class="w-full max-w-xs text-center text-3xl font-bold tracking-[1em] px-6 py-4 bg-slate-50 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-costume-primary focus:border-transparent transition-all duration-200 text-slate-900 placeholder-slate-300"
                                placeholder="000000"
                                autocomplete="off"
                                inputmode="numeric"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            >
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-costume-primary hover:bg-costume-primary/90 text-white font-bold py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30"
                    >
                        Verifikasi Kode
                    </button>

                    <!-- Resend Code -->
                    <div class="text-center mt-6">
                        <p class="text-slate-600 text-sm mb-3">
                            Tidak menerima kode?
                        </p>
                        <form action="{{ route('auth.resend_code') }}" method="POST" class="inline">
                            @csrf
                            <button
                                type="submit"
                                class="text-costume-primary hover:text-costume-primary/80 font-semibold text-sm inline-flex items-center gap-1"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Kirim Ulang Kode
                            </button>
                        </form>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
// Image Slider
let currentSlide = 0;
const slides = document.querySelectorAll('.slider-item');
const dots = document.querySelectorAll('.dot');
const totalSlides = slides.length;

function showSlide(index) {
    slides.forEach((slide, i) => {
        if (i < index) {
            slide.classList.remove('translate-x-full');
            slide.classList.add('-translate-x-full');
        } else if (i === index) {
            slide.classList.remove('translate-x-full', '-translate-x-full');
        } else {
            slide.classList.remove('-translate-x-full');
            slide.classList.add('translate-x-full');
        }
    });

    dots.forEach((dot, i) => {
        if (i === index) {
            dot.classList.remove('w-1', 'bg-white/40');
            dot.classList.add('w-8', 'bg-white');
        } else {
            dot.classList.remove('w-8', 'bg-white');
            dot.classList.add('w-1', 'bg-white/40');
        }
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

setInterval(nextSlide, 5000);

// Auto focus on code input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('code').focus();
});
</script>

<style>
.slider-item {
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

@endsection
