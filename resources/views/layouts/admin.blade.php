<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KlikAset - Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50/50 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Mobile Menu Button -->
        <button
            id="mobileMenuBtn"
            class="lg:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-2.5 rounded-[30px] shadow-lg hover:bg-blue-700 transition-colors duration-200"
            aria-label="Toggle Menu"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content Wrapper -->
        <div class="flex-1 lg:pl-64">
            <main class="w-full max-w-[1400px] mx-auto px-4 sm:px-5 lg:px-8 xl:px-10 py-5 lg:py-6 pt-16 lg:pt-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    @stack('scripts')
</body>
</html>
