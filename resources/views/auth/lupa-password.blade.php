@extends('layouts.auth')
@section('title', 'Lupa Password - KlikAset')

@section('content')
<div class="max-w-7xl mx-auto h-screen flex items-center justify-center p-4">

    <!-- Toast Notification Container - HANYA untuk success messages -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-3"></div>

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
                <h2 class="text-4xl font-bold mb-3 leading-tight">Reset Password</h2>
                <p class="text-white/90 text-lg leading-relaxed max-w-sm">
                    Jangan khawatir! Kami akan mengirimkan kode verifikasi ke email Anda
                </p>

                <!-- Dots Indicator -->
                <div class="flex gap-2 mt-6">
                    <div class="dot w-8 h-1 bg-white rounded-full transition-all duration-300"></div>
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center p-12 relative">

            <!-- Back Button -->
            <a href="{{ route('auth.login') }}" class="absolute top-8 right-8 text-slate-600 hover:text-costume-primary transition-colors duration-200 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke login
            </a>

            <div class="max-w-md mx-auto w-full">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-costume-primary to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <div class="mb-8 text-center">
                    <h2 class="text-slate-900 text-3xl font-bold mb-2">Lupa Password?</h2>
                    <p class="text-slate-600 text-sm">
                        Masukkan email Anda dan kami akan mengirimkan kode verifikasi untuk mereset password
                    </p>
                </div>

                <!-- Form -->
                <form id="resetForm" action="{{ route('auth.send_reset_code') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                            Email Terdaftar <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                class="w-full pl-12 pr-12 py-3.5 bg-slate-50 border-2 border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-costume-primary focus:border-costume-primary transition-all duration-200 text-slate-900 placeholder-slate-400 @error('email') border-red-500 @enderror"
                                placeholder="contoh@email.com"
                                oninput="validateEmail(this)"
                            >
                            <!-- Checkmark Icon (shown when valid) -->
                            <div id="emailCheckmark" class="hidden absolute right-4 top-1/2 -translate-y-1/2 text-green-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Error Message - Ditampilkan di bawah field -->
                        @error('email')
                        <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-600 text-xs flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        </div>
                        @enderror

                        <!-- Email Validation Feedback (hanya muncul saat belum ada error dari server) -->
                        @if(!$errors->has('email'))
                        <div id="emailFeedback" class="mt-2 text-xs hidden">
                            <p class="text-slate-600 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Gunakan email yang terdaftar di sistem KlikAset
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-costume-primary hover:bg-costume-primary/90 text-white font-bold py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <span id="submitText">Kirim Kode Verifikasi</span>
                        <svg id="submitIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                        <!-- Loading Spinner -->
                        <svg id="loadingSpinner" class="hidden animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>

                    <!-- Additional Info -->
                    <div class="text-center pt-4 border-t border-slate-200">
                        <p class="text-slate-600 text-sm mb-3">
                            Sudah ingat password Anda?
                        </p>
                        <a href="{{ route('auth.login') }}" class="inline-flex items-center gap-2 text-costume-primary hover:text-costume-primary/80 font-semibold text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Kembali ke Halaman Login
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
// Toast Notification Function - HANYA untuk success messages
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer');
    const toast = document.createElement('div');

    const colors = {
        success: 'bg-white border-green-500',
    };

    const icons = {
        success: `<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>`,
    };

    toast.className = `${colors[type]} border-l-4 rounded-xl shadow-lg p-4 min-w-[320px] max-w-md transform transition-all duration-300 ease-out animate-slideIn`;
    toast.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
                ${icons[type]}
            </div>
            <div class="flex-1 text-sm text-slate-700">
                ${message}
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;

    toastContainer.appendChild(toast);

    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(400px)';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Show ONLY success messages as toast - errors ditampilkan di bawah field
@if(session('success'))
    showToast('{{ session('success') }}', 'success');
@endif

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

// Email Validation
function validateEmail(input) {
    const emailValue = input.value.trim();
    const emailCheckmark = document.getElementById('emailCheckmark');
    const emailFeedback = document.getElementById('emailFeedback');
    const submitBtn = document.getElementById('submitBtn');

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    emailCheckmark.classList.add('hidden');
    input.classList.remove('border-red-500', 'border-green-500');

    if (emailValue === '') {
        if (emailFeedback) emailFeedback.classList.remove('hidden');
        submitBtn.disabled = true;
        return;
    }

    if (emailFeedback) emailFeedback.classList.add('hidden');

    if (!emailPattern.test(emailValue)) {
        input.classList.add('border-red-500');
        submitBtn.disabled = true;
    } else {
        input.classList.add('border-green-500');
        emailCheckmark.classList.remove('hidden');
        submitBtn.disabled = false;
    }
}

// Form Submit Handler
document.getElementById('resetForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitIcon = document.getElementById('submitIcon');
    const loadingSpinner = document.getElementById('loadingSpinner');

    // Show loading state
    submitBtn.disabled = true;
    submitText.textContent = 'Mengirim kode...';
    submitIcon.classList.add('hidden');
    loadingSpinner.classList.remove('hidden');
});

// Auto focus on email input
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    emailInput.focus();

    // Auto validate jika ada old value
    if (emailInput.value) {
        validateEmail(emailInput);
    }
});
</script>

<style>
.slider-item {
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(400px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-slideIn {
    animation: slideIn 0.3s ease-out;
}
</style>

@endsection
