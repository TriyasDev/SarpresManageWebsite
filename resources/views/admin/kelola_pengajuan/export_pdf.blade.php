<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan Peminjaman</title>
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
    <h1>Laporan Pengajuan Peminjaman Aset</h1>
    <div class="date">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>

    @php
        $hasFilter = !empty($filters['search']) || !empty($filters['status']) || !empty($filters['start_date']) || !empty($filters['end_date']);
    @endphp

    @if($hasFilter)
    <div class="filter-info">
        <strong>Filter yang diterapkan:</strong><br>
        @if(!empty($filters['search'])) • Pencarian: "{{ $filters['search'] }}"<br> @endif
        @if(!empty($filters['status'])) • Status: {{ $filters['status'] }}<br> @endif
        @if(!empty($filters['start_date'])) • Dari tanggal: {{ $filters['start_date'] }}<br> @endif
        @if(!empty($filters['end_date'])) • Sampai tanggal: {{ $filters['end_date'] }}<br> @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>NIPD</th>
                <th>Barang</th>
                <th>Jml</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali (Jadwal)</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $index => $p)
            @php
                $firstDetail = $p->firstDetail;
                $namaBarang = $firstDetail?->barang?->nama_barang ?? '-';
                $jumlah = $firstDetail?->jumlah ?? 0;
                $totalItems = $p->detailPeminjaman->count();
                if ($totalItems > 1) {
                    $namaBarang .= " (+" . ($totalItems - 1) . ")";
                }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->user?->username ?? '-' }}</td>
                <td>{{ $p->user?->nipd ?? '-' }}</td>
                <td>{{ $namaBarang }}</td>
                <td>{{ $jumlah }}</td>
                <td>{{ $p->tanggal_pinjam?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $p->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $p->label_status }}</td>
                <td>{{ Str::limit($p->catatan, 40) ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center;">Tidak ada data pengajuan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">Total {{ $pengajuans->count() }} pengajuan | Sistem Informasi Aset</div>
</body>
</html>
