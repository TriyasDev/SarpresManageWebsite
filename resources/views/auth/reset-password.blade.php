@extends('layouts.auth')
@section('title', 'Reset Password - KlikAset')

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
                <h2 class="text-4xl font-bold mb-3 leading-tight">Buat Password Baru</h2>
                <p class="text-white/90 text-lg leading-relaxed max-w-sm">
                    Password baru Anda harus berbeda dari password sebelumnya
                </p>

                <!-- Dots Indicator -->
                <div class="flex gap-2 mt-6">
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                    <div class="dot w-8 h-1 bg-white rounded-full transition-all duration-300"></div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center p-12 relative">

            <div class="max-w-md mx-auto w-full">
                <!-- Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-costume-primary to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <div class="mb-8 text-center">
                    <h2 class="text-slate-900 text-3xl font-bold mb-2">Buat Password Baru</h2>
                    <p class="text-slate-600 text-sm">
                        Password baru harus minimal 8 karakter
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
                <form action="{{ route('auth.reset_password_submit') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                minlength="8"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-costume-primary focus:border-transparent transition-all duration-200 text-slate-900 placeholder-slate-400"
                                placeholder="Masukkan password baru"
                            >
                            <!-- Toggle Password Icon -->
                            <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="mt-2 flex gap-1">
                            <div id="strength1" class="h-1 flex-1 bg-slate-200 rounded-full transition-all duration-200"></div>
                            <div id="strength2" class="h-1 flex-1 bg-slate-200 rounded-full transition-all duration-200"></div>
                            <div id="strength3" class="h-1 flex-1 bg-slate-200 rounded-full transition-all duration-200"></div>
                            <div id="strength4" class="h-1 flex-1 bg-slate-200 rounded-full transition-all duration-200"></div>
                        </div>
                        <p id="strengthText" class="text-xs mt-1 text-slate-500"></p>
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                minlength="8"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-costume-primary focus:border-transparent transition-all duration-200 text-slate-900 placeholder-slate-400"
                                placeholder="Ulangi password baru"
                            >
                            <!-- Toggle Password Icon -->
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg id="eyeIcon2" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-costume-primary hover:bg-costume-primary/90 text-white font-bold py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30"
                    >
                        Reset Password
                    </button>

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

// Password Toggle
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const iconId = fieldId === 'password' ? 'eyeIcon1' : 'eyeIcon2';
    const eyeIcon = document.getElementById(iconId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}

// Password Strength Checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength1 = document.getElementById('strength1');
    const strength2 = document.getElementById('strength2');
    const strength3 = document.getElementById('strength3');
    const strength4 = document.getElementById('strength4');
    const strengthText = document.getElementById('strengthText');
    
    // Reset
    [strength1, strength2, strength3, strength4].forEach(el => {
        el.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500');
        el.classList.add('bg-slate-200');
    });
    
    if (password.length === 0) {
        strengthText.textContent = '';
        return;
    }
    
    let strength = 0;
    
    // Check length
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    
    // Check for lowercase and uppercase
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    
    // Check for numbers and special characters
    if (/[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) strength++;
    
    // Update UI
    if (strength >= 1) {
        strength1.classList.remove('bg-slate-200');
        strength1.classList.add('bg-red-500');
        strengthText.textContent = 'Password lemah';
        strengthText.className = 'text-xs mt-1 text-red-500';
    }
    if (strength >= 2) {
        strength2.classList.remove('bg-slate-200');
        strength2.classList.add('bg-yellow-500');
        strengthText.textContent = 'Password cukup';
        strengthText.className = 'text-xs mt-1 text-yellow-500';
    }
    if (strength >= 3) {
        strength3.classList.remove('bg-slate-200');
        strength3.classList.add('bg-blue-500');
        strengthText.textContent = 'Password baik';
        strengthText.className = 'text-xs mt-1 text-blue-500';
    }
    if (strength >= 4) {
        strength4.classList.remove('bg-slate-200');
        strength4.classList.add('bg-green-500');
        strengthText.textContent = 'Password kuat';
        strengthText.className = 'text-xs mt-1 text-green-500';
    }
});
</script>

<style>
.slider-item {
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

@endsection
