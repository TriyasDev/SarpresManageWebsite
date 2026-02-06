<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('') }}"></script>

</head>
<body class="bg-gray-100 font-sans">
    <div class="flex flex-col lg:flex-row min-h-screen">  
        <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-blue-400 text-white p-3 rounded-xl shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 w-64 bg-gradient-to-b from-blue-800 to-blue-800 p-4 lg:p-6 flex flex-col">
   
            <button id="closeSidebarBtn" class="lg:hidden absolute top-4 right-4 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <div class="flex items-center gap-2 lg:gap-3 mb-6 lg:mb-8 mt-2">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('Backend/bbc.jpg') }}" alt="" class="w-12 h-12 object-contain">
                </div>
                <h1 class="text-white text-xl lg:text-2xl font-bold">BiBiSi.</h1>
            </div>
            
           @include('partials.sidebar')
            
            <a href="#" class="flex items-center gap-3 lg:gap-4 px-4 lg:px-6 py-2.5 lg:py-3 text-white font-medium hover:bg-blue-400 rounded-xl transition mt-auto text-sm lg:text-base">
                <svg class="w-5 h-5 lg:w-6 lg:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </a>
        </aside> 
        
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>
        
      @yield('pengajuan')

   
</body>
</html>