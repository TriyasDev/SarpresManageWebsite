<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #2563eb; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Peminjaman Aset</h2>
        <p>Tanggal cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Laporan</th>
                <th>Nama Peminjam</th>
                <th>Email</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Jenis Laporan</th>
                <th>Kondisi Barang</th>
                <th>Tgl Dipinjam</th>
                <th>Tgl Dikembalikan</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $index => $laporan)
                @php
                    $peminjaman = $laporan->peminjaman;
                    $user = $peminjaman?->user;
                    $barang = $peminjaman?->detailPeminjaman->first()?->barang;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $laporan->id_laporan }}</td>
                    <td>{{ $user?->nama ?? $user?->username ?? '-' }}</td>
                    <td>{{ $user?->email ?? '-' }}</td>
                    <td>{{ $barang?->nama_barang ?? '-' }}</td>
                    <td>{{ $barang?->kategori ?? '-' }}</td>
                    <td>{{ $laporan->label_jenis }}</td>
                    <td>{{ $laporan->label_kondisi }}</td>
                    <td>{{ $laporan->tanggal_dipinjam?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $laporan->tanggal_dikembalikan?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $laporan->admin?->nama ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->nama ?? auth()->user()->username }}</p>
    </div>
</body>
</html>
