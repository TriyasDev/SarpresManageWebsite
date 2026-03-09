@extends('layouts.admin')

@section('title', 'Kelola Data User - KlikAset')

@section('content')

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-4 px-5 py-3 bg-green-100 text-green-700 rounded-[30px] border border-green-200 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- SECTION 1: Form Input User --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10 mb-6">
        <h2 class="text-lg lg:text-xl font-bold text-gray-800 mb-6">Tambah User Baru</h2>

        <form action="{{ route('admin.kelola-data-user.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                {{-- Kolom Kiri --}}
                <div class="space-y-5">

                    {{-- Username --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Nama Lengkap:</label>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan nama lengkap"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('username') border-red-400 @enderror" />
                        @error('username') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- No Telepon --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">No Telepon:</label>
                        <input type="text" name="no_telpon" value="{{ old('no_telpon') }}" placeholder="Masukkan no telepon"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('no_telpon') border-red-400 @enderror" />
                        @error('no_telpon') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Email:</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('email') border-red-400 @enderror" />
                        @error('email') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Password:</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Masukkan password"
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
                        <label class="block text-gray-800 font-medium mb-2 text-sm">NIPD:</label>
                        <input type="text" name="nipd" value="{{ old('nipd') }}" placeholder="Masukkan NIPD"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('nipd') border-red-400 @enderror" />
                        @error('nipd') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Alamat:</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('alamat') border-red-400 @enderror" />
                        @error('alamat') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="space-y-5">

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('tanggal_lahir') border-red-400 @enderror" />
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Jenis Kelamin:</label>
                        <div class="relative">
                            <select name="jenis_kelamin"
                                class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('jenis_kelamin') border-red-400 @enderror">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                                <x-icon-alt-arrow-down class="fill-current h-6 w-6" />
                            </div>
                        </div>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rank (Read-only) --}}
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Rank:</label>
                        <input type="text" value="Reliant" readonly
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] bg-gray-50 text-gray-600 text-sm cursor-not-allowed" />
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="pt-7">
                        <button type="submit"
                            class="w-full bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 active:bg-blue-800 transition">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- SECTION 2: Search Bar --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-5 mb-6">
        <form action="{{ route('admin.kelola-data-user.index') }}" method="GET">
            <div class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama User atau NIPD ..."
                    class="w-full px-5 py-3 pr-12 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition" />
                <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2">
                    <x-icon-magnifer class="w-5 h-5 text-gray-400" />
                </button>
            </div>
        </form>
    </div>

    {{-- SECTION 3: Tabel Data User --}}
    <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/80">
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Nama Lengkap</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">NIPD</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Alamat</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Tanggal Lahir</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Rank</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Jenis Kelamin</th>
                        <th class="p-4 text-center font-semibold text-xs lg:text-sm text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                            <td class="p-4">
                                <p class="font-medium text-center text-sm">{{ $user->username }}</p>
                                <p class="text-xs text-gray-500 text-center">{{ $user->email }}</p>
                            </td>
                            <td class="p-4 text-center text-sm">{{ $user->nipd ?? '-' }}</td>
                            <td class="p-4 text-center text-xs text-gray-600">{{ $user->alamat ?? '-' }}</td>
                            <td class="p-4 text-center text-sm">
                                {{ $user->tanggal_lahir ? $user->tanggal_lahir->format('d M Y') : '-' }}
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center">
                                    <span
                                        class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-[30px] border border-blue-200 shadow-sm">
                                        {{ $user->rank ?? 'Reliant' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4 text-center text-sm capitalize">{{ $user->jenis_kelamin ?? '-' }}</td>
                            <td class="p-4">
                                <div class="flex gap-2 justify-center">
                                    {{-- Tombol Edit - trigger modal --}}
                                    <button onclick="openEditModal(
                                                    {{ $user->id_user }},
                                                    '{{ addslashes($user->username) }}',
                                                    '{{ addslashes($user->email) }}',
                                                    '{{ addslashes($user->no_telpon ?? '') }}',
                                                    '{{ addslashes($user->nipd ?? '') }}',
                                                    '{{ addslashes($user->alamat ?? '') }}',
                                                    '{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '' }}',
                                                    '{{ $user->jenis_kelamin ?? '' }}'
                                                )"
                                        class="px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-[30px] border border-yellow-200 shadow-sm hover:bg-yellow-200 transition">
                                        Edit
                                    </button>

                                    {{-- Form Hapus --}}
                                    <form action="{{ route('admin.kelola-data-user.destroy', $user->id_user) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-[30px] border border-red-200 shadow-sm hover:bg-red-200 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 text-sm">
                                Belum ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 bg-white gap-4">
            <p class="text-xs lg:text-sm text-gray-600">
                Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} user dari {{ $users->total() }}
            </p>
            <div class="flex items-center gap-2 flex-wrap justify-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL EDIT USER --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded-[30px] p-8 w-full max-w-lg mx-4 shadow-xl">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Edit User</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">Nama Lengkap:</label>
                        <input type="text" name="username" id="edit_username"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">Email:</label>
                        <input type="email" name="email" id="edit_email"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">No Telepon:</label>
                        <input type="text" name="no_telpon" id="edit_no_telpon"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">Password Baru (kosongkan jika tidak
                            diubah):</label>
                        <input type="password" name="password"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">NIPD:</label>
                        <input type="text" name="nipd" id="edit_nipd"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">Alamat:</label>
                        <input type="text" name="alamat" id="edit_alamat"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm" />
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-1 text-sm">Jenis Kelamin:</label>
                        <select name="jenis_kelamin" id="edit_jenis_kelamin"
                            class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second text-sm bg-white">
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 px-5 py-3 border-2 border-gray-300 rounded-[30px] text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        togglePassword?.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });

        // Modal Edit
        function openEditModal(id, username, email, no_telpon, nipd, alamat, tanggalLahir, jenisKelamin) {
            document.getElementById('editForm').action = `/admin/kelola-data-user/${id}`;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_no_telpon').value = no_telpon;
            document.getElementById('edit_nipd').value = nipd;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_tanggal_lahir').value = tanggalLahir;
            document.getElementById('edit_jenis_kelamin').value = jenisKelamin;

            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Tutup modal kalau klik backdrop
        document.getElementById('editModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeEditModal();
        });
    </script>
@endpush