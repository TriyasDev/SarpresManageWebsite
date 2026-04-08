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

        $activeLoansList = Peminjaman::with(['detailPeminjaman.barang'])
            ->where('id_user', $user->id_user)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->latest()
            ->get()
            ->map(function ($loan) {
                $detail = $loan->detailPeminjaman->first();
                $loan->first_barang = $detail ? $detail->barang : null;
                $loan->first_barang_name = $detail && $detail->barang ? $detail->barang->nama_barang : '-';
                $loan->first_barang_category = $detail && $detail->barang ? $detail->barang->kategori : '-';
                return $loan;
            });

        $topThree = User::where('role', 'peminjam')
            ->orderBy('points', 'desc')
            ->take(3)
            ->get();

        $currentPoints = $user->points ?? 0;
        $tierRequirements = User::getTierRequirements();
        $currentTier = $user->tier ?? 'Reliant';
        $nextTier = null;
        $pointsToNext = 0;
        $percentage = 0;

        $tiers = ['Negligent', 'Reliant', 'Steward', 'Sentinel', 'Exemplar', 'Paragon'];
        $currentIndex = array_search($currentTier, $tiers);
        if ($currentIndex !== false && $currentIndex < count($tiers) - 1) {
            $nextTier = $tiers[$currentIndex + 1];
            $nextMin = $tierRequirements[$nextTier]['min_points'] ?? 0;
            $currentMin = $tierRequirements[$currentTier]['min_points'] ?? 0;
            $pointsToNext = $nextMin - $currentPoints;
            $range = $nextMin - $currentMin;
            $percentage = $range > 0 ? min(100, max(0, ($currentPoints - $currentMin) / $range * 100)) : 0;
        }

        $rank = User::where('role', 'peminjam')->where('points', '>', $user->points)->count() + 1;
        $totalUsers = User::where('role', 'peminjam')->count();

        return view('user.user-dashboard', compact(
            'user',
            'activeLoans',
            'pendingLoans',
            'totalReturns',
            'activeLoansList',
            'topThree',
            'currentPoints',
            'currentTier',
            'nextTier',
            'pointsToNext',
            'percentage',
            'tierRequirements',
            'rank',
            'totalUsers'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profil', compact('user'));
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user();
        $query = Peminjaman::with(['detailPeminjaman.barang'])
            ->where('id_user', $user->id_user);

        if ($request->filled('status') && $request->status != '') {
            $statuses = explode(',', $request->status);
            $query->whereIn('status', $statuses);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('detailPeminjaman.barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%");
            });
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(10);

        $loans->getCollection()->transform(function ($loan) {
            $detail = $loan->detailPeminjaman->first();
            $loan->first_barang = $detail ? $detail->barang : null;
            return $loan;
        });

        $totalPointsEarned = Peminjaman::where('id_user', $user->id_user)->sum('point_earned');
        $avgDuration = Peminjaman::where('id_user', $user->id_user)
            ->whereNotNull('tanggal_kembali')
            ->where('status', 'dikembalikan')
            ->get()
            ->avg(fn($loan) => $loan->tanggal_pinjam->diffInDays($loan->tanggal_kembali)) ?? 0;

        return view('user.riwayat', compact('loans', 'totalPointsEarned', 'avgDuration'));
    }

    public function pinjaman()
    {
        $user = Auth::user();

        // SEBELUM: $activeLoansList (tidak match dengan view)
        // SESUDAH: $activeLoans (match dengan view peminjam.blade.php)
        $activeLoans = Peminjaman::with(['detailPeminjaman.barang'])
            ->where('id_user', $user->id_user)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->latest()
            ->get()
            ->map(function ($loan) {
                $detail = $loan->detailPeminjaman->first();
                $loan->first_barang = $detail ? $detail->barang : null;
                return $loan;
            });

        return view('user.pinjaman', compact('activeLoans')); // VIEW BARU!
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

        // Gunakan paginate() bukan get()
        $rankings = User::where('role', 'peminjam')
            ->orderBy('points', 'desc')
            ->paginate(10); // 10 data per halaman, sesuaikan kebutuhan

        $position = User::where('role', 'peminjam')
            ->where('points', '>', $user->points)
            ->count() + 1;

        $currentPoints = $user->points ?? 0;
        $tierRequirements = User::getTierRequirements();
        $currentTier = $user->tier ?? 'Reliant';
        $nextTier = null;
        $percentage = 0;

        $tiers = ['Negligent', 'Reliant', 'Steward', 'Sentinel', 'Exemplar', 'Paragon'];
        $currentIndex = array_search($currentTier, $tiers);
        if ($currentIndex !== false && $currentIndex < count($tiers) - 1) {
            $nextTier = $tiers[$currentIndex + 1];
            $nextMin = $tierRequirements[$nextTier]['min_points'] ?? 0;
            $currentMin = $tierRequirements[$currentTier]['min_points'] ?? 0;
            $range = $nextMin - $currentMin;
            $percentage = $range > 0 ? min(100, max(0, ($currentPoints - $currentMin) / $range * 100)) : 0;
        }

        return view('user.rank', compact('rankings', 'user', 'position', 'currentPoints', 'currentTier', 'nextTier', 'percentage', 'tierRequirements'));
    }
}
