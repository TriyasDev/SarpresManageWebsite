@extends('layouts.auth')
@section('title', 'Login - KlikAset')

@section('content')
<div class="max-w-7xl mx-auto h-screen flex items-center justify-center p-4">

    <!-- Main Container - Ubah dari dark ke light theme -->
    <div class="bg-white rounded-[30px] shadow-2xl overflow-hidden w-full max-w-6xl h-[700px] flex border border-slate-200">

        <!-- Left Side - Image Slider dengan Overlay Terang -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden rounded-l-[30px]">
            <!-- Image Slider Container -->
            <div id="imageSlider" class="absolute inset-0 w-full h-full bg-slate-100">
                <!-- Slide 1 -->
                <div class="slider-item active absolute inset-0 w-full h-full transition-transform duration-700 ease-in-out">
                    <img src="{{ asset('images/assets/universitas0.webp') }}"
                         alt="KlikAset - Slide 1"
                         class="w-full h-full object-cover"
                         style="object-position: center 60%;"
                         loading="eager"
                         fetchpriority="high">
                    <!-- Overlay terang untuk harmonisasi -->
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

            <!-- Text Overlay - Tetap white untuk kontras dengan background -->
            <div class="absolute bottom-12 left-8 right-8 z-10 text-white">
                <span class="text-4xl font-bold mb-3 leading-tight transition-all duration-500">KlikA<span class="text-costume-primary">set.</span></span>
                <p class="text-white/90 text-lg leading-relaxed max-w-sm transition-all duration-500">
                    Mempermudah pendataan dan peminjamana aset sekolah
                </p>

                <!-- Dots Indicator -->
                <div class="flex gap-2 mt-6">
                    <div class="dot w-8 h-1 bg-white rounded-full transition-all duration-300"></div>
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                    <div class="dot w-1 h-1 bg-white/40 rounded-full transition-all duration-300"></div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form Login dengan Light Theme -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col justify-center p-12 relative">

            <!-- Back Button -->
            <a href="/" class="absolute top-8 right-8 text-slate-600 hover:text-costume-primary transition-colors duration-200 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke beranda
            </a>

            <div class="max-w-md mx-auto w-full">
                <!-- Title -->
                <div class="mb-8">
                    <h2 class="text-slate-900 text-3xl font-bold mb-2">Login ke akun anda</h2>
                    <p class="text-slate-600 text-sm">
                        Belum punya akun?
                        <a href="#" class="text-costume-primary hover:text-costume-primary/80 font-semibold">Hubungi Admin</a>
                    </p>
                </div>

                <!-- Alert Error -->
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
                    <p class="text-red-600 text-sm">{{ session('error') }}</p>
                </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('auth.login') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-costume-primary focus:border-transparent transition-all duration-200 text-slate-900 placeholder-slate-400"
                            placeholder="Masukkan email Anda"
                        >
                        @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-costume-primary focus:border-transparent transition-all duration-200 text-slate-900 placeholder-slate-400"
                                placeholder="Masukkan password"
                            >
                            <!-- Toggle Password Icon -->
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
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

                    <!-- Remember & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <!-- Custom Checkbox -->
                        <label class="flex items-center cursor-pointer group">
                            <input
                                type="checkbox"
                                name="remember"
                                id="rememberCheckbox"
                                class="peer sr-only"
                            >
                            <div class="w-5 h-5 bg-white rounded-full border-2 border-slate-300 peer-checked:bg-costume-primary peer-checked:border-costume-primary transition-all duration-200 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="ml-2 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Ingat saya</span>
                        </label>

                        <a href="{{ route('auth.lupa_password') }}" class="text-sm text-costume-primary hover:text-costume-primary/80 font-medium transition-colors duration-200">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-costume-primary hover:bg-costume-primary/90 text-white font-bold py-3.5 rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30"
                    >
                        Masuk
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
// Preload & Wait for Images
const imageUrls = [
    "{{ asset('images/assets/universitas0.webp') }}",
    "{{ asset('images/assets/universitas1.webp') }}",
    "{{ asset('images/assets/universitas2.webp') }}"
];

let imagesLoaded = false;

// Preload semua gambar
function preloadImages() {
    let loadedCount = 0;

    imageUrls.forEach(url => {
        const img = new Image();
        img.src = url;
        img.onload = () => {
            loadedCount++;
            if (loadedCount === imageUrls.length) {
                imagesLoaded = true;
                console.log('Semua gambar slider berhasil dimuat');
            }
        };
    });
}

// Jalankan preload saat halaman load
preloadImages();

// Image Slider
let currentSlide = 0;
const slides = document.querySelectorAll('.slider-item');
const dots = document.querySelectorAll('.dot');
const totalSlides = slides.length;

function showSlide(index) {
    // Hanya jalankan slider jika gambar sudah load
    if (!imagesLoaded) return;

    // Reset semua slides
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

    // Update dots
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

// Auto slide setiap 5 detik - hanya jika gambar sudah loaded
setInterval(() => {
    if (imagesLoaded) {
        nextSlide();
    }
}, 5000);

// Password Toggle
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

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

// Custom Checkbox
document.getElementById('rememberCheckbox').addEventListener('change', function() {
    const checkmark = this.nextElementSibling.querySelector('svg');
    if (this.checked) {
        checkmark.classList.remove('opacity-0');
        checkmark.classList.add('opacity-100');
    } else {
        checkmark.classList.remove('opacity-100');
        checkmark.classList.add('opacity-0');
    }
});
</script>

<!-- Custom CSS untuk Slider & Checkbox -->
<style>
/* Slider Animation */
.slider-item {
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom Checkbox */
#rememberCheckbox:checked + div {
    background-color: var(--color-costume-primary);
    border-color: var(--color-costume-primary);
}

#rememberCheckbox:checked + div svg {
    opacity: 1;
}

/* Smooth transitions */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>

@endsection
