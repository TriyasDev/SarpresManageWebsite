<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - KlikAset')</title>

    <!-- Preconnect for faster loading -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Chart.js - Load only when needed -->
    @stack('head-scripts')

    @stack('styles')
</head>

<body class="bg-gray-50/50 font-sans antialiased">
    <div class="flex min-h-screen">

        <!-- Mobile Menu Button -->
        <button
            id="mobileMenuBtn"
            class="lg:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-2.5 rounded-full shadow-lg hover:bg-blue-700 transition-colors"
            aria-label="Toggle Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content Wrapper - OPTIMIZED -->
        <div class="flex-1 lg:pl-64 min-w-0">
            <main class="w-full px-4 sm:px-6 lg:px-8 py-6 pt-16 lg:pt-6">

                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700" role="alert">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>

    </div>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden transition-opacity"></div>

    <!-- Scripts -->
    @stack('scripts')

    <!-- Mobile Menu Script - Optimized -->
    <script>
    (function() {
        'use strict';

        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const overlay = document.getElementById('overlay');

        if (!sidebar || !mobileMenuBtn) return;

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        mobileMenuBtn.addEventListener('click', openSidebar);

        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeSidebar);
        }

        overlay.addEventListener('click', closeSidebar);

        // Close on resize to desktop
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            }, 250);
        });

        // Auto-hide flash messages after 5 seconds
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    })();
    </script>
</body>
</html>
