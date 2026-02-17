<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('auth.login')
                ->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        $user = Auth::user();

        // Cek apakah role user sesuai dengan yang diizinkan
        if ($user->role !== $role) {
            // Log unauthorized access attempt (opsional)
            // Log::warning('Unauthorized access attempt', [
            //     'user_id' => $user->id_user,
            //     'user_role' => $user->role,
            //     'required_role' => $role,
            //     'url' => $request->url()
            // ]);

            // Redirect ke dashboard yang sesuai dengan role user
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            if ($user->isPeminjam()) {
                return redirect()->route('peminjam.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }

            // Fallback: logout jika role tidak dikenali
            Auth::logout();
            return redirect()->route('auth.login')
                ->withErrors(['email' => 'Role pengguna tidak valid.']);
        }

        return $next($request);
    }
}
