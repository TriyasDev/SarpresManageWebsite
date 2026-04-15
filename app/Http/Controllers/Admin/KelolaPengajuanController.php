<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\PengajuanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KelolaPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'user',
            'detailPeminjaman.barang',
            'admin',
            'approver'
        ])->withCount('detailPeminjaman as details_count');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter pencarian (nama peminjam, NIPD, nama barang)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('username', 'like', "%{$search}%")
                        ->orWhere('nipd', 'like', "%{$search}%");
                })->orWhereHas('detailPeminjaman.barang', function ($q2) use ($search) {
                    $q2->where('nama_barang', 'like', "%{$search}%");
                });
            });
        }

        // 🔽 Filter tanggal (baru)
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->end_date);
        }

        $query->orderBy('created_at', 'desc');
        $pengajuans = $query->paginate(10)->withQueryString();

        // Statistik (tetap sama, tidak terpengaruh filter tanggal agar konsisten)
        $startOfMonth = now()->startOfMonth();
        $endOfMonth   = now()->endOfMonth();

        $statDisetujui = Peminjaman::where('status', 'dipinjam')
            ->whereBetween('approved_at', [$startOfMonth, $endOfMonth])
            ->count();

        $statDitolak = Peminjaman::where('status', 'ditolak')
            ->whereBetween('rejected_at', [$startOfMonth, $endOfMonth])
            ->count();

        $statMenunggu = Peminjaman::where('status', 'menunggu')->count();

        return view('admin.kelola_pengajuan.index', compact(
            'pengajuans',
            'statDisetujui',
            'statDitolak',
            'statMenunggu'
        ));
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

    /**
     * Menyetujui pengajuan sekaligus mengurangi stok barang
     * Status langsung menjadi 'dipinjam' karena barang sudah diambil/diserahkan
     */
    public function approve(Request $request, $id)
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.barang'])
            ->where('status', 'menunggu')
            ->findOrFail($id);

        // Cek apakah user sedang dibanned
        if ($peminjaman->user->is_banned) {
            return redirect()->route('approvals.index')
                ->with('error', 'Pengajuan tidak dapat disetujui karena peminjam sedang dibanned.');
        }

        // Cek ketersediaan stok untuk setiap barang
        foreach ($peminjaman->detailPeminjaman as $detail) {
            if ($detail->barang->jumlah_tersedia < $detail->jumlah) {
                return redirect()->route('approvals.index')
                    ->with('error', "Stok {$detail->barang->nama_barang} tidak mencukupi (tersedia: {$detail->barang->jumlah_tersedia}, dibutuhkan: {$detail->jumlah}).");
            }
        }

        // Jika tanggal kembali belum diisi, set default +7 hari dari sekarang
        $tanggalKembali = $peminjaman->tanggal_kembali ?? now()->addDays(7);

        DB::beginTransaction();
        try {
            // Update status dan data approval
            $peminjaman->update([
                'status'            => 'dipinjam',  // Langsung dipinjam
                'id_admin'          => Auth::id(),
                'disetujui_oleh'    => Auth::id(),
                'approved_at'       => now(),
                'tanggal_kembali'   => $tanggalKembali,
                'catatan'           => $request->catatan ?? null, // simpan catatan dari modal
            ]);

            // Kurangi stok setiap barang
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $detail->barang->decrement('jumlah_tersedia', $detail->jumlah);
            }

            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', "Pengajuan dari {$peminjaman->user->username} berhasil disetujui. Stok barang telah dikurangi.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('approvals.index')
                ->with('error', 'Terjadi kesalahan saat menyetujui pengajuan: ' . $e->getMessage());
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
            $pengajuan->update([
                'status'          => 'ditolak',
                'id_admin'        => Auth::id(),
                'disetujui_oleh'  => Auth::id(),
                'rejected_at'     => now(),
                'catatan'         => $request->catatan,
            ]);

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
        return $this->approve($request, $id);
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
                $pengajuan = Peminjaman::with('detailPeminjaman.barang')
                    ->where('status', 'menunggu')
                    ->find($id);

                if ($pengajuan && !$pengajuan->user->is_banned) {
                    $stockAvailable = true;
                    foreach ($pengajuan->detailPeminjaman as $detail) {
                        if ($detail->barang->jumlah_tersedia < $detail->jumlah) {
                            $stockAvailable = false;
                            break;
                        }
                    }

                    if ($stockAvailable) {
                        $pengajuan->update([
                            'status'          => 'dipinjam',
                            'id_admin'        => Auth::id(),
                            'disetujui_oleh'  => Auth::id(),
                            'approved_at'     => now(),
                            'tanggal_kembali' => $request->tanggal_kembali,
                        ]);

                        foreach ($pengajuan->detailPeminjaman as $detail) {
                            $detail->barang->decrement('jumlah_tersedia', $detail->jumlah);
                        }
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
                    'status'          => 'ditolak',
                    'catatan'         => $request->catatan,
                    'disetujui_oleh'  => Auth::id(),
                    'id_admin'        => Auth::id(),
                    'rejected_at'     => now(),
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
            'status'      => 'ditolak',
            'catatan'     => 'Dibatalkan oleh ' . (Auth::id() === $pengajuan->id_user ? 'peminjam' : 'admin'),
            'rejected_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function exportExcel(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        $pengajuans = $query->get();

        return Excel::download(new PengajuanExport($pengajuans), 'pengajuan_' . date('Y-m-d_Hi') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = $this->getFilteredQuery($request);
        $pengajuans = $query->get();

        // Pastikan semua key ada meskipun null
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        $pdf = Pdf::loadView('admin.kelola_pengajuan.export_pdf', [
            'pengajuans' => $pengajuans,
            'filters' => $filters
        ]);

        return $pdf->download('pengajuan_' . date('Y-m-d_Hi') . '.pdf');
    }

    private function getFilteredQuery(Request $request)
    {
        $query = Peminjaman::with([
            'user',
            'detailPeminjaman.barang',
            'admin',
            'approver'
        ])->withCount('detailPeminjaman as details_count');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('username', 'like', "%{$search}%")
                        ->orWhere('nipd', 'like', "%{$search}%");
                })->orWhereHas('detailPeminjaman.barang', function ($q2) use ($search) {
                    $q2->where('nama_barang', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->end_date);
        }

        $query->orderBy('created_at', 'desc');

        return $query;
    }
}
