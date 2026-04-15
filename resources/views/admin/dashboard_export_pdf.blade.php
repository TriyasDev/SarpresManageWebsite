<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - {{ $tahun }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
        }
        .stats-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px;
            flex: 1;
            text-align: center;
        }
        .card .label {
            font-size: 10px;
            color: #64748b;
        }
        .card .value {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
        }
        .footer {
            text-align: right;
            font-size: 9px;
            color: #94a3b8;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h1>Dashboard KlikAset</h1>
    <div class="subtitle">Tahun {{ $tahun }} · Dicetak: {{ now()->format('d/m/Y H:i') }}</div>

    {{-- Stat Cards --}}
    <div class="stats-cards">
        <div class="card">
            <div class="label">Total Aset</div>
            <div class="value">{{ number_format($totalAset) }}</div>
        </div>
        <div class="card">
            <div class="label">Pengajuan Baru</div>
            <div class="value">{{ number_format($pengajuanBaru) }}</div>
        </div>
        <div class="card">
            <div class="label">Sedang Dipinjam</div>
            <div class="value">{{ number_format($sedangDipinjam) }}</div>
        </div>
        <div class="card">
            <div class="label">Peminjaman Bulan Ini</div>
            <div class="value">{{ number_format($peminjamanBulanIni) }}</div>
        </div>
    </div>

    {{-- Bar Chart Data --}}
    <h3>📊 Peminjaman per Bulan (Total: {{ array_sum($barChartData) }})</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Peminjaman</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalBar = array_sum($barChartData); @endphp
            @foreach($barChartData as $i => $val)
            <tr>
                <td>{{ $months[$i] }}</td>
                <td>{{ number_format($val) }}</td>
                <td>{{ $totalBar > 0 ? round(($val / $totalBar) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Donut Chart Data --}}
    <h3>🥧 Jenis Barang Sering Dipinjam</h3>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah Dipinjam</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDonut = array_sum($donutData); @endphp
            @foreach($donutLabels as $i => $label)
            <tr>
                <td>{{ $label }}</td>
                <td>{{ number_format($donutData[$i]) }}</td>
                <td>{{ $totalDonut > 0 ? round(($donutData[$i] / $totalDonut) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        $rows[] = ['Dicetak oleh', auth()->user()->nama ?? auth()->user()->username];
        $rows[] = ['Tanggal cetak', now()->format('d/m/Y H:i')];
    </div>
</body>
</html>
