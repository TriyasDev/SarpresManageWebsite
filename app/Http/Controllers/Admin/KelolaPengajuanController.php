<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelolaPengajuanController extends Controller
{
    // ──────────────────────────────────────────────────────────────
    //  INDEX
    // ──────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Pengajuan::with([
            'user',
            'firstDetail.barang', // barang pertama dari detail
        ])->latest();

        // Search: nama peminjam atau nama barang
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas(
                    'user',
                    fn($q2) =>
                    $q2->where('username', 'like', "%$search%")
                        ->orWhere('nipd', 'like', "%$search%")
                )->orWhereHas(
                    'details.barang',
                    fn($q2) =>
                    $q2->where('nama_barang', 'like', "%$search%")
                );
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->paginate(10)->withQueryString();

        // Stat cards
        $statDisetujui = Pengajuan::disetujui()->bulanIni()->count();
        $statDitolak   = Pengajuan::ditolak()->bulanIni()->count();
        $statMenunggu  = Pengajuan::menunggu()->count();

        return view('admin.kelola_pengajuan.index', compact(
            'pengajuans',
            'statDisetujui',
            'statDitolak',
            'statMenunggu'
        ));
    }

    // ──────────────────────────────────────────────────────────────
    //  APPROVE
    // ──────────────────────────────────────────────────────────────
    public function approve(Request $request, $id)
    {
        $pengajuan = Pengajuan::where('status', 'menunggu')->findOrFail($id);

        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        $pengajuan->update([
            'status'         => 'disetujui',
            'catatan'        => $request->catatan,       // ← kolom: catatan
            'disetujui_oleh' => Auth::id(),
            'id_admin'       => Auth::id(),
        ]);

        return redirect()->route('approvals.index')
            ->with('success', "Pengajuan dari {$pengajuan->user?->username} berhasil disetujui.");
    }

    // ──────────────────────────────────────────────────────────────
    //  REJECT
    // ──────────────────────────────────────────────────────────────
    public function reject(Request $request, $id)
    {
        $pengajuan = Pengajuan::where('status', 'menunggu')->findOrFail($id);

        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        $pengajuan->update([
            'status'  => 'ditolak',
            'catatan' => $request->catatan,              // ← kolom: catatan
            'id_admin' => Auth::id(),
        ]);

        return redirect()->route('approvals.index')
            ->with('success', "Pengajuan dari {$pengajuan->user?->username} berhasil ditolak.");
    }
}
