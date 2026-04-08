<aside id="sidebarUser" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300
           ease-in-out z-40 w-64 bg-costume-primary flex flex-col h-screen overflow-y-auto shadow-xl">
    <button id="closeSidebarUserBtn"
        class="lg:hidden absolute top-4 right-4 text-white hover:bg-white/20 p-2 rounded-full transition-colors duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

@php
    // Logo processing
    $svgLogo = file_get_contents(resource_path('svg/logo-klikaset.svg'));
    if ($svgLogo) {
        if (strpos($svgLogo, 'viewBox') === false) {
            $svgLogo = str_replace('<svg', '<svg viewBox="0 0 347 369"', $svgLogo);
        }
        $svgLogo = preg_replace('/width="\d+"/', '', $svgLogo);
        $svgLogo = preg_replace('/height="\d+"/', '', $svgLogo);
        $svgLogo = str_replace('<svg', '<svg class="w-full h-full object-contain"', $svgLogo);
    } else {
        $svgLogo = '<svg class="w-full h-full" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
    }

    // Helper function with existence check
    if (!function_exists('getMenuIcon')) {
        function getMenuIcon($filename, $class = 'w-10 h-10 shrink-0 text-white') {
            $path = resource_path('svg/' . $filename);
            if (!file_exists($path)) {
                return '<svg class="' . $class . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>';
            }
            $svg = file_get_contents($path);
            $svg = preg_replace('/width="\d+"/', '', $svg);
            $svg = preg_replace('/height="\d+"/', '', $svg);
            $svg = str_replace('<svg', '<svg class="' . $class . '"', $svg);
            return $svg;
        }
    }
@endphp

    {{-- Logo dan Nama Aplikasi --}}
    <div class="flex items-center gap-3 px-6 pt-6 mb-10">
        <div class="w-12 h-12 flex items-center justify-center shrink-0">
            {!! $svgLogo !!}
        </div>
        <h1 class="text-white text-xl font-bold tracking-tight">KlikAset</h1>
    </div>

    {{-- Menu User --}}
    <nav class="flex-1 space-y-2 px-4 overflow-y-auto">
        {{-- Dashboard --}}
        <a href="{{ route('my.dashboard') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('my.dashboard') ? 'bg-white/20 shadow-md' : 'hover:bg-white/10' }}">
            {!! getMenuIcon('chart.svg') !!}
            <span class="relative inline-block">
                Dashboard
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('my.dashboard') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        {{-- Pinjaman Aktif --}}
        <a href="{{ route('loans') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('loans') ? 'bg-white/20 shadow-md' : 'hover:bg-white/10' }}">
            {!! getMenuIcon('checklist-minimalistic.svg') !!}
            <span class="relative inline-block">
                Pinjaman Aktif
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('loans') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        {{-- Riwayat --}}
        <a href="{{ route('history') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('history') ? 'bg-white/20 shadow-md' : 'hover:bg-white/10' }}">
            {!! getMenuIcon('clock-circle.svg') !!}
            <span class="relative inline-block">
                Riwayat
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('history') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        {{-- Peringkat --}}
        <a href="{{ route('rank') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('rank') ? 'bg-white/20 shadow-md' : 'hover:bg-white/10' }}">
            {!! getMenuIcon('crown-line.svg') !!}
            <span class="relative inline-block">
                Peringkat
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('rank') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        {{-- Profil Saya --}}
        <a href="{{ route('profile') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('profile') ? 'bg-white/20 shadow-md' : 'hover:bg-white/10' }}">
            {!! getMenuIcon('shield-user.svg') !!}
            <span class="relative inline-block">
                Profil Saya
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('profile') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        <a href="{{ route('home') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('home') ? 'bg-white/20 shadow-md' : 'hover:bg-white/10' }}">
            {!! getMenuIcon('home.svg') !!}
            <span class="relative inline-block">
                Kembali ke beranda
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('home') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>
    </nav>

    {{-- Divider (opsional, seperti admin) --}}
    <div class="mx-4 my-4 h-px bg-white/20"></div>

    {{-- Logout --}}
    <div class="px-4 pb-6">
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="group flex items-center gap-3 px-4 py-3 w-full text-white font-semibold text-sm rounded-full transition-all duration-200 hover:bg-red-500/80 hover:shadow-md">
                {!! getMenuIcon('logout-3.svg') !!}
                <span class="relative inline-block">
                    Logout
                    <span class="absolute left-0 bottom-[-4px] w-0 h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
                </span>
            </button>
        </form>
    </div>
</aside>

{{-- Overlay untuk mobile --}}
<div id="sidebarUserOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="closeSidebarUser()"></div>

<script>
    function openSidebarUser() {
        document.getElementById('sidebarUser').classList.remove('-translate-x-full');
        document.getElementById('sidebarUserOverlay').classList.remove('hidden');
    }
    function closeSidebarUser() {
        document.getElementById('sidebarUser').classList.add('-translate-x-full');
        document.getElementById('sidebarUserOverlay').classList.add('hidden');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const closeBtn = document.getElementById('closeSidebarUserBtn');
        if(closeBtn) closeBtn.addEventListener('click', closeSidebarUser);
    });
</script>
