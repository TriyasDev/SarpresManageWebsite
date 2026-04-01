<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Pengembalian Barang - KlikAset</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header.overdue {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
        }
        .header-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1e293b;
            margin-bottom: 20px;
        }
        .message {
            color: #475569;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .deadline-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            margin: 30px 0;
        }
        .deadline-box.overdue {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        .deadline-label {
            color: #ffffff;
            font-size: 14px;
            margin-bottom: 10px;
            opacity: 0.9;
        }
        .deadline-value {
            font-size: 42px;
            font-weight: bold;
            color: #ffffff;
            margin: 10px 0;
        }
        .deadline-date {
            color: #ffffff;
            font-size: 16px;
            margin-top: 10px;
            opacity: 0.9;
        }
        .items-section {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        .items-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .item {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item-name {
            font-weight: 500;
            color: #1e293b;
            font-size: 15px;
        }
        .item-qty {
            background-color: #e0e7ff;
            color: #4f46e5;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning.danger {
            background-color: #fee2e2;
            border-left-color: #ef4444;
        }
        .warning-title {
            font-weight: 600;
            color: #92400e;
            margin-bottom: 8px;
            font-size: 15px;
        }
        .warning.danger .warning-title {
            color: #991b1b;
        }
        .warning p {
            margin: 5px 0;
            color: #92400e;
            font-size: 14px;
            line-height: 1.5;
        }
        .warning.danger p {
            color: #991b1b;
        }
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 0;
            color: #1e40af;
            font-size: 14px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 30px;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }
        .footer p {
            margin: 5px 0;
        }
        .loan-id {
            background-color: #e0e7ff;
            color: #4f46e5;
            padding: 6px 12px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header {{ $reminderType === 'overdue' ? 'overdue' : '' }}">
            <div class="header-icon">{{ $reminderType === 'overdue' ? '🚨' : '⏰' }}</div>
            <h1>{{ $reminderType === 'overdue' ? 'Pengembalian Terlambat!' : 'Reminder Pengembalian' }}</h1>
        </div>

        <div class="content">
            <p class="greeting">Halo, <strong>{{ $peminjaman->user->nama }}</strong></p>

            @if($reminderType === 'overdue')
                <p class="message">
                    Pinjaman Anda sudah <strong>melewati batas waktu pengembalian</strong>. Mohon segera mengembalikan barang-barang yang dipinjam untuk menghindari pengurangan poin lebih lanjut.
                </p>

                <div class="deadline-box overdue">
                    <div class="deadline-label">TERLAMBAT</div>
                    <div class="deadline-value">{{ $daysLate }} Hari</div>
                    <div class="deadline-date">Seharusnya dikembalikan: {{ $peminjaman->tanggal_kembali->format('d F Y') }}</div>
                </div>

                <div class="warning danger">
                    <div class="warning-title">⚠️ PERHATIAN PENTING!</div>
                    <p>• Keterlambatan akan mengurangi poin Anda sebesar <strong>2 poin per hari</strong></p>
                    <p>• Anda telah terlambat <strong>{{ $daysLate }} hari</strong>, potensi pengurangan: <strong>-{{ $daysLate * 2 }} poin</strong></p>
                    <p>• Segera kembalikan barang untuk menghindari denda lebih lanjut!</p>
                </div>
            @else
                <p class="message">
                    Ini adalah pengingat bahwa waktu pengembalian barang pinjaman Anda akan segera berakhir. Harap segera persiapkan barang-barang untuk dikembalikan.
                </p>

                <div class="deadline-box">
                    <div class="deadline-label">SISA WAKTU</div>
                    <div class="deadline-value">{{ $daysRemaining }} Hari</div>
                    <div class="deadline-date">Batas pengembalian: {{ $peminjaman->tanggal_kembali->format('d F Y') }}</div>
                </div>

                @if($daysRemaining <= 1)
                    <div class="warning">
                        <div class="warning-title">⏰ Segera!</div>
                        <p>Waktu pengembalian hampir habis! Pastikan barang dikembalikan tepat waktu untuk mendapatkan bonus poin.</p>
                    </div>
                @else
                    <div class="info-box">
                        <p>💡 <strong>Tips:</strong> Kembalikan barang tepat waktu dan dalam kondisi baik untuk mendapatkan bonus +15 poin!</p>
                    </div>
                @endif
            @endif

            <div class="items-section">
                <div class="items-title">📦 Daftar Barang yang Dipinjam</div>
                @foreach($peminjaman->detailPeminjaman as $detail)
                    <div class="item">
                        <span class="item-name">{{ $detail->barang->nama_barang }}</span>
                        <span class="item-qty">{{ $detail->jumlah }} unit</span>
                    </div>
                @endforeach
            </div>

            <div class="info-box">
                <p><strong>ID Peminjaman:</strong> <span class="loan-id">#{{ str_pad($peminjaman->id_peminjaman, 5, '0', STR_PAD_LEFT) }}</span></p>
                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d F Y') }}</p>
                <p><strong>Batas Kembali:</strong> {{ $peminjaman->tanggal_kembali->format('d F Y, H:i') }}</p>
            </div>

            @if($reminderType !== 'overdue')
                <p class="message">
                    <strong>Poin Reward:</strong> Kembalikan barang tepat waktu dan dalam kondisi baik untuk mendapatkan total <strong>+15 poin</strong>!
                </p>
            @endif

            <p class="message">
                Jika ada pertanyaan atau kendala dalam pengembalian, silakan hubungi admin kami.
            </p>
        </div>

        <div class="footer">
            <p><strong>KlikAset</strong> - Sistem Manajemen Aset Sekolah</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
            <p style="margin-top: 15px; color: #94a3b8;">© {{ date('Y') }} KlikAset. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
