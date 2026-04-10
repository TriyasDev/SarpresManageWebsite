<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $throttleKey = $request->ip() . '|login';

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 60);
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Email atau password salah.']);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return $this->redirectToDashboard();
    }

    protected function redirectToDashboard()
    {
        $user = Auth::user();

        if ($user->role === 'super-admin' || $user->role === 'admin') {
            return redirect()->intended(route('dashboard'))->with('success', "Selamat datang, {$user->username}!");
        }

        if ($user->role === 'peminjam') {
            return redirect()->route('home')->with('success', "Selamat datang, {$user->username}!");
        }

        Auth::logout();
        return redirect()->route('auth.login')->withErrors(['email' => 'Role tidak valid.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')->with('success', 'Anda telah keluar.');
    }

    public function showForgotPassword()
    {
        return view('auth.lupa-password');
    }

    public function sendResetCode(ForgotPasswordRequest $request)
    {
        $email = strtolower(trim($request->email));
        $rateLimitKey = 'reset:' . $email;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 1)) {
            $minutes = ceil(RateLimiter::availableIn($rateLimitKey) / 60);
            return back()->withErrors(['email' => "Kode sudah dikirim. Coba lagi dalam {$minutes} menit."]);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $hashedCode = Hash::make($code);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $hashedCode, 'created_at' => Carbon::now()]
        );

        try {
            Mail::to($email)->send(new ResetPasswordMail($code, $user->username));
            RateLimiter::hit($rateLimitKey, 7200);
            session(['reset_email' => $email, 'reset_code_plain' => $code]); // simpan sementara untuk verifikasi
            return redirect()->route('auth.verify_code')->with('success', "Kode verifikasi dikirim ke {$email}");
        } catch (\Exception $e) {
            \Log::error('Gagal kirim email reset password', ['email' => $email, 'error' => $e->getMessage()]);
            return back()->withErrors(['email' => 'Gagal mengirim email. Coba lagi.']);
        }
    }

    public function showVerifyCode()
    {
        if (!session('reset_email')) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Sesi berakhir.']);
        }
        return view('auth.verify-code');
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $email = session('reset_email');
        $storedPlainCode = session('reset_code_plain');

        if (!$email || !$storedPlainCode) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Sesi berakhir.']);
        }

        if ($request->code !== $storedPlainCode) {
            return back()->withErrors(['code' => 'Kode verifikasi salah.']);
        }

        // Cek apakah token di database masih valid (opsional, tapi tetap)
        $resetRecord = DB::table('password_reset_tokens')->where('email', $email)->first();
        if (!$resetRecord) {
            return back()->withErrors(['code' => 'Kode tidak valid. Silakan minta ulang.']);
        }

        session(['verified_code' => $request->code]);
        return redirect()->route('auth.reset_password')->with('success', 'Kode berhasil diverifikasi.');
    }

    public function showResetPassword()
    {
        if (!session('reset_email') || !session('verified_code')) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Sesi tidak valid.']);
        }
        return view('auth.reset-password');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = session('reset_email');
        $code = session('verified_code');
        $storedPlainCode = session('reset_code_plain');

        if (!$email || !$code || !$storedPlainCode || $code !== $storedPlainCode) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Sesi berakhir.']);
        }

        $resetRecord = DB::table('password_reset_tokens')->where('email', $email)->first();
        if (!$resetRecord) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Kode reset tidak valid.']);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Pengguna tidak ditemukan.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['reset_email', 'reset_code_plain', 'verified_code']);

        return redirect()->route('auth.login')->with('success', 'Password berhasil diubah. Silakan login.');
    }

    public function resendCode()
    {
        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Sesi berakhir.']);
        }

        $rateLimitKey = 'resend:' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors(['code' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."]);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('auth.lupa_password')->withErrors(['email' => 'Pengguna tidak ditemukan.']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $hashedCode = Hash::make($code);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $hashedCode, 'created_at' => Carbon::now()]
        );

        try {
            Mail::to($email)->send(new ResetPasswordMail($code, $user->username));
            RateLimiter::hit($rateLimitKey, 300);
            session(['reset_code_plain' => $code]);
            return back()->with('success', 'Kode baru telah dikirim.');
        } catch (\Exception $e) {
            \Log::error('Gagal kirim ulang kode', ['email' => $email, 'error' => $e->getMessage()]);
            return back()->withErrors(['code' => 'Gagal mengirim kode. Coba lagi.']);
        }
    }
}
