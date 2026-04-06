<nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo & Brand --}}
            <div class="flex items-center gap-3">
                <span class="text-xl font-bold text-gray-800">KlikA<span class="text-costume-primary">set.</span></span>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#beranda"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Beranda
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#mengapa-kami"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Mengapa Kami?
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#sarana"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Sarpras
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#pinjam"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Pinjam
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="{{ route('rankings') }}"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors duration-200 relative group">
                    Rank
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-costume-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>

            {{-- Auth Buttons --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- Profile Photo Dropdown --}}
                    <div class="relative" id="profileDropdownWrapper">
                        <button id="profileBtn"
                            class="flex items-center gap-2 p-1 rounded-full hover:ring-2 hover:ring-costume-primary transition-all duration-200 focus:outline-none">
                            {{-- Foto profil user, fallback ke inisial jika tidak ada --}}
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil"
                                    class="w-9 h-9 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div
                                    class="w-9 h-9 rounded-full bg-costume-primary flex items-center justify-center text-white font-semibold text-sm border-2 border-gray-200">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="text-sm font-medium text-gray-700 max-w-[100px] truncate">
                                {{ auth()->user()->name }}
                            </span>
                            {{-- Chevron icon --}}
                            <svg id="chevronIcon" class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-lg border border-gray-100 py-2 z-50 animate-fadeIn">

                            {{-- User Info --}}
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Masuk sebagai</p>
                                <p class="text-sm font-semibold text-gray-800 truncate mt-0.5">{{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

{{-- Menu Items --}}
@auth
    @if(auth()->user()->isAdmin())
        {{-- Admin / Super-admin menuju dashboard admin --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-costume-primary transition-colors group">
            <svg class="w-4 h-4 text-gray-400 group-hover:text-costume-primary transition-colors"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
    @else
        {{-- Peminjam menuju my-dashboard --}}
        <a href="{{ route('my.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-costume-primary transition-colors group">
            <svg class="w-4 h-4 text-gray-400 group-hover:text-costume-primary transition-colors"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
    @endif
@endauth
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('auth.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors group">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('auth.login') }}"
                        class="px-5 py-2 rounded-[30px] border-2 border-gray-200 text-gray-700 text-sm font-medium hover:border-costume-primary hover:text-costume-primary transition-all duration-200">
                        Login
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="px-6 py-4 space-y-3">
            <a href="#beranda"
                class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Beranda</a>
            <a href="#mengapa-kami"
                class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Mengapa
                Kami?</a>
            <a href="#sarana"
                class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Sarana/Prasarana</a>
            <a href="#pinjam"
                class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Pinjam</a>
            <a href="#rank"
                class="block text-sm font-medium text-gray-600 hover:text-costume-primary transition-colors py-2">Rank</a>

            <div class="pt-3 space-y-2 border-t border-gray-100">
                @auth
                    {{-- Mobile: User Info --}}
                    <div class="flex items-center gap-3 py-2">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200" alt="Profil">
                        @else
                            <div
                                class="w-10 h-10 rounded-full bg-costume-primary flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <a href="{{route('dashboard') }}"
                        class="block w-full text-center px-5 py-2 rounded-[30px] border-2 border-costume-primary text-costume-primary text-sm font-medium hover:bg-costume-primary hover:text-white transition-all">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-center px-5 py-2 rounded-[30px] border-2 border-gray-200 text-red-500 text-sm font-medium hover:border-red-500 hover:bg-red-50 transition-all">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('auth.login') }}"
                        class="block w-full text-center px-5 py-2 rounded-[30px] border-2 border-gray-200 text-gray-700 text-sm font-medium hover:border-costume-primary hover:text-costume-primary transition-all">
                        Login
                    </a>
                    <a href="#"
                        class="block w-full text-center px-5 py-2 rounded-[30px] bg-costume-primary text-white text-sm font-medium hover:bg-blue-700 transition-all shadow-sm">
                        Daftar
                    </a>
                @endauth
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

        // Profile dropdown toggle
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const chevronIcon = document.getElementById('chevronIcon');

        profileBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            chevronIcon.classList.toggle('rotate-180');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!document.getElementById('profileDropdownWrapper')?.contains(e.target)) {
                profileDropdown?.classList.add('hidden');
                chevronIcon?.classList.remove('rotate-180');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Navbar shadow on scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.15s ease-out forwards;
        }
    </style>
@endpush
