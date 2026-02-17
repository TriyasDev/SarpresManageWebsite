<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - KlikAset</title>
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
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
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
            margin-bottom: 30px;
        }
        .code-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .code-label {
            color: #ffffff;
            font-size: 14px;
            margin-top: 10px;
            opacity: 0.9;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning p {
            margin: 0;
            color: #92400e;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 KlikAset</h1>
        </div>
        
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $username }}</strong></p>
            
            <p class="message">
                Kami menerima permintaan untuk mereset password akun Anda. Gunakan kode verifikasi di bawah ini untuk melanjutkan proses reset password:
            </p>
            
            <div class="code-container">
                <div class="code">{{ $code }}</div>
                <div class="code-label">Kode Verifikasi</div>
            </div>
            
            <div class="warning">
                <p><strong>⏰ Penting:</strong> Kode ini hanya berlaku selama <strong>15 menit</strong>. Jangan bagikan kode ini kepada siapapun!</p>
            </div>
            
            <p class="message">
                Jika Anda tidak melakukan permintaan reset password, abaikan email ini. Akun Anda tetap aman.
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
