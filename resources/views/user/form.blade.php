@extends('layouts.app')
@section('title', 'Form Peminjaman - KlikAset SMK BBC')
@section('content')

<section class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <h1 class="text-2xl font-bold text-white">Form Peminjaman Aset</h1>
                <p class="text-blue-100 text-sm mt-1">Lengkapi data di bawah ini untuk mengajukan peminjaman</p>
            </div>

            <form action="{{ route('borrow.store') }}" method="POST" class="p-8">
                @csrf

                {{-- Hidden field for barang_id if specific asset selected --}}
                @if($barang)
                    <input type="hidden" name="barang_id" value="{{ $barang->id_barang }}">
                @endif

{{-- User Data (pre-filled, read-only) --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
        <input type="text" value="{{ $user->nama ?? $user->username }}" readonly
            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas</label>
        <input type="text" value="{{ $user->kelas ?? '-' }}" readonly
            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">NIPD</label>
        <input type="text" value="{{ $user->nipd ?? '-' }}" readonly
            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
    </div>
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">No. HP / WhatsApp</label>
        <input type="text" value="{{ $user->no_telpon ?? '-' }}" readonly
            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
    </div>
</div>

                {{-- Asset Selection --}}
                @if(!$barang)
                    {{-- No specific asset chosen – show dropdown --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Aset <span class="text-red-500">*</span></label>
                        <select name="barang_id" required
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <option value="">-- Pilih Aset --</option>
                            @foreach($barangs as $item)
                                <option value="{{ $item->id_barang }}" {{ old('barang_id') == $item->id_barang ? 'selected' : '' }}>
                                    {{ $item->nama_barang }} ({{ $item->jumlah_tersedia }} tersedia)
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    {{-- Specific asset – show card info --}}
                    <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-200 shrink-0">
                                @if($barang->foto && $barang->foto != 'default.jpg')
                                    <img src="{{ asset('storage/'.$barang->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $barang->nama_barang }}</h3>
                                <p class="text-sm text-slate-600">{{ $barang->kategori }} · {{ $barang->kondisi }}</p>
                                <p class="text-xs text-slate-500 mt-1">Tersedia: {{ $barang->jumlah_tersedia }} unit</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="barang_id" value="{{ $barang->id_barang }}">
                @endif

                {{-- Quantity --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    @error('jumlah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                        @error('tanggal_pinjam')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kembali <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required
                            class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                        @error('tanggal_kembali')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Keperluan (catatan) --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keperluan</label>
                    <textarea name="keperluan" rows="3"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="Jelaskan keperluan peminjaman...">{{ old('keperluan') }}</textarea>
                    @error('keperluan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <a href="{{ route('home') }}"
                        class="flex-1 text-center py-3 rounded-xl border-2 border-slate-200 font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-md hover:shadow-lg transition-all">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Optional: set date constraints to avoid past dates
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="tanggal_pinjam"]').min = today;
    document.querySelector('input[name="tanggal_kembali"]').min = today;

    document.querySelector('input[name="tanggal_pinjam"]').addEventListener('change', function() {
        document.querySelector('input[name="tanggal_kembali"]').min = this.value;
    });
</script>
@endpush
