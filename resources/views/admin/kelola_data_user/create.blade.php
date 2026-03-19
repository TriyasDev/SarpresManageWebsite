@extends('layouts.admin')

@section('title', 'Tambah User Baru - KlikAset')

@section('content')

    {{-- Breadcrumb / Back --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-sm font-semibold text-gray-700">Tambah User Baru</span>
    </div>

    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10">
        <h2 class="text-lg lg:text-xl font-bold text-gray-800 mb-6">Data User Baru</h2>

        <form action="{{ route('users..store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                {{-- Kolom Kiri --}}
                <div class="space-y-5">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan nama lengkap"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('username') border-red-400 @enderror" />
                        @error('username') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('email') border-red-400 @enderror" />
                        @error('email') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- No Telepon --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">No Telepon</label>
                        <input type="text" name="no_telpon" value="{{ old('no_telpon') }}" placeholder="Masukkan no telepon"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('no_telpon') border-red-400 @enderror" />
                        @error('no_telpon') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('password') border-red-400 @enderror" />
                            <button type="button" id="togglePassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition focus:outline-none">
                                <x-icon-eye-closed id="eyeIcon" class="w-5 h-5" />
                                <x-icon-eye id="eyeSlashIcon" class="w-5 h-5 hidden" />
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIPD --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">NIPD <span class="text-red-500">*</span></label>
                        <input type="text" name="nipd" value="{{ old('nipd') }}" placeholder="Masukkan NIPD"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('nipd') border-red-400 @enderror" />
                        @error('nipd') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Alamat <span class="text-red-500">*</span></label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('alamat') border-red-400 @enderror" />
                        @error('alamat') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="space-y-5">

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('tanggal_lahir') border-red-400 @enderror" />
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="jenis_kelamin"
                                class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('jenis_kelamin') border-red-400 @enderror">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="laki-laki"  {{ old('jenis_kelamin') == 'laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan"  {{ old('jenis_kelamin') == 'perempuan'  ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                                <x-icon-alt-arrow-down class="fill-current h-6 w-6" />
                            </div>
                        </div>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rank (Read-only, otomatis Reliant) --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Rank</label>
                        <input type="text" value="Reliant" readonly
                            class="w-full px-5 py-3 border-2 border-gray-200 rounded-[30px] bg-gray-50 text-gray-500 text-sm cursor-not-allowed" />
                        <p class="text-xs text-gray-400 mt-1 pl-3">Rank ditentukan otomatis saat user pertama kali dibuat.</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('users.index') }}"
                           class="flex-1 px-5 py-3 border-2 border-gray-300 rounded-[30px] text-sm font-semibold text-gray-600 hover:bg-gray-50 transition text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput  = document.getElementById('password');
        const eyeIcon        = document.getElementById('eyeIcon');
        const eyeSlashIcon   = document.getElementById('eyeSlashIcon');

        togglePassword?.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>
@endpush
