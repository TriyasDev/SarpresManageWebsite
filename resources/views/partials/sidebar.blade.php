<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KlikAset - Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>

<body class="bg-gray-50/50 font-sans antialiased">
    <div class="flex min-h-screen">

        <!-- Mobile Hamburger Button -->
        <button id="mobileMenuBtn"
            class="lg:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-2.5 rounded-[30px] shadow-lg hover:bg-blue-700 transition-all duration-200"
            aria-label="Toggle Menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 lg:pl-64 min-w-0">
            <main class="w-full px-4 sm:px-5 lg:px-8 xl:px-10 py-5 pt-16 lg:pt-6 lg:py-6">
                @yield('content')
            </main>
        </div>

    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden"></div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar        = document.getElementById('sidebar');
            const mobileMenuBtn  = document.getElementById('mobileMenuBtn');
            const closeSidebarBtn= document.getElementById('closeSidebarBtn');
            const overlay        = document.getElementById('overlay');

            if (!sidebar || !mobileMenuBtn) return;

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                // Sembunyikan hamburger agar tidak menimpa sidebar
                mobileMenuBtn.classList.add('hidden');
            }

            function closeSidebar() {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
                // Tampilkan kembali hamburger
                mobileMenuBtn.classList.remove('hidden');
            }

            mobileMenuBtn.addEventListener('click', openSidebar);
            closeSidebarBtn?.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) closeSidebar();
            });
        });
    </script>
</body>

</html>
