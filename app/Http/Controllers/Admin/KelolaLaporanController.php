<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\PointLog;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Barang;

class KelolaLaporanController extends Controller
{
    // INDEX – daftar laporan aktif
    public function index(Request $request)
    {
        $query = Laporan::with(['peminjaman.user', 'peminjaman.detailPeminjaman.barang', 'admin'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('peminjaman.user', fn($q2) => $q2->where('username', 'like', "%$search%"))
                    ->orWhereHas('peminjaman.detailPeminjaman.barang', fn($q2) => $q2->where('nama_barang', 'like', "%$search%"));
            });
        }

        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }

        if ($request->filled('kondisi_barang')) {
            $query->where('kondisi_barang', $request->kondisi_barang);
        }

        $laporans = $query->paginate(10)->withQueryString();
        $trashedCount = Laporan::onlyTrashed()->count();

        return view('admin.kelola_laporan.index', compact('laporans', 'trashedCount'));
    }

    // CREATE – form tambah laporan
    public function create()
    {
        $activeLoans = Peminjaman::with(['user', 'detailPeminjaman.barang'])
            ->whereIn('status', ['dipinjam', 'disetujui'])
            ->orderBy('tanggal_kembali', 'asc')
            ->get()
            ->map(function ($loan) {
                return [
                    'id' => $loan->id_peminjaman,
                    'user' => $loan->user->username,
                    'barang' => $loan->detailPeminjaman->first()?->barang?->nama_barang ?? '-',
                    'tenggat' => $loan->tanggal_kembali->format('d/m/Y'),
                    'tanggal_pinjam' => $loan->tanggal_pinjam?->format('Y-m-d\TH:i') ?? '',
                    'details' => $loan->detailPeminjaman->map(function ($detail) {
                        return [
                            'id_barang' => $detail->id_barang,
                            'nama_barang' => $detail->barang->nama_barang,
                            'jumlah_pinjam' => $detail->jumlah,
                        ];
                    })->toArray()
                ];
            });

        return view('admin.kelola_laporan.create', compact('activeLoans'));
    }

    // STORE – simpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'        => 'required|exists:tb_peminjaman,id_peminjaman',
            'jenis_laporan'        => 'required|in:dikembalikan,telat mengembalikan,hilang',
            'kondisi_barang'       => 'required|in:baik,masih di pinjam,rusak',
            'tanggal_dipinjam'     => 'nullable|date',
            'tanggal_dikembalikan' => 'nullable|date',
            'foto_bukti'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'details'              => 'required|array',
            'details.*.id_barang'  => 'required|exists:tb_barang,id_barang',
            'details.*.jumlah_dikembalikan' => 'required|integer|min:0',
        ]);

        // Validasi tambahan: jumlah dikembalikan tidak boleh melebihi jumlah pinjam
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')->findOrFail($request->id_peminjaman);
        foreach ($request->details as $detail) {
            $detailPinjam = $peminjaman->detailPeminjaman->firstWhere('id_barang', $detail['id_barang']);
            if (!$detailPinjam) {
                return back()->withErrors(['details' => 'Barang tidak valid untuk peminjaman ini.'])->withInput();
            }
            if ($detail['jumlah_dikembalikan'] > $detailPinjam->jumlah) {
                return back()->withErrors(["details.{$detail['id_barang']}" => "Jumlah dikembalikan untuk {$detailPinjam->barang->nama_barang} melebihi jumlah pinjam."])->withInput();
            }
        }

        // Cek duplikat laporan
        if (Laporan::where('id_peminjaman', $request->id_peminjaman)->exists()) {
            return back()->withErrors(['id_peminjaman' => 'Peminjaman ini sudah memiliki laporan.'])->withInput();
        }

        // Simpan laporan
        $data = $request->only(['id_peminjaman', 'jenis_laporan', 'kondisi_barang', 'tanggal_dipinjam', 'tanggal_dikembalikan']);
        $data['id_admin'] = Auth::id();
        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('laporan/foto', 'public');
        }
        $laporan = Laporan::create($data);

        // Simpan detail laporan
        foreach ($request->details as $detail) {
            $laporan->details()->create([
                'id_barang' => $detail['id_barang'],
                'jumlah_dikembalikan' => $detail['jumlah_dikembalikan'],
            ]);
        }

        // Update stok barang (hanya untuk barang yang dikembalikan)
        if ($request->jenis_laporan !== 'hilang') {
            foreach ($request->details as $detail) {
                $barang = Barang::find($detail['id_barang']);
                if ($barang && $detail['jumlah_dikembalikan'] > 0) {
                    $barang->incrementStock($detail['jumlah_dikembalikan']);
                }
            }
        }

        // Update status peminjaman
        $peminjaman->update([
            'status' => ($request->jenis_laporan === 'hilang') ? 'hilang' : 'dikembalikan',
            'tanggal_kembali_aktual' => $request->tanggal_dikembalikan ?: now(),
            'return_condition' => $request->kondisi_barang,
            'is_late' => ($request->jenis_laporan === 'telat mengembalikan'),
        ]);

        // Hitung poin user (sesuai logika yang sudah ada)
        $user = $peminjaman->user;
        if ($user) {
            $tanggalJatuhTempo = $peminjaman->tanggal_kembali;
            $tanggalDikembalikan = $request->tanggal_dikembalikan ? new \DateTime($request->tanggal_dikembalikan) : null;
            $poin = $this->hitungPoin(
                $request->jenis_laporan,
                $request->kondisi_barang,
                $tanggalDikembalikan,
                $tanggalJatuhTempo
            );
            $user->points = ($user->points ?? 0) + $poin;
            $user->save();
            $peminjaman->update(['point_earned' => $poin]);

            PointLog::create([
                'id_user' => $user->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'change' => $poin,
                'reason' => 'Laporan pengembalian (' . $request->jenis_laporan . ', kondisi: ' . $request->kondisi_barang . ')',
            ]);
        }

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil ditambahkan. Status peminjaman, stok barang, dan poin user telah diperbarui.');
    }

    // EDIT – form edit laporan
    public function edit($id)
    {
        $laporan = Laporan::with('details')->findOrFail($id);
        // Ambil data peminjaman untuk menampilkan detail barang yang dipinjam (sebagai referensi)
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')->find($laporan->id_peminjaman);
        return view('admin.kelola_laporan.edit', compact('laporan', 'peminjaman'));
    }

    // UPDATE – simpan perubahan laporan
    public function update(Request $request, $id)
    {
        $laporan = Laporan::with('details')->findOrFail($id);
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')->find($laporan->id_peminjaman);

        $request->validate([
            'jenis_laporan'        => 'required|in:dikembalikan,telat mengembalikan,hilang',
            'kondisi_barang'       => 'required|in:baik,masih di pinjam,rusak',
            'tanggal_dipinjam'     => 'nullable|date',
            'tanggal_dikembalikan' => 'nullable|date',
            'foto_bukti'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'details'              => 'required|array',
            'details.*.id_barang'  => 'required|exists:tb_barang,id_barang',
            'details.*.jumlah_dikembalikan' => 'required|integer|min:0',
        ]);

        // Validasi jumlah dikembalikan tidak melebihi jumlah pinjam
        foreach ($request->details as $detail) {
            $detailPinjam = $peminjaman->detailPeminjaman->firstWhere('id_barang', $detail['id_barang']);
            if (!$detailPinjam) {
                return back()->withErrors(['details' => 'Barang tidak valid.'])->withInput();
            }
            if ($detail['jumlah_dikembalikan'] > $detailPinjam->jumlah) {
                return back()->withErrors(["details.{$detail['id_barang']}" => "Jumlah dikembalikan melebihi jumlah pinjam."])->withInput();
            }
        }

        // Simpan data lama untuk koreksi stok dan poin
        $oldDetails = $laporan->details->keyBy('id_barang');
        $oldJenis = $laporan->jenis_laporan;
        $oldKondisi = $laporan->kondisi_barang;
        $oldTglKembali = $laporan->tanggal_dikembalikan;

        // Update laporan
        $data = $request->only(['jenis_laporan', 'kondisi_barang', 'tanggal_dipinjam', 'tanggal_dikembalikan']);
        if ($request->hasFile('foto_bukti')) {
            if ($laporan->foto_bukti) Storage::disk('public')->delete($laporan->foto_bukti);
            $data['foto_bukti'] = $request->file('foto_bukti')->store('laporan/foto', 'public');
        }
        $laporan->update($data);

        // Update detail laporan
        foreach ($request->details as $detail) {
            $existing = $laporan->details->firstWhere('id_barang', $detail['id_barang']);
            if ($existing) {
                $existing->update(['jumlah_dikembalikan' => $detail['jumlah_dikembalikan']]);
            } else {
                $laporan->details()->create($detail);
            }
        }
        // Hapus detail yang tidak ada di request
        $currentIds = collect($request->details)->pluck('id_barang')->toArray();
        $laporan->details()->whereNotIn('id_barang', $currentIds)->delete();

        // Koreksi stok barang
        // 1. Kembalikan stok ke keadaan sebelum laporan (berdasarkan oldDetails)
        if ($oldJenis !== 'hilang') {
            foreach ($oldDetails as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang && $detail->jumlah_dikembalikan > 0) {
                    $barang->decrementStock($detail->jumlah_dikembalikan);
                }
            }
        }
        // 2. Terapkan stok baru berdasarkan laporan yang sudah diupdate
        if ($request->jenis_laporan !== 'hilang') {
            foreach ($request->details as $detail) {
                $barang = Barang::find($detail['id_barang']);
                if ($barang && $detail['jumlah_dikembalikan'] > 0) {
                    $barang->incrementStock($detail['jumlah_dikembalikan']);
                }
            }
        }

        // Update status peminjaman
        $newStatus = ($request->jenis_laporan === 'hilang') ? 'hilang' : 'dikembalikan';
        $peminjaman->update([
            'status' => $newStatus,
            'tanggal_kembali_aktual' => $request->tanggal_dikembalikan ?: now(),
            'return_condition' => $request->kondisi_barang,
            'is_late' => ($request->jenis_laporan === 'telat mengembalikan'),
        ]);

        // Koreksi poin user
        if ($user = $peminjaman->user) {
            $tanggalJatuhTempo = $peminjaman->tanggal_kembali;
            $poinLama = $this->hitungPoin($oldJenis, $oldKondisi, $oldTglKembali ? new \DateTime($oldTglKembali) : null, $tanggalJatuhTempo);
            $poinBaru = $this->hitungPoin($request->jenis_laporan, $request->kondisi_barang, $request->tanggal_dikembalikan ? new \DateTime($request->tanggal_dikembalikan) : null, $tanggalJatuhTempo);
            $user->points = ($user->points ?? 0) - $poinLama + $poinBaru;
            $user->save();
            $selisihPoin = $poinBaru - $poinLama;
            $peminjaman->update(['point_earned' => $poinBaru]);
            if ($selisihPoin != 0) {
                PointLog::create([
                    'id_user' => $user->id_user,
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'change' => $selisihPoin,
                    'reason' => 'Edit laporan (perubahan poin)',
                ]);
            }
        }

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    // DESTROY – soft delete
    public function destroy($id)
    {
        // Perbaiki: cari laporan aktif, bukan onlyTrashed
        $laporan = Laporan::findOrFail($id);

        $peminjaman = Peminjaman::with(['detailPeminjaman.barang', 'user'])->find($laporan->id_peminjaman);

        // ==================== SESUAIKAN STOK SEBELUM SOFT DELETE ====================
        // Jika laporan yang dihapus adalah laporan pengembalian (bukan hilang), maka stok harus dikurangi
        // karena pengembalian dibatalkan, barang kembali ke status dipinjam.
        if ($laporan->jenis_laporan !== 'hilang') {
            $this->kurangiStokBarang($peminjaman);
        } else {
            // Jika laporan hilang dihapus, berarti barang tidak jadi hilang → stok harus ditambah kembali
            $this->kembalikanStokBarang($peminjaman);
        }
        // ========================================================================

        // ==================== KEMBALIKAN POIN USER ====================
        if ($peminjaman && $peminjaman->user) {
            $user = $peminjaman->user;
            $tanggalJatuhTempo = $peminjaman->tanggal_kembali;
            $poinYangDiberikan = $this->hitungPoin(
                $laporan->jenis_laporan,
                $laporan->kondisi_barang,
                $laporan->tanggal_dikembalikan ? new \DateTime($laporan->tanggal_dikembalikan) : null,
                $tanggalJatuhTempo
            );
            $user->points = ($user->points ?? 0) - $poinYangDiberikan;
            $user->save();
            $peminjaman->update(['point_earned' => null]);
            PointLog::create([
                'id_user' => $user->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'change' => -$poinYangDiberikan,
                'reason' => 'Laporan dihapus (poin dikembalikan)',
            ]);
        }
        // =============================================================

        $laporan->delete(); // soft delete

        return redirect()->route('reports.index')->with('success', 'Laporan dipindahkan ke tempat sampah. Stok barang dan poin user telah dikembalikan.');
    }

    // TRASH – daftar laporan di sampah
    public function trash(Request $request)
    {
        $search = $request->get('search');

        $laporans = Laporan::onlyTrashed()
            ->with(['peminjaman.user', 'peminjaman.detailPeminjaman.barang'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('peminjaman.user', fn($q2) => $q2->where('username', 'like', "%$search%"))
                    ->orWhereHas('peminjaman.detailPeminjaman.barang', fn($q2) => $q2->where('nama_barang', 'like', "%$search%"));
            })
            ->latest('deleted_at')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.kelola_laporan.trash', compact('laporans', 'search'));
    }

    // RESTORE – pulihkan dari sampah
    public function restore($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);
        $peminjaman = Peminjaman::with(['detailPeminjaman.barang', 'user'])->find($laporan->id_peminjaman);

        // ==================== SESUAIKAN STOK ====================
        // Jika laporan yang dipulihkan adalah laporan pengembalian (bukan hilang), stok harus ditambah lagi
        // karena barang kembali ke status dikembalikan.
        if ($laporan->jenis_laporan !== 'hilang') {
            $this->kembalikanStokBarang($peminjaman);
        } else {
            // Jika laporan hilang dipulihkan, stok harus dikurangi lagi (karena barang hilang)
            $this->kurangiStokBarang($peminjaman);
        }
        // =======================================================

        // ==================== TAMBAHKAN POIN KEMBALI ====================
        if ($peminjaman && $peminjaman->user) {
            $user = $peminjaman->user;
            $tanggalJatuhTempo = $peminjaman->tanggal_kembali;
            $poin = $this->hitungPoin(
                $laporan->jenis_laporan,
                $laporan->kondisi_barang,
                $laporan->tanggal_dikembalikan ? new \DateTime($laporan->tanggal_dikembalikan) : null,
                $tanggalJatuhTempo
            );
            $user->points = ($user->points ?? 0) + $poin;
            $user->save();
            $peminjaman->update(['point_earned' => $poin]);

            PointLog::create([
                'id_user' => $user->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'change' => $poin,
                'reason' => 'Laporan dipulihkan (poin dikembalikan)',
            ]);
        }
        // ===============================================================

        $laporan->restore();

        return redirect()->route('reports.trash')->with('success', 'Laporan berhasil dipulihkan. Stok barang dan poin user diperbarui.');
    }

    // FORCE DELETE – hapus permanen + foto
    public function forceDelete($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);
        $peminjaman = Peminjaman::with(['detailPeminjaman.barang', 'user'])->find($laporan->id_peminjaman);

        // ==================== SESUAIKAN STOK (sama seperti soft delete) ====================
        if ($laporan->jenis_laporan !== 'hilang') {
            $this->kurangiStokBarang($peminjaman);
        } else {
            $this->kembalikanStokBarang($peminjaman);
        }
        // =================================================================================

        // Hapus foto jika ada
        if ($laporan->foto_bukti) {
            Storage::disk('public')->delete($laporan->foto_bukti);
        }

        $laporan->forceDelete();

        return redirect()->route('reports.trash')->with('success', 'Laporan berhasil dihapus secara permanen. Stok barang telah disesuaikan.');
    }

    // EXPORT PDF
    public function exportPdf(Request $request)
    {
        $query = Laporan::with(['peminjaman.user', 'peminjaman.detailPeminjaman.barang', 'admin'])->latest();

        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }
        if ($request->filled('kondisi_barang')) {
            $query->where('kondisi_barang', $request->kondisi_barang);
        }

        $laporans = $query->get();

        $pdf = Pdf::loadView('admin.kelola_laporan.export_pdf', compact('laporans'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-' . now()->format('Y-m-d') . '.pdf');
    }

    // EXPORT EXCEL
    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport($request->all()), 'laporan-' . now()->format('Y-m-d') . '.xlsx');
    }

    // =========================================================================
    //  PRIVATE HELPER METHODS
    // =========================================================================

    /**
     * Menambah stok barang berdasarkan detail peminjaman (barang dikembalikan)
     */
    private function kembalikanStokBarang($peminjaman)
    {
        if (!$peminjaman) return;

        foreach ($peminjaman->detailPeminjaman as $detail) {
            $barang = $detail->barang;
            if ($barang) {
                $barang->incrementStock($detail->jumlah);
            }
        }
    }

    /**
     * Mengurangi stok barang berdasarkan detail peminjaman (barang dipinjam/dihilangkan)
     */
    private function kurangiStokBarang($peminjaman)
    {
        if (!$peminjaman) return;

        foreach ($peminjaman->detailPeminjaman as $detail) {
            $barang = $detail->barang;
            if ($barang) {
                $barang->decrementStock($detail->jumlah);
            }
        }
    }

    /**
     * Hitung poin berdasarkan jenis laporan, kondisi barang, dan tanggal
     */
    private function hitungPoin($jenis_laporan, $kondisi_barang, $tanggal_dikembalikan, $tanggal_jatuh_tempo)
    {
        $poin = 0;

        if ($jenis_laporan == 'hilang') {
            return -15;
        }

        // Ketepatan waktu
        if ($jenis_laporan == 'telat mengembalikan') {
            $poin += -3;
        } elseif ($jenis_laporan == 'dikembalikan') {
            if ($tanggal_dikembalikan && $tanggal_jatuh_tempo) {
                if ($tanggal_dikembalikan <= $tanggal_jatuh_tempo) {
                    $poin += 2;
                } else {
                    $poin += -3;
                }
            } else {
                $poin += 2;
            }
        }

        // Kondisi barang
        switch ($kondisi_barang) {
            case 'baik':
                $poin += 3;
                break;
            case 'rusak':
                $poin += -5;
                break;
            case 'masih di pinjam':
                $poin += 0;
                break;
        }

        return $poin;
    }
}
