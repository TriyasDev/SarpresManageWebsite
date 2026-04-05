@extends('layouts.app')
@section('title', 'Form Peminjaman - KlikAset SMK BBC')

@push('styles')
<style>
    footer {
        display: none !important;
    }
</style>
@endpush

@section('content')
<section class="relative w-full min-h-screen py-24 overflow-hidden bg-gradient-to-br from-slate-50 via-white to-blue-50/30">
    {{-- Background Blobs (seperti home) --}}
    <div class="absolute top-20 right-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-20 left-10 w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
            {{-- Header dengan gradient seperti hero home --}}
            <div class="bg-gradient-to-r from-costume-primary to-costume-second px-8 py-6">
                <h1 class="text-2xl font-bold text-white">Form Peminjaman Aset</h1>
                <p class="text-blue-100 text-sm mt-1">Lengkapi data di bawah ini untuk mengajukan peminjaman</p>
            </div>

            <form action="{{ route('borrow.store') }}" method="POST" class="p-8">
                @csrf

                @if($barang)
                    <input type="hidden" name="barang_id" value="{{ $barang->id_barang }}">
                @endif

                {{-- Data User (readonly) dengan gaya seperti home --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ $user->nama ?? $user->username }}" readonly
                            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Tier / Poin</label>
                        <input type="text" value="{{ $user->tier }} ({{ $user->points }} poin)" readonly
                            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas</label>
                        <input type="text" value="{{ $user->kelas ?? '-' }}" readonly
                            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">No. HP / WhatsApp</label>
                        <input type="text" value="{{ $user->no_telpon ?? '-' }}" readonly
                            class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-600">
                    </div>
                </div>

                {{-- Preview Tanggal Pinjam (otomatis hari ini) --}}
                <div class="mb-6 p-4 bg-blue-50/50 rounded-xl border border-blue-200">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-costume-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Tanggal Pinjam</p>
                            <p class="text-lg font-bold text-costume-primary">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                            <p class="text-xs text-slate-500">Pinjaman akan mulai hari ini setelah disetujui admin.</p>
                        </div>
                    </div>
                </div>

                {{-- Pilih Aset --}}
                @if(!$barang)
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Aset <span class="text-red-500">*</span></label>
                    <select name="barang_id" required
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-costume-primary focus:ring-2 focus:ring-blue-200 transition">
                        <option value="">-- Pilih Aset --</option>
                        @foreach($barangs as $item)
                            <option value="{{ $item->id_barang }}" {{ old('barang_id') == $item->id_barang ? 'selected' : '' }}>
                                {{ $item->nama_barang }} ({{ $item->jumlah_tersedia }} tersedia)
                            </option>
                        @endforeach
                    </select>
                </div>
                @else
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
                            <p class="text-xs text-slate-500">Tersedia: {{ $barang->jumlah_tersedia }} unit</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="barang_id" value="{{ $barang->id_barang }}">
                @endif

                {{-- Jumlah dengan info sisa kuota --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah', 1) }}" required
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-costume-primary focus:ring-2 focus:ring-blue-200 transition">
                    @php
                        $activeCount = $activeItemsCount ?? 0;
                        $maxItems = $user->max_items;
                        $sisa = $maxItems - $activeCount;
                    @endphp
                    <p class="text-xs text-slate-500 mt-1">
                        Batas maksimal barang yang bisa dipinjam: <strong class="text-costume-primary">{{ $maxItems }}</strong> item<br>
                        Anda sedang meminjam: <strong>{{ $activeCount }}</strong> item aktif · Sisa kuota: <strong>{{ $sisa }}</strong>
                    </p>
                </div>

                {{-- Tanggal Kembali dengan batas max days --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kembali <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-costume-primary focus:ring-2 focus:ring-blue-200 transition"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        max="{{ date('Y-m-d', strtotime('+'.$user->max_days.' days')) }}">
                    <p class="text-xs text-slate-500 mt-1">
                        Maksimal durasi pinjam untuk tier <strong>{{ $user->tier }}</strong> adalah <strong>{{ $user->max_days }} hari</strong>.
                    </p>
                </div>

                {{-- Keperluan --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Keperluan</label>
                    <textarea name="keperluan" rows="3"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 focus:border-costume-primary focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="Jelaskan keperluan peminjaman...">{{ old('keperluan') }}</textarea>
                </div>

                {{-- Tombol aksi --}}
                <div class="flex gap-4">
                    <a href="{{ route('home') }}"
                        class="flex-1 text-center py-3 rounded-xl border-2 border-slate-200 font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-[2] bg-costume-primary hover:bg-costume-primary/90 text-white font-bold py-3 rounded-xl shadow-md shadow-blue-500/25 hover:shadow-lg transition-all">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
            {{-- Tampilkan error umum --}}
@if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong class="text-red-800">Gagal mengajukan peminjaman:</strong>
                <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

{{-- Tampilkan pesan sukses jika ada (misal dari redirect) --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    </div>
@endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Set min dan max tanggal kembali sesuai tier
    const maxDays = {{ $user->max_days }};
    const today = new Date();
    const minDate = new Date(today);
    minDate.setDate(today.getDate() + 1);
    const maxDate = new Date(today);
    maxDate.setDate(today.getDate() + maxDays);

    const formatDate = (d) => d.toISOString().split('T')[0];
    const dateInput = document.querySelector('input[name="tanggal_kembali"]');
    if (dateInput) {
        dateInput.min = formatDate(minDate);
        dateInput.max = formatDate(maxDate);
    }
</script>
@endpush
