<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelolaPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'user:id_user,username,email,nipd,kelas',
            'detailPeminjaman.barang:id_barang,nama_barang,kategori,foto',
            'approver:id_user,username',
        ])
        ->select([
            'id_peminjaman',
            'id_user',
            'id_admin',
            'tanggal_pinjam',
            'tanggal_kembali',
            'status',
            'catatan',
            'disetujui_oleh',
            'approved_at',
            'rejected_at',
            'created_at',
        ])
        ->withCount('detailPeminjaman')
        ->latest('created_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('username', 'like', "%{$search}%")
                        ->orWhere('nipd', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('detailPeminjaman.barang', function ($barangQuery) use ($search) {
                    $barangQuery->where('nama_barang', 'like', "%{$search}%");
                })
                ->orWhere('id_peminjaman', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && in_array($request->status, ['menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->paginate(10)->withQueryString();

        $currentMonth = now()->month;
        $currentYear = now()->year;

        $statMenunggu = Peminjaman::where('status', 'menunggu')->count();
        $statDisetujui = Peminjaman::where('status', 'disetujui')
            ->whereMonth('approved_at', $currentMonth)
            ->whereYear('approved_at', $currentYear)
            ->count();
        $statDitolak = Peminjaman::where('status', 'ditolak')
            ->whereMonth('rejected_at', $currentMonth)
            ->whereYear('rejected_at', $currentYear)
            ->count();

        return view('admin.kelola_pengajuan.index', compact('pengajuans', 'statMenunggu', 'statDisetujui', 'statDitolak'));
    }

    public function show($id)
    {
        $pengajuan = Peminjaman::with([
            'user',
            'detailPeminjaman.barang',
            'approver',
            'admin',
        ])->findOrFail($id);

        return view('admin.kelola_pengajuan.show', compact('pengajuan'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500',
            'tanggal_kembali' => 'required|date|after:today',
        ]);

        $pengajuan = Peminjaman::with(['user', 'detailPeminjaman.barang'])
            ->where('status', 'menunggu')
            ->findOrFail($id);

        if ($pengajuan->user->is_banned) {
            return redirect()->back()->with('error', 'User ini sedang dalam status banned dan tidak dapat meminjam.');
        }

        foreach ($pengajuan->detailPeminjaman as $detail) {
            if ($detail->barang->jumlah_tersedia < $detail->jumlah) {
                return redirect()->back()
                    ->with('error', "Stok {$detail->barang->nama_barang} tidak mencukupi. Tersedia: {$detail->barang->jumlah_tersedia}, Diminta: {$detail->jumlah}");
            }
        }

        DB::beginTransaction();
        try {
            $pengajuan->approve(Auth::id(), $request->catatan, $request->tanggal_kembali);

            foreach ($pengajuan->detailPeminjaman as $detail) {
                $detail->update([
                    'kondisi_pinjam' => $detail->barang->kondisi,
                ]);
            }

            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', "Pengajuan dari {$pengajuan->user->username} berhasil disetujui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui pengajuan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:500',
        ], [
            'catatan.required' => 'Alasan penolakan harus diisi.',
        ]);

        $pengajuan = Peminjaman::with('user')
            ->where('status', 'menunggu')
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            $pengajuan->reject(Auth::id(), $request->catatan);
            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', "Pengajuan dari {$pengajuan->user->username} berhasil ditolak.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak pengajuan: ' . $e->getMessage());
        }
    }

    public function handover(Request $request, $id)
    {
        $pengajuan = Peminjaman::with(['user', 'detailPeminjaman.barang'])
            ->where('status', 'disetujui')
            ->findOrFail($id);

        foreach ($pengajuan->detailPeminjaman as $detail) {
            if ($detail->barang->jumlah_tersedia < $detail->jumlah) {
                return redirect()->back()
                    ->with('error', "Stok {$detail->barang->nama_barang} tidak mencukupi.");
            }
        }

        DB::beginTransaction();
        try {
            $pengajuan->markAsBorrowed();
            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', "Barang berhasil diserahkan kepada {$pengajuan->user->username}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat serah terima barang: ' . $e->getMessage());
        }
    }

    public function bulkApprove(Request $request)
    {
        $request->validate([
            'pengajuan_ids' => 'required|array|min:1',
            'pengajuan_ids.*' => 'exists:tb_peminjaman,id_peminjaman',
            'tanggal_kembali' => 'required|date|after:today',
        ]);

        DB::beginTransaction();
        try {
            $count = 0;
            foreach ($request->pengajuan_ids as $id) {
                $pengajuan = Peminjaman::where('status', 'menunggu')->find($id);

                if ($pengajuan && !$pengajuan->user->is_banned) {
                    $canApprove = true;
                    foreach ($pengajuan->detailPeminjaman as $detail) {
                        if ($detail->barang->jumlah_tersedia < $detail->jumlah) {
                            $canApprove = false;
                            break;
                        }
                    }

                    if ($canApprove) {
                        $pengajuan->approve(Auth::id(), null, $request->tanggal_kembali);
                        $count++;
                    }
                }
            }

            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', "{$count} pengajuan berhasil disetujui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function bulkReject(Request $request)
    {
        $request->validate([
            'pengajuan_ids' => 'required|array|min:1',
            'pengajuan_ids.*' => 'exists:tb_peminjaman,id_peminjaman',
            'catatan' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $count = Peminjaman::whereIn('id_peminjaman', $request->pengajuan_ids)
                ->where('status', 'menunggu')
                ->update([
                    'status' => 'ditolak',
                    'catatan' => $request->catatan,
                    'disetujui_oleh' => Auth::id(),
                    'id_admin' => Auth::id(),
                    'rejected_at' => now(),
                ]);

            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', "{$count} pengajuan berhasil ditolak.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $pengajuan = Peminjaman::where('status', 'menunggu')->findOrFail($id);

        if (Auth::id() !== $pengajuan->id_user && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk membatalkan pengajuan ini.');
        }

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan' => 'Dibatalkan oleh ' . (Auth::id() === $pengajuan->id_user ? 'peminjam' : 'admin'),
            'rejected_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function export(Request $request)
    {
        $query = Peminjaman::with(['user', 'detailPeminjaman.barang']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->get();

        // return Excel::download(new PengajuanExport($pengajuans), 'pengajuan.xlsx');
    }
}
