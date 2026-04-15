<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Aset</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 5px; }
        .date { text-align: center; font-size: 11px; color: #555; margin-bottom: 20px; }
        .filter-info { background: #f3f4f6; padding: 8px; margin-bottom: 15px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #2563eb; color: white; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <h1>Laporan Data Aset</h1>
    <div class="date">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>

    @if($filters['search'] || $filters['kategori'] || $filters['kondisi'])
    <div class="filter-info">
        <strong>Filter yang diterapkan:</strong><br>
        @if($filters['search']) • Pencarian: "{{ $filters['search'] }}"<br> @endif
        @if($filters['kategori']) • Kategori: {{ $filters['kategori'] }}<br> @endif
        @if($filters['kondisi']) • Kondisi: {{ $filters['kondisi'] }}<br> @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Jumlah Total</th>
                <th>Jumlah Tersedia</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $index => $barang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori }}</td>
                <td>{{ ucfirst($barang->kondisi) }}</td>
                <td>{{ $barang->jumlah_total }}</td>
                <td>{{ $barang->jumlah_tersedia }}</td>
                <td>{{ Str::limit($barang->deskripsi, 50) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data aset</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Total {{ $barangs->count() }} aset | Sistem Informasi Aset</div>
</body>
</html>
