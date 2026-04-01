<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use App\Mail\ReturnReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestReturnReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test-return-reminder {loan_id? : ID Peminjaman (opsional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing email reminder pengembalian barang ke Mailtrap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Testing Email Reminder Pengembalian Barang');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        // Cek konfigurasi mail
        $this->checkMailConfig();

        $loanId = $this->argument('loan_id');

        if ($loanId) {
            // Test dengan ID spesifik
            $this->testSpecificLoan($loanId);
        } else {
            // Test dengan peminjaman yang ada
            $this->testAvailableLoans();
        }
    }

    /**
     * Check mail configuration
     */
    private function checkMailConfig()
    {
        $this->info('📧 Konfigurasi Email:');
        $this->line("   MAIL_MAILER: " . config('mail.default'));
        $this->line("   MAIL_HOST: " . config('mail.mailers.smtp.host'));
        $this->line("   MAIL_PORT: " . config('mail.mailers.smtp.port'));
        $this->line("   MAIL_FROM: " . config('mail.from.address'));
        $this->newLine();
    }

    /**
     * Test dengan peminjaman spesifik
     */
    private function testSpecificLoan($loanId)
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.barang'])
            ->find($loanId);

        if (!$peminjaman) {
            $this->error("❌ Peminjaman dengan ID {$loanId} tidak ditemukan!");
            return;
        }

        $this->sendTestEmail($peminjaman);
    }

    /**
     * Test dengan peminjaman yang tersedia
     */
    private function testAvailableLoans()
    {
        // Cari peminjaman yang sedang dipinjam
        $loans = Peminjaman::with(['user', 'detailPeminjaman.barang'])
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        if ($loans->isEmpty()) {
            $this->warn('⚠️  Tidak ada peminjaman dengan status "dipinjam"');
            $this->newLine();

            // Coba tampilkan semua peminjaman
            $allLoans = Peminjaman::with(['user', 'detailPeminjaman.barang'])
                ->latest()
                ->take(10)
                ->get();

            if ($allLoans->isEmpty()) {
                $this->error('❌ Tidak ada data peminjaman sama sekali!');
                $this->line('   Buat data peminjaman terlebih dahulu.');
                return;
            }

            $this->info('📋 Menampilkan 10 peminjaman terakhir:');
            $this->newLine();

            $tableData = $allLoans->map(function ($loan) {
                $daysRemaining = $loan->tanggal_kembali
                    ? now()->diffInDays($loan->tanggal_kembali, false)
                    : '-';

                return [
                    $loan->id_peminjaman,
                    $loan->user->nama ?? 'N/A',
                    $loan->label_status,
                    $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '-',
                    is_numeric($daysRemaining) ? ($daysRemaining >= 0 ? $daysRemaining : 'Terlambat ' . abs($daysRemaining)) : $daysRemaining,
                ];
            })->toArray();

            $this->table(
                ['ID', 'Peminjam', 'Status', 'Deadline', 'Sisa/Terlambat'],
                $tableData
            );

            $this->newLine();
            $selectedId = $this->ask('Pilih ID peminjaman untuk testing (atau kosongkan untuk batal)');

            if ($selectedId) {
                $this->testSpecificLoan($selectedId);
            }
            return;
        }

        $this->info('📋 Ditemukan ' . $loans->count() . ' peminjaman aktif:');
        $this->newLine();

        // Tampilkan tabel peminjaman
        $tableData = $loans->map(function ($loan) {
            $daysRemaining = now()->diffInDays($loan->tanggal_kembali, false);
            $status = $daysRemaining < 0 ? '🚨 Terlambat' : '⏰ Aktif';
            $deadline = $daysRemaining < 0
                ? abs($daysRemaining) . ' hari terlambat'
                : $daysRemaining . ' hari lagi';

            return [
                $loan->id_peminjaman,
                $loan->user->nama,
                $loan->user->email,
                $loan->tanggal_kembali->format('d/m/Y'),
                $deadline,
                $status,
            ];
        })->toArray();

        $this->table(
            ['ID', 'Peminjam', 'Email', 'Deadline', 'Info', 'Status'],
            $tableData
        );

        $this->newLine();

        // Pilih peminjaman untuk test
        $selectedId = $this->ask('Pilih ID peminjaman untuk testing (atau kosongkan untuk yang pertama)', $loans->first()->id_peminjaman);

        $selectedLoan = $loans->firstWhere('id_peminjaman', $selectedId);

        if ($selectedLoan) {
            $this->sendTestEmail($selectedLoan);
        } else {
            $this->error('❌ Peminjaman tidak valid!');
        }
    }

    /**
     * Send test email
     */
    private function sendTestEmail(Peminjaman $peminjaman)
    {
        $this->newLine();
        $this->info('📨 Detail Peminjaman:');
        $this->line("   ID: #{$peminjaman->id_peminjaman}");
        $this->line("   Peminjam: {$peminjaman->user->nama}");
        $this->line("   Email: {$peminjaman->user->email}");
        $this->line("   Status: {$peminjaman->label_status}");
        $this->line("   Tanggal Pinjam: {$peminjaman->tanggal_pinjam->format('d F Y')}");
        $this->line("   Deadline: {$peminjaman->tanggal_kembali->format('d F Y')}");

        $daysRemaining = now()->diffInDays($peminjaman->tanggal_kembali, false);
        if ($daysRemaining < 0) {
            $this->line("   Terlambat: " . abs($daysRemaining) . " hari");
        } else {
            $this->line("   Sisa Waktu: {$daysRemaining} hari");
        }

        $this->newLine();
        $this->line('📦 Barang yang dipinjam:');
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $this->line("   • {$detail->barang->nama_barang} ({$detail->jumlah} unit)");
        }

        $this->newLine();

        if (!$this->confirm('Kirim email test ke Mailtrap?', true)) {
            $this->warn('❌ Testing dibatalkan.');
            return;
        }

        try {
            $this->line('');
            $this->info('📤 Mengirim email...');

            Mail::to($peminjaman->user->email)
                ->send(new ReturnReminderMail($peminjaman));

            $this->newLine();
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('✅ EMAIL BERHASIL DIKIRIM!');
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->newLine();

            $this->line('🎯 Cek email di Mailtrap:');
            $this->line('   👉 https://mailtrap.io/inboxes');
            $this->newLine();

            $reminderType = $daysRemaining < 0 ? 'OVERDUE (Terlambat)' : 'UPCOMING (Akan jatuh tempo)';
            $this->line("📧 Tipe Email: <fg=yellow>{$reminderType}</>");
            $this->line("📬 Dikirim ke: <fg=cyan>{$peminjaman->user->email}</>");
            $this->line("🔖 Subject: " . ($daysRemaining < 0
                ? '🚨 Urgent: Pengembalian Barang Terlambat - KlikAset'
                : '⏰ Reminder: Pengembalian Barang - KlikAset'));

            $this->newLine();
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ GAGAL MENGIRIM EMAIL!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();

            $this->warn('💡 Troubleshooting:');
            $this->line('   1. Cek konfigurasi .env (MAIL_* variables)');
            $this->line('   2. Pastikan Mailtrap credentials benar');
            $this->line('   3. Cek koneksi internet');
            $this->line('   4. Jalankan: php artisan config:clear');
            $this->newLine();
        }
    }
}
