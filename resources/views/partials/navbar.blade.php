<nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo & Brand --}}
            <div class="flex items-center gap-3">
                <span class="text-xl font-bold text-gray-800">KlikA<span class="text-costume-primary">set.</span></span>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#beranda" class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Beranda
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#mengapa-kami" class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Mengapa Kami?
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#sarana" class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Sarpras
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#pinjam" class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Pinjam
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#" class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Rank
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>

            {{-- Auth Buttons --}}
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('auth.login') }}" class="px-5 py-2 rounded-[30px] border-2 border-gray-200 text-gray-700 text-sm font-medium hover:border-costume-primary hover:text-costume-primary transition-all duration-200">
                    Login
                </a>
                <a href="#" class="px-5 py-2 rounded-[30px] bg-costume-primary text-white text-sm font-medium hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                    Daftar
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="px-6 py-4 space-y-3">
            <a href="#beranda" class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Beranda</a>
            <a href="#mengapa-kami" class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Mengapa Kami?</a>
            <a href="#sarana" class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Sarana/Prasarana</a>
            <a href="#pinjam" class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Pinjam</a>
            <a href="#rank" class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Rank</a>
            <div class="pt-3 space-y-2 border-t border-gray-100">
                <a href="{{ route('auth.login') }}" class="block w-full text-center px-5 py-2 rounded-[30px] border-2 border-gray-200 text-gray-700 text-sm font-medium hover:border-costume-primary hover:text-costume-primary transition-all">
                    Login
                </a>
                <a href="#" class="block w-full text-center px-5 py-2 rounded-[30px] bg-costume-primary text-white text-sm font-medium hover:bg-blue-700 transition-all shadow-sm">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuBtn?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if(target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                // Close mobile menu after click
                mobileMenu.classList.add('hidden');
            }
        });
    });

    // Navbar shadow on scroll
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if(window.scrollY > 10) {
            nav.classList.add('shadow-md');
        } else {
            nav.classList.remove('shadow-md');
        }
    });
</script>
@endpush
