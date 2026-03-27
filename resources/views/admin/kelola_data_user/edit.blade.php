{{-- resources/views/admin/kelola_data_user/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit User - KlikAset')

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-sm font-semibold text-gray-700">Edit User</span>
    </div>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-[30px] shadow-sm border border-gray-100 p-6 lg:p-10">
            <h2 class="text-lg lg:text-xl font-bold text-gray-800 mb-6">Edit Data User</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <div class="space-y-5">
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('username') border-red-400 @enderror"/>
                        @error('username')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('email') border-red-400 @enderror"/>
                        @error('email')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition @error('password') border-red-400 @enderror"/>
                        @error('password')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">No Telpon</label>
                        <input type="text" name="no_telpon" value="{{ old('no_telpon', $user->no_telpon) }}" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                    @if(auth()->user()->role === 'super-admin')
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Role <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="role" id="roleSelect" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition @error('role') border-red-400 @enderror">
                                <option value="peminjam" {{ old('role', $user->role) == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            </div>
                        </div>
                        @error('role')<p class="text-red-500 text-xs mt-1 pl-3">{{ $message }}</p>@enderror
                    </div>
                    @endif
                </div>
                <div id="peminjamFields" class="space-y-5">
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">NIPD</label>
                        <input type="text" name="nipd" value="{{ old('nipd', $user->nipd) }}" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent text-sm transition"/>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-medium mb-2 text-sm">Jenis Kelamin</label>
                        <div class="relative">
                            <select name="jenis_kelamin" class="w-full px-5 py-3 border-2 border-gray-300 rounded-[30px] outline-none focus:ring-2 focus:ring-costume-second focus:border-transparent appearance-none bg-white cursor-pointer text-sm transition">
                                <option value="">Pilih</option>
                                <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('users.index') }}" class="flex-1 px-5 py-3 border-2 border-gray-300 rounded-[30px] text-sm font-semibold text-gray-600 hover:bg-gray-50 transition text-center">Batal</a>
                <button type="submit" class="flex-1 bg-costume-primary text-white px-5 py-3 rounded-[30px] font-semibold text-sm hover:bg-blue-700 transition shadow-sm">Simpan Perubahan</button>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        const roleSelect = document.getElementById('roleSelect');
        const peminjamFields = document.getElementById('peminjamFields');
        function toggleFields() {
            if (roleSelect && roleSelect.value === 'admin') {
                peminjamFields.style.display = 'none';
                peminjamFields.querySelectorAll('input, select').forEach(el => el.disabled = true);
            } else {
                peminjamFields.style.display = 'block';
                peminjamFields.querySelectorAll('input, select').forEach(el => el.disabled = false);
            }
        }
        if (roleSelect) {
            roleSelect.addEventListener('change', toggleFields);
            toggleFields();
        }
    </script>
    @endpush
@endsection
