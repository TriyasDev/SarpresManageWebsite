{{-- Hapus Teks Ini Jika Sudah Jadi --}}

<aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 w-64 bg-costume-primary flex flex-col h-screen overflow-y-auto">
    <!-- Close Button (Mobile Only) -->
    <button id="closeSidebarBtn" class="lg:hidden absolute top-4 right-4 text-white hover:bg-blue-700 p-2 rounded-[30px] transition-colors duration-200" aria-label="Close Sidebar">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <!-- Logo Section -->
    <div class="flex items-center gap-3 mb-15 px-6 pt-6">
        <div class="w-13 h-13 rounded-full flex items-center justify-center overflow-hidden shrink-0">
            <x-icon-logo-klikaset/>
        </div>
        <h1 class="text-white text-lg font-bold tracking-tight">KlikAset</h1>
    </div>

<!-- Admin Profile Section -->
<div class="mx-4 mb-6">
    <div class="bg-linear-to-r rounded-[30px] p-3.5 shadow-sm">
        <div class="flex items-center gap-2.5">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0">
                <span class="text-costume-primary font-bold text-sm">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs opacity-80">Halo,</p>
                <p class="text-white font-bold text-sm truncate">{{ Auth::user()->name ?? 'Admin 01' }}</p>
            </div>
        </div>
    </div>
</div>

    <!-- Navigation Menu -->
    <nav class="flex-1 space-y-1.5 px-4 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-[30px] text-white font-bold text-[0.96rem] transition-all duration-200 @if(request()->is('admin/dashboard')) bg-costume-second @else hover:bg-costume-second @endif">
            <x-icon-chart class="w-10 h-10 shrink-0 text-white"/>
            <span class="relative inline-block">
                Dashboard
                <span class="absolute left-0 bottom-[-4px] @if(request()->is('admin/dashboard')) w-12 @else w-0 @endif h-[2px] bg-white rounded-full transition-all duration-300 ease-in-out group-hover:w-12"></span>
            </span>
        </a>

        <!-- Kelola Aset -->
        <a href="{{ route('admin.kelola_aset') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-[30px] text-white font-bold text-[0.96rem] transition-all duration-200 @if(request()->is('admin/kelola_aset*')) bg-costume-second @else hover:bg-costume-second @endif">
>>>>>>> 0c85189 (Backend v2 "Revisi route dan pembuatan controller admin")
            <x-icon-album class="w-10 h-10 shrink-0 text-white"/>
            <span class="relative inline-block">
                Kelola Aset
                <span class="absolute left-0 bottom-[-4px] @if(request()->is('admin/kelola_aset/index')) w-12 @else w-0 @endif h-[3px] bg-white rounded-full transition-all duration-300 ease-in-out group-hover:w-12"></span>
            </span>
        </a>

        <!-- Kelola Pengajuan -->
        <a href="{{ route('admin.kelola_pengajuan') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-[30px] text-white font-bold text-[0.96rem] transition-all duration-200 @if(request()->is('admin/kelola_pengajuan*')) bg-costume-second @else hover:bg-costume-second @endif">
            <x-icon-inbox-unread class="w-10 h-10 shrink-0 text-white"/>
            <span class="relative inline-block">
                Kelola Pengajuan
                <span class="absolute left-0 bottom-[-4px] @if(request()->is('admin/kelola_pengajuan*')) w-12 @else w-0 @endif h-[2px] bg-white rounded-full transition-all duration-300 ease-in-out group-hover:w-12"></span>
            </span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('admin.kelola_laporan') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-[30px] text-white font-bold text-[0.96rem] transition-all duration-200 @if(request()->is('admin/laporan*')) bg-costume-second @else hover:bg-costume-second @endif">
            <x-icon-notebook class="w-10 h-10 shrink-0 text-white"/>
            <span class="relative inline-block">
                Laporan
                <span class="absolute left-0 bottom-[-4px] @if(request()->is('admin/laporan*')) w-12 @else w-0 @endif h-[3px] bg-white rounded-full transition-all duration-300 ease-in-out group-hover:w-12"></span>
            </span>
        </a>

        <!-- Kelola Data User -->
        <a href="{{ route('admin.kelola_data_user') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-[30px] text-white font-bold text-[0.96rem] transition-all duration-200 @if(request()->is('admin/kelola_data_user*')) bg-costume-second @else hover:bg-costume-second @endif">
            <x-icon-shield-user class="w-10 h-10 shrink-0 text-white"/>
            <span class="relative inline-block">
                Kelola Data User
                <span class="absolute left-0 bottom-[-4px] @if(request()->is('admin/kelola_data_user*')) w-12 @else w-0 @endif h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </a>
    </nav>

<!-- Logout Button -->
<div class="px-4 pb-6 mt-auto pt-4">
    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <button type="submit" class="group flex items-center gap-3 px-4 py-2.5 text-white font-bold rounded-[30px] transition-all duration-200 hover:bg-red-500 text-[0.96rem] w-full text-left">
            <x-icon-logout-3 class="w-10 h-10 shrink-0 text-white"/>
            <span class="relative inline-block">
                Logout
                <span class="absolute left-0 bottom-[-4px] w-0 h-[2px] bg-white rounded-full transition-all duration-300 group-hover:w-12"></span>
            </span>
        </button>
    </form>
</div>
</aside>
