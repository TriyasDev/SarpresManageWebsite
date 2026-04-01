<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeLoans = Peminjaman::where('id_user', $user->id_user)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->count();
        $pendingLoans = Peminjaman::where('id_user', $user->id_user)
            ->where('status', 'menunggu')
            ->count();
        $totalReturns = Peminjaman::where('id_user', $user->id_user)
            ->where('status', 'dikembalikan')
            ->count();

        return view('user.user-dashboard', compact('user', 'activeLoans', 'pendingLoans', 'totalReturns'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }

    public function riwayat()
    {
        $user = Auth::user();
        $loans = Peminjaman::with(['detailPeminjaman.barang'])
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('user.riwayat', compact('loans'));
    }

    public function pinjaman()
    {
        $user = Auth::user();
        $activeLoans = Peminjaman::with(['detailPeminjaman.barang'])
            ->where('id_user', $user->id_user)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->get();
        return view('user.pinjaman', compact('activeLoans'));
    }

    public function sarpras()
    {
        $barangs = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->get();
        return view('user.sarpras', compact('barangs'));
    }

    public function rank()
    {
        $user = Auth::user();
        $rankings = User::where('role', 'peminjam')
            ->orderBy('points', 'desc')
            ->take(10)
            ->get();
        $position = User::where('role', 'peminjam')
            ->where('points', '>', $user->points)
            ->count() + 1;
        return view('user.rank', compact('rankings', 'user', 'position'));
    }
}
