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
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => AuthMessages::rateLimitLogin($seconds)]);
        }

        $credentials = $request->validated();
        $email = $credentials['email'];
        $password = $credentials['password'];
        $remember = $credentials['remember'] ?? false;

        $user = User::where('email', $email)->first();

        if (!$user) {
            RateLimiter::hit($throttleKey, 60);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => AuthMessages::emailNotRegistered()]);
        }

        if (!Hash::check($password, $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => AuthMessages::wrongPassword()]);
        }

        Auth::login($user, $remember);
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return $this->redirectToDashboard();
    }

    protected function redirectToDashboard()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', AuthMessages::welcomeBack($user->username));
        }

        if ($user->isPeminjam()) {
            return redirect()
                ->route('peminjam.home')
                ->with('success', AuthMessages::welcomeUser($user->username));
        }

        Auth::logout();
        return redirect()
            ->route('auth.login')
            ->withErrors(['email' => AuthMessages::invalidRole()]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('success', AuthMessages::logoutSuccess());
    }

    public function showForgotPassword()
    {
        return view('auth.lupa-password');
    }

    public function sendResetCode(ForgotPasswordRequest $request)
    {
        $email = strtolower(trim($request->email));
        $rateLimitKey = 'reset-password:' . $email;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 1)) {
            $availableIn = RateLimiter::availableIn($rateLimitKey);
            $hours = floor($availableIn / 3600);
            $minutes = floor(($availableIn % 3600) / 60);

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => AuthMessages::rateLimitResetPassword($hours, $minutes)]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => AuthMessages::emailNotFound($email)]);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
            'created_at' => Carbon::now(),
        ]);

        try {
            Mail::to($email)->send(new ResetPasswordMail($code, $user->username));
            RateLimiter::hit($rateLimitKey, 7200);
            session(['reset_email' => $email]);

            return redirect()
                ->route('auth.verify_code')
                ->with('success', AuthMessages::codeSent($email));

        } catch (\Exception $e) {
            \Log::error('Failed to send reset password email', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => AuthMessages::emailSendFailed()]);
        }
    }

    public function showVerifyCode()
    {
        if (!session('reset_email')) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::sessionExpired()]);
        }
        return view('auth.verify-code');
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::sessionExpired()]);
        }

        $resetData = DB::table('password_resets')
            ->where('email', $email)
            ->where('code', $request->code)
            ->first();

        if (!$resetData) {
            return back()->withErrors(['code' => AuthMessages::invalidCode($request->code)]);
        }

        if (Carbon::parse($resetData->expires_at)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            return back()
                ->withErrors(['code' => AuthMessages::codeExpired()])
                ->with('expired', true);
        }

        session(['verified_code' => $request->code]);

        return redirect()
            ->route('auth.reset_password')
            ->with('success', AuthMessages::codeVerified());
    }

    public function showResetPassword()
    {
        if (!session('reset_email') || !session('verified_code')) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::sessionExpiredNotVerified()]);
        }
        return view('auth.reset-password');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = session('reset_email');
        $code = session('verified_code');

        if (!$email || !$code) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::sessionExpired()]);
        }

        $resetData = DB::table('password_resets')
            ->where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$resetData || Carbon::parse($resetData->expires_at)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            session()->forget(['reset_email', 'verified_code']);

            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::resetCodeExpired()]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::userNotFound()]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $email)->delete();
        session()->forget(['reset_email', 'verified_code']);

        return redirect()
            ->route('auth.login')
            ->with('success', AuthMessages::passwordResetSuccess());
    }

    public function resendCode()
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::sessionExpired()]);
        }

        $rateLimitKey = 'resend-code:' . $email;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors(['code' => AuthMessages::rateLimitResendCode($minutes)]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('auth.lupa_password')
                ->withErrors(['email' => AuthMessages::userNotFound()]);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_resets')->where('email', $email)->delete();
        DB::table('password_resets')->insert([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
            'created_at' => Carbon::now(),
        ]);

        try {
            Mail::to($email)->send(new ResetPasswordMail($code, $user->username));
            RateLimiter::hit($rateLimitKey, 300);

            return back()->with('success', AuthMessages::codeResent());
        } catch (\Exception $e) {
            \Log::error('Failed to resend code', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['code' => AuthMessages::codeResendFailed()]);
        }
    }
}
