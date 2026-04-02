@extends('layouts.app')
@section('title', 'Peringkat - KlikAset')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Peringkat Peminjam</h1>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Poin</th>
                    <th class="px-4 py-2">Total Pinjam</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rankings as $index => $rank)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ $rankings->firstItem() + $index }}</td>
                        <td class="px-4 py-2">{{ $rank->nama ?? $rank->username }}</td>
                        <td class="px-4 py-2">{{ number_format($rank->points) }}</td>
                        <td class="px-4 py-2">{{ $rank->total_borrowed }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $rankings->links() }}
</div>
@endsection
