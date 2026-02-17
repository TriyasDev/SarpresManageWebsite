<?php

namespace App\Http\Messages;

class AuthMessages
{
    // Rate limit messages
    public static function rateLimitLogin(int $seconds): string
    {
        return "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.";
    }

    public static function rateLimitResetPassword(int $hours, int $minutes): string
    {
        $timeMessage = $hours > 0 ? "{$hours} jam {$minutes} menit" : "{$minutes} menit";
        return "Anda sudah meminta kode reset untuk email ini. Silakan tunggu {$timeMessage} lagi atau periksa inbox/spam email Anda untuk kode yang sudah dikirim sebelumnya.";
    }

    public static function rateLimitResendCode(int $minutes): string
    {
        return "Terlalu banyak permintaan kirim ulang kode. Silakan tunggu {$minutes} menit lagi.";
    }

    // Login error messages
    public static function emailNotRegistered(): string
    {
        return 'Email tidak terdaftar dalam sistem. Silakan hubungi admin untuk mendaftar.';
    }

    public static function wrongPassword(): string
    {
        return 'Password yang Anda masukkan salah. Silakan coba lagi.';
    }

    public static function invalidRole(): string
    {
        return 'Role pengguna tidak valid. Hubungi administrator.';
    }

    // Forgot password error messages
    public static function emailNotFound(string $email): string
    {
        return "Email \"{$email}\" tidak terdaftar dalam sistem KlikAset. Pastikan Anda menggunakan email yang benar atau hubungi administrator untuk registrasi akun.";
    }

    public static function emailSendFailed(): string
    {
        return 'Gagal mengirim email. Terjadi kesalahan pada server email. Silakan coba lagi dalam beberapa saat atau hubungi administrator jika masalah berlanjut.';
    }

    public static function sessionExpired(): string
    {
        return 'Sesi Anda telah berakhir. Silakan mulai proses reset password dari awal.';
    }

    public static function sessionExpiredNotVerified(): string
    {
        return 'Sesi Anda telah berakhir atau belum diverifikasi. Silakan mulai dari awal.';
    }

    // Verify code error messages
    public static function invalidCode(string $code): string
    {
        return "Kode verifikasi \"{$code}\" tidak valid atau salah. Silakan periksa kembali kode di email Anda atau minta kode baru.";
    }

    public static function codeExpired(): string
    {
        return 'Kode verifikasi sudah tidak berlaku (expired setelah 15 menit). Silakan klik tombol "Kirim Ulang Kode" untuk mendapatkan kode baru.';
    }

    // Reset password error messages
    public static function userNotFound(): string
    {
        return 'User tidak ditemukan. Silakan hubungi administrator.';
    }

    public static function resetCodeExpired(): string
    {
        return 'Kode verifikasi sudah tidak berlaku. Silakan mulai proses reset password dari awal.';
    }

    // Success messages
    public static function welcomeBack(string $username): string
    {
        return "Selamat datang kembali, {$username}!";
    }

    public static function welcomeUser(string $username): string
    {
        return "Selamat datang, {$username}!";
    }

    public static function logoutSuccess(): string
    {
        return 'Anda telah berhasil logout. Sampai jumpa!';
    }

    public static function codeSent(string $email): string
    {
        return "Kode verifikasi berhasil dikirim ke {$email}. Silakan cek inbox atau folder spam Anda. Kode berlaku selama 15 menit.";
    }

    public static function codeVerified(): string
    {
        return 'Kode berhasil diverifikasi! Silakan masukkan password baru Anda.';
    }

    public static function passwordResetSuccess(): string
    {
        return 'Password berhasil direset! Silakan login dengan password baru Anda.';
    }

    public static function codeResent(): string
    {
        return 'Kode verifikasi baru telah dikirim ke email Anda. Silakan cek inbox atau folder spam.';
    }

    public static function codeResendFailed(): string
    {
        return 'Gagal mengirim ulang kode. Silakan coba lagi dalam beberapa saat.';
    }
}
