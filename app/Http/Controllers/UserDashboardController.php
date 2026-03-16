<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Dashboard utama → /user/dashboard
    public function index()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    // Riwayat peminjaman → /user/riwayat
    public function riwayat()
    {
        $user = Auth::user();
        return view('user.riwayat', compact('user'));
    }

    // Profil user → /user/profile
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Pinjaman aktif → /user/pinjaman
    public function pinjaman()
    {
        $user = Auth::user();
        return view('user.pinjaman', compact('user'));
    }

    // Sarpras → /user/sarpras
    public function sarpras()
    {
        $user = Auth::user();
        return view('user.sarpras', compact('user'));
    }

    // Leaderboard → /user/rank
    public function rank()
    {
        $user = Auth::user();
        return view('user.rank', compact('user'));
    }
}
