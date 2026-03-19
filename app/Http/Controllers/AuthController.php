<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Messages\AuthMessages;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    /**
     * Handle login request - OPTIMIZED
     */
    public function login(LoginRequest $request)
    {
        // Simplified rate limiting
        $throttleKey = $request->ip() . '|login';

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik."]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Single attempt to login
        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // Clear rate limit on success
        RateLimiter::clear($throttleKey);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect based on role
        return $this->redirectToDashboard();
    }

    /**
     * Redirect to appropriate dashboard based on user role
     */
    protected function redirectToDashboard()
    {
        $user = Auth::user();

        // Admin redirect
        if ($user->role === 'admin' || method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return redirect()
                ->intended(route('dashboard'))
                ->with('success', "Selamat datang kembali, {$user->username}!");
        }

        // Regular user redirect
        if ($user->role === 'peminjam' || method_exists($user, 'isPeminjam') && $user->isPeminjam()) {
            return redirect()
                ->intended(route('home'))
                ->with('success', "Selamat datang, {$user->username}!");
        }

        // Invalid role - logout
        Auth::logout();
        return redirect()
            ->route('auth.login')
            ->withErrors(['email' => 'Role pengguna tidak valid.']);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.lupa-password');
    }

    /**
     * Send reset code via email - OPTIMIZED
     */
    public function sendResetCode(ForgotPasswordRequest $request)
    {
        $email = strtolower(trim($request->email));
        $rateLimitKey = 'reset:' . $email;

        // Rate limit: 1 request per 2 hours
        if (RateLimiter::tooManyAttempts($rateLimitKey, 1)) {
            $minutes = ceil(RateLimiter::availableIn($rateLimitKey) / 60);
            return back()
                ->withInput()
                ->withErrors(['email' => "Kode reset sudah dikirim. Silakan coba lagi dalam {$minutes} menit."]);
        }

        // Check if user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete old codes and insert new one (optimized single query)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(15),
                'created_at' => Carbon::now(),
            ]
        );

        // Send email
        try {
            Mail::to($email)->send(new ResetPasswordMail($code, $user->username));
            RateLimiter::hit($rateLimitKey, 7200); // 2 hours

            session(['reset_email' => $email]);

            return redirect()
                ->route('auth.verify_code')
                ->with('success', "Kode verifikasi telah dikirim ke {$email}");

        } catch (\Exception $e) {
            \Log::error('Email send failed', ['email' => $email, 'error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }
    }

    /**
     * Show verify code form
     */
    public function showVerifyCode()
    {
        if (!session('reset_email')) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Sesi telah berakhir. Silakan mulai dari awal.']);
        }
        return view('auth.verify-code');
    }

    /**
     * Verify reset code
     */
    public function verifyCode(VerifyCodeRequest $request)
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Sesi telah berakhir.']);
        }

        // Check code validity
        $resetData = DB::table('password_resets')
            ->where('email', $email)
            ->where('code', $request->code)
            ->first();

        if (!$resetData) {
            return back()->withErrors(['code' => 'Kode verifikasi salah.']);
        }

        if (Carbon::parse($resetData->expires_at)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            return back()
                ->withErrors(['code' => 'Kode telah kadaluarsa.'])
                ->with('expired', true);
        }

        session(['verified_code' => $request->code]);

        return redirect()
            ->route('auth.reset_password')
            ->with('success', 'Kode berhasil diverifikasi.');
    }

    /**
     * Show reset password form
     */
    public function showResetPassword()
    {
        if (!session('reset_email') || !session('verified_code')) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Sesi tidak valid. Silakan mulai dari awal.']);
        }
        return view('auth.reset-password');
    }

    /**
     * Reset password - OPTIMIZED
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = session('reset_email');
        $code = session('verified_code');

        if (!$email || !$code) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Sesi telah berakhir.']);
        }

        // Verify code one more time
        $resetData = DB::table('password_resets')
            ->where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$resetData || Carbon::parse($resetData->expires_at)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            session()->forget(['reset_email', 'verified_code']);

            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Kode reset telah kadaluarsa.']);
        }

        // Update password
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Pengguna tidak ditemukan.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Clean up
        DB::table('password_resets')->where('email', $email)->delete();
        session()->forget(['reset_email', 'verified_code']);

        return redirect()
            ->route('auth.login')
            ->with('success', 'Password berhasil diubah. Silakan login.');
    }

    /**
     * Resend verification code
     */
    public function resendCode()
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Sesi telah berakhir.']);
        }

        $rateLimitKey = 'resend:' . $email;

        // Rate limit: 3 attempts per 5 minutes
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors(['code' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."]);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => 'Pengguna tidak ditemukan.']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(15),
                'created_at' => Carbon::now(),
            ]
        );

        try {
            Mail::to($email)->send(new ResetPasswordMail($code, $user->username));
            RateLimiter::hit($rateLimitKey, 300); // 5 minutes

            return back()->with('success', 'Kode baru telah dikirim.');
        } catch (\Exception $e) {
            \Log::error('Resend code failed', ['email' => $email, 'error' => $e->getMessage()]);
            return back()->withErrors(['code' => 'Gagal mengirim kode. Silakan coba lagi.']);
        }
    }
}
