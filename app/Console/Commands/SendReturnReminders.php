<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use App\Mail\ReturnReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReturnReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-return
                            {--dry-run : Tampilkan yang akan dikirim tanpa benar-benar mengirim}
                            {--force : Paksa kirim meskipun tidak dalam jadwal}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email reminder pengembalian barang secara otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $isForce = $this->option('force');

        $this->info('🔔 Starting Return Reminder Service');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('Waktu: ' . now()->format('d F Y, H:i:s'));

        if ($isDryRun) {
            $this->warn('⚠️  DRY RUN MODE - Email tidak akan benar-benar dikirim');
        }

        $this->newLine();

        // Ambil peminjaman yang sedang dipinjam
        $activeLoans = Peminjaman::with(['user', 'detailPeminjaman.barang'])
            ->where('status', 'dipinjam')
            ->whereNotNull('tanggal_kembali')
            ->get();

        if ($activeLoans->isEmpty()) {
            $this->info('✓ Tidak ada peminjaman aktif yang perlu reminder.');
            return;
        }

        $this->info("📋 Ditemukan {$activeLoans->count()} peminjaman aktif");
        $this->newLine();

        // Kategorikan peminjaman
        $overdue = collect();
        $dueSoon = collect();
        $upcoming = collect();

        foreach ($activeLoans as $loan) {
            $daysRemaining = now()->diffInDays($loan->tanggal_kembali, false);

            if ($daysRemaining < 0) {
                // Terlambat
                $overdue->push($loan);
            } elseif ($daysRemaining <= 2) {
                // Jatuh tempo dalam 2 hari
                $dueSoon->push($loan);
            } elseif ($daysRemaining <= 5) {
                // Jatuh tempo dalam 5 hari
                $upcoming->push($loan);
            }
        }

        // Summary
        $this->line('📊 Summary:');
        $this->line("   🚨 Terlambat: {$overdue->count()} peminjaman");
        $this->line("   ⏰ Jatuh tempo ≤ 2 hari: {$dueSoon->count()} peminjaman");
        $this->line("   📅 Jatuh tempo 3-5 hari: {$upcoming->count()} peminjaman");
        $this->newLine();

        $totalToSend = $overdue->count() + $dueSoon->count() + $upcoming->count();

        if ($totalToSend === 0) {
            $this->info('✓ Tidak ada peminjaman yang perlu reminder saat ini.');
            return;
        }

        // Kirim reminder untuk yang terlambat (URGENT)
        if ($overdue->count() > 0) {
            $this->sendReminders($overdue, '🚨 URGENT - Terlambat', $isDryRun);
        }

        // Kirim reminder untuk yang jatuh tempo dalam 2 hari
        if ($dueSoon->count() > 0) {
            $this->sendReminders($dueSoon, '⏰ SEGERA - Jatuh tempo ≤ 2 hari', $isDryRun);
        }

        // Kirim reminder untuk yang jatuh tempo 3-5 hari (opsional, hanya sekali)
        if ($upcoming->count() > 0 && $isForce) {
            $this->sendReminders($upcoming, '📅 INFO - Jatuh tempo 3-5 hari', $isDryRun);
        }

        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('✅ Reminder service completed!');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }

    /**
     * Send reminders to a collection of loans
     */
    private function sendReminders($loans, $category, $isDryRun)
    {
        $this->newLine();
        $this->line("📤 {$category}:");
        $this->line(str_repeat('─', 60));

        $sentCount = 0;
        $failedCount = 0;

        foreach ($loans as $loan) {
            $daysRemaining = now()->diffInDays($loan->tanggal_kembali, false);
            $status = $daysRemaining < 0
                ? 'Terlambat ' . abs($daysRemaining) . ' hari'
                : 'Sisa ' . $daysRemaining . ' hari';

            $this->line("   • ID #{$loan->id_peminjaman} - {$loan->user->nama} ({$status})");
            $this->line("     Email: {$loan->user->email}");
            $this->line("     Deadline: {$loan->tanggal_kembali->format('d/m/Y')}");

            if ($isDryRun) {
                $this->line("     <fg=yellow>[DRY RUN] Would send email</>");
                $sentCount++;
            } else {
                try {
                    Mail::to($loan->user->email)
                        ->send(new ReturnReminderMail($loan));

                    $this->line("     <fg=green>✓ Email sent successfully</>");
                    $sentCount++;
                } catch (\Exception $e) {
                    $this->line("     <fg=red>✗ Failed: {$e->getMessage()}</>");
                    $failedCount++;
                }
            }

            $this->newLine();
        }

        $this->line("   Total: {$sentCount} sent" . ($failedCount > 0 ? ", {$failedCount} failed" : ""));
    }
}
