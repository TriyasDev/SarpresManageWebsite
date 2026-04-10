<aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300
           ease-in-out z-40 w-64 bg-costume-primary flex flex-col h-screen overflow-y-auto shadow-xl">
    <button id="closeSidebarBtn"
        class="lg:hidden absolute top-4 right-4 text-white hover:bg-white/20 p-2 rounded-full transition-colors duration-200"
        aria-label="Close Sidebar">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    @php
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
    @endphp

    {{-- Logo dan Nama Aplikasi --}}
    <div class="flex items-center gap-3 px-6 pt-6 mb-10">
        <div class="w-12 h-12 flex items-center justify-center shrink-0">
            {!! $svgLogo !!}
        </div>
        <h1 class="text-white text-xl font-bold tracking-tight">KlikAset</h1>
    </div>

    {{-- Menu Navigasi --}}
    <nav class="flex-1 space-y-2 px-4 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-costume-second shadow-md' : 'hover:bg-white/10' }}">
            <x-icon-chart class="w-10 h-10 shrink-0 text-white" />
            <span class="relative inline-block">
                Dashboard
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('dashboard') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        <a href="{{ route('assets.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('assets.*') ? 'bg-costume-second shadow-md' : 'hover:bg-white/10' }}">
            <x-icon-album class="w-10 h-10 shrink-0 text-white" />
            <span class="relative inline-block">
                Kelola Aset
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('assets.*') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        <a href="{{ route('approvals.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('approvals.*') ? 'bg-costume-second shadow-md' : 'hover:bg-white/10' }}">
            <x-icon-inbox-unread class="w-10 h-10 shrink-0 text-white" />
            <span class="relative inline-block">
                Kelola Pengajuan
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('approvals.*') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        <a href="{{ route('reports.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-costume-second shadow-md' : 'hover:bg-white/10' }}">
            <x-icon-notebook class="w-10 h-10 shrink-0 text-white" />
            <span class="relative inline-block">
                Kelola Laporan
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('reports.*') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

       <a href="{{ route('users.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-costume-second shadow-md' : 'hover:bg-white/10' }}">
            <x-icon-shield-user class="w-10 h-10 shrink-0 text-white" />
            <span class="relative inline-block">
                Kelola Data User
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('users.*') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>

        <a href="{{ route('index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-full text-white font-semibold text-sm transition-all duration-200 {{ request()->routeIs('home*') ? 'bg-costume-second shadow-md' : 'hover:bg-white/10' }}">
            <x-icon-home class="w-10 h-10 shrink-0 text-white" />
            <span class="relative inline-block">
                Kembali Ke  Home
                <span class="absolute left-0 bottom-[-4px] {{ request()->routeIs('home*') ? 'w-12' : 'w-0' }} h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>
    </nav>

    {{-- Divider --}}
    <div class="mx-4 my-4 h-px bg-white/20"></div>

    {{-- Logout --}}
    <div class="px-4 pb-6">
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="group flex items-center gap-3 px-4 py-3 w-full text-white font-semibold text-sm rounded-full transition-all duration-200 hover:bg-red-500/80 hover:shadow-md">
                <x-icon-logout-3 class="w-10 h-10 shrink-0 text-white" />
                <span class="relative inline-block">
                    Logout
                    <span class="absolute left-0 bottom-[-4px] w-0 h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
                </span>
            </button>
        </form>
    </div>
</aside>
