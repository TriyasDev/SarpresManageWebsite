@extends('layouts.app')
@section('title', 'Sarana & Prasarana - KlikAset')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Sarana & Prasarana</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($barangs as $barang)
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-semibold">{{ $barang->nama_barang }}</h3>
                <p class="text-sm text-gray-600">Kategori: {{ $barang->kategori }}</p>
                <p class="text-sm text-gray-600">Tersedia: {{ $barang->jumlah_tersedia }} / {{ $barang->jumlah_total }}</p>
                <a href="{{ route('borrow', $barang->id_barang) }}" class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded">Pinjam</a>
            </div>
        @empty
            <p class="text-gray-500">Belum ada sarpras tersedia</p>
        @endforelse
    </div>
</div>
@endsection
