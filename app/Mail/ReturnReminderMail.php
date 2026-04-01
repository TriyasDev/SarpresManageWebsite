<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReturnReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;
    public $reminderType; // 'upcoming' atau 'overdue'
    public $daysRemaining;
    public $daysLate;

    /**
     * Create a new message instance.
     */
    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;

        // Hitung sisa hari atau keterlambatan
        if ($peminjaman->tanggal_kembali) {
            $diff = now()->diffInDays($peminjaman->tanggal_kembali, false);

            if ($diff < 0) {
                // Sudah terlambat
                $this->reminderType = 'overdue';
                $this->daysLate = abs($diff);
                $this->daysRemaining = 0;
            } else {
                // Masih ada waktu
                $this->reminderType = 'upcoming';
                $this->daysRemaining = $diff;
                $this->daysLate = 0;
            }
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->reminderType === 'overdue'
            ? '🚨 Urgent: Pengembalian Barang Terlambat - KlikAset'
            : '⏰ Reminder: Pengembalian Barang - KlikAset';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.return-reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
