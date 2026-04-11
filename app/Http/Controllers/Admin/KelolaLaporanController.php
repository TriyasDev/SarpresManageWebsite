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
    // INDEX – daftar laporan aktif dengan filter lengkap (termasuk tanggal)
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

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_dikembalikan', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_dikembalikan', '<=', $request->end_date);
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

        if (Laporan::where('id_peminjaman', $request->id_peminjaman)->exists()) {
            return back()->withErrors(['id_peminjaman' => 'Peminjaman ini sudah memiliki laporan.'])->withInput();
        }

        $data = $request->only(['id_peminjaman', 'jenis_laporan', 'kondisi_barang', 'tanggal_dipinjam', 'tanggal_dikembalikan']);
        $data['id_admin'] = Auth::id();
        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('laporan/foto', 'public');
        }
        $laporan = Laporan::create($data);

        foreach ($request->details as $detail) {
            $laporan->details()->create([
                'id_barang' => $detail['id_barang'],
                'jumlah_dikembalikan' => $detail['jumlah_dikembalikan'],
            ]);
        }

        if ($request->jenis_laporan !== 'hilang') {
            foreach ($request->details as $detail) {
                $barang = Barang::find($detail['id_barang']);
                if ($barang && $detail['jumlah_dikembalikan'] > 0) {
                    $barang->incrementStock($detail['jumlah_dikembalikan']);
                }
            }
        }

        // Mapping kondisi_barang ke nilai ENUM return_condition
        $returnCondition = $this->mapKondisiBarangToReturnCondition($request->kondisi_barang);

        $peminjaman->update([
            'status' => ($request->jenis_laporan === 'hilang') ? 'hilang' : 'dikembalikan',
            'tanggal_kembali_aktual' => $request->tanggal_dikembalikan ?: now(),
            'return_condition' => $returnCondition,
            'is_late' => ($request->jenis_laporan === 'telat mengembalikan'),
        ]);
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->update(['kondisi_kembali' => $returnCondition]);
        }

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

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    // EDIT – form edit laporan
    public function edit($id)
    {
        $laporan = Laporan::with('details')->findOrFail($id);
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')->find($laporan->id_peminjaman);

        $loanData = null;
        if ($peminjaman) {
            $loanData = [
                'id' => $peminjaman->id_peminjaman,
                'user' => $peminjaman->user->username,
                'barang' => $peminjaman->detailPeminjaman->first()?->barang?->nama_barang ?? '-',
                'tenggat' => $peminjaman->tanggal_kembali->format('d/m/Y'),
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam?->format('Y-m-d\TH:i') ?? '',
                'details' => $peminjaman->detailPeminjaman->map(function ($detail) use ($laporan) {
                    $laporanDetail = $laporan->details->firstWhere('id_barang', $detail->id_barang);
                    return [
                        'id_barang' => $detail->id_barang,
                        'nama_barang' => $detail->barang->nama_barang,
                        'jumlah_pinjam' => $detail->jumlah,
                        'jumlah_dikembalikan' => $laporanDetail ? $laporanDetail->jumlah_dikembalikan : $detail->jumlah,
                    ];
                })->toArray()
            ];
        }

        return view('admin.kelola_laporan.edit', compact('laporan', 'peminjaman', 'loanData'));
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
            'details.*.jumlah_dikembalikan' => 'required|integer|min:1',
        ]);

        foreach ($request->details as $detail) {
            $detailPinjam = $peminjaman->detailPeminjaman->firstWhere('id_barang', $detail['id_barang']);
            if (!$detailPinjam) {
                return back()->withErrors(['details' => 'Barang tidak valid.'])->withInput();
            }
            if ($detail['jumlah_dikembalikan'] > $detailPinjam->jumlah) {
                return back()->withErrors(["details.{$detail['id_barang']}" => "Jumlah dikembalikan melebihi jumlah pinjam."])->withInput();
            }
        }

        $oldDetails = $laporan->details->keyBy('id_barang');
        $oldJenis = $laporan->jenis_laporan;
        $oldKondisi = $laporan->kondisi_barang;
        $oldTglKembali = $laporan->tanggal_dikembalikan;

        $data = $request->only(['jenis_laporan', 'kondisi_barang', 'tanggal_dipinjam', 'tanggal_dikembalikan']);
        if ($request->hasFile('foto_bukti')) {
            if ($laporan->foto_bukti) Storage::disk('public')->delete($laporan->foto_bukti);
            $data['foto_bukti'] = $request->file('foto_bukti')->store('laporan/foto', 'public');
        }
        $laporan->update($data);

        foreach ($request->details as $detail) {
            $existing = $laporan->details->firstWhere('id_barang', $detail['id_barang']);
            if ($existing) {
                $existing->update(['jumlah_dikembalikan' => $detail['jumlah_dikembalikan']]);
            } else {
                $laporan->details()->create($detail);
            }
        }
        $currentIds = collect($request->details)->pluck('id_barang')->toArray();
        $laporan->details()->whereNotIn('id_barang', $currentIds)->delete();

        if ($oldJenis !== 'hilang') {
            foreach ($oldDetails as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang && $detail->jumlah_dikembalikan > 0) {
                    $barang->decrementStock($detail->jumlah_dikembalikan);
                }
            }
        }
        if ($request->jenis_laporan !== 'hilang') {
            foreach ($request->details as $detail) {
                $barang = Barang::find($detail['id_barang']);
                if ($barang && $detail['jumlah_dikembalikan'] > 0) {
                    $barang->incrementStock($detail['jumlah_dikembalikan']);
                }
            }
        }

        $newStatus = ($request->jenis_laporan === 'hilang') ? 'hilang' : 'dikembalikan';
        $returnCondition = $this->mapKondisiBarangToReturnCondition($request->kondisi_barang);

        $peminjaman->update([
            'status' => $newStatus,
            'tanggal_kembali_aktual' => $request->tanggal_dikembalikan ?: now(),
            'return_condition' => $returnCondition,
            'is_late' => ($request->jenis_laporan === 'telat mengembalikan'),
        ]);
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->update(['kondisi_kembali' => $returnCondition]);
        }

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
        $laporan = Laporan::findOrFail($id);
        $peminjaman = Peminjaman::with(['detailPeminjaman.barang', 'user'])->find($laporan->id_peminjaman);

        if ($laporan->jenis_laporan !== 'hilang') {
            $this->kurangiStokBarang($peminjaman);
        } else {
            $this->kembalikanStokBarang($peminjaman);
        }

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
            $peminjaman->update(['point_earned' => 0]);
            PointLog::create([
                'id_user' => $user->id_user,
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'change' => -$poinYangDiberikan,
                'reason' => 'Laporan dihapus (poin dikembalikan)',
            ]);
        }

        $peminjaman->update([
            'status' => 'dipinjam',
            'tanggal_kembali_aktual' => null,
            'return_condition' => null,
            'is_late' => 0,
        ]);

        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->update(['kondisi_kembali' => null]);
        }

        $laporan->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan dipindahkan ke tempat sampah.');
    }

    // TRASH
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

    // RESTORE
    public function restore($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);
        $peminjaman = Peminjaman::with(['detailPeminjaman.barang', 'user'])->find($laporan->id_peminjaman);

        if ($laporan->jenis_laporan !== 'hilang') {
            $this->kembalikanStokBarang($peminjaman);
        } else {
            $this->kurangiStokBarang($peminjaman);
        }

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

        $newStatus = ($laporan->jenis_laporan === 'hilang') ? 'hilang' : 'dikembalikan';
        $returnCondition = $this->mapKondisiBarangToReturnCondition($laporan->kondisi_barang);

        $peminjaman->update([
            'status' => $newStatus,
            'tanggal_kembali_aktual' => $laporan->tanggal_dikembalikan ?: now(),
            'return_condition' => $returnCondition,
            'is_late' => ($laporan->jenis_laporan === 'telat mengembalikan'),
        ]);

        foreach ($peminjaman->detailPeminjaman as $detail) {
            $detail->update(['kondisi_kembali' => $returnCondition]);
        }

        $laporan->restore();

        return redirect()->route('reports.trash')->with('success', 'Laporan berhasil dipulihkan.');
    }

    // FORCE DELETE
    public function forceDelete($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);
        $peminjaman = Peminjaman::with(['detailPeminjaman.barang', 'user'])->find($laporan->id_peminjaman);

        if ($laporan->jenis_laporan !== 'hilang') {
            $this->kurangiStokBarang($peminjaman);
        } else {
            $this->kembalikanStokBarang($peminjaman);
        }

        if ($laporan->foto_bukti) {
            Storage::disk('public')->delete($laporan->foto_bukti);
        }

        $laporan->forceDelete();

        return redirect()->route('reports.trash')->with('success', 'Laporan dihapus permanen.');
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
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_dikembalikan', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_dikembalikan', '<=', $request->end_date);
        }

        $laporans = $query->get();

        $pdf = Pdf::loadView('admin.kelola_laporan.export_pdf', compact('laporans'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-' . now()->format('Y-m-d') . '.pdf');
    }

    // EXPORT EXCEL
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['jenis_laporan', 'kondisi_barang', 'start_date', 'end_date']);
        return Excel::download(new LaporanExport($filters), 'laporan-' . now()->format('Y-m-d') . '.xlsx');
    }

    // ==================== PRIVATE HELPERS ====================

    /**
     * Memetakan nilai kondisi_barang dari form laporan ke nilai yang valid untuk kolom return_condition (ENUM)
     */
    private function mapKondisiBarangToReturnCondition($kondisi_barang)
    {
        return match ($kondisi_barang) {
            'baik' => 'baik',
            'rusak' => 'rusak_berat',     // asumsi rusak berat
            'masih di pinjam' => 'baik',  // asumsi kondisi baik karena tidak ada informasi
            default => 'baik',
        };
    }

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

    private function hitungPoin($jenis_laporan, $kondisi_barang, $tanggal_dikembalikan, $tanggal_jatuh_tempo)
    {
        $poin = 0;

        if ($jenis_laporan == 'hilang') {
            return -15;
        }

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
