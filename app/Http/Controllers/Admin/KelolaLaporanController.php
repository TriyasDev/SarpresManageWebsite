<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Peminjaman;
use App\Models\User;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

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
                    'tanggal_pinjam' => $loan->tanggal_pinjam?->format('Y-m-d\TH:i') ?? ''
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
        ]);

        // Cek apakah sudah ada laporan untuk peminjaman ini (opsional)
        $existing = Laporan::where('id_peminjaman', $request->id_peminjaman)->first();
        if ($existing) {
            return redirect()->back()->withErrors(['id_peminjaman' => 'Peminjaman ini sudah memiliki laporan.'])->withInput();
        }

        $data = $request->only([
            'id_peminjaman',
            'jenis_laporan',
            'kondisi_barang',
            'tanggal_dipinjam',
            'tanggal_dikembalikan',
        ]);
        $data['id_admin'] = Auth::id();

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('laporan/foto', 'public');
        }

        $laporan = Laporan::create($data);

        // === HITUNG DAN TAMBAH POIN UNTUK USER ===
        $peminjaman = Peminjaman::with('user')->find($request->id_peminjaman);
        if ($peminjaman && $peminjaman->user) {
            $user = $peminjaman->user;
            $tanggalJatuhTempo = $peminjaman->tanggal_kembali; // dari tabel peminjaman
            $tanggalDikembalikan = $request->tanggal_dikembalikan ? new \DateTime($request->tanggal_dikembalikan) : null;

            $poin = $this->hitungPoin(
                $request->jenis_laporan,
                $request->kondisi_barang,
                $tanggalDikembalikan,
                $tanggalJatuhTempo
            );

            // Tambahkan poin ke user
            $user->points = ($user->points ?? 0) + $poin;
            $user->save();

            // (Opsional) Simpan riwayat poin di tabel terpisah
            // \App\Models\PoinHistory::create([...]);
        }
        // ======================================

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil ditambahkan. Poin user telah diperbarui.');
    }

    // EDIT – form edit laporan
    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('admin.kelola_laporan.edit', compact('laporan'));
    }

    // UPDATE – simpan perubahan laporan
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'jenis_laporan'        => 'required|in:dikembalikan,telat mengembalikan,hilang',
            'kondisi_barang'       => 'required|in:baik,masih di pinjam,rusak',
            'tanggal_dipinjam'     => 'nullable|date',
            'tanggal_dikembalikan' => 'nullable|date',
            'foto_bukti'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Ambil data lama sebelum diubah
        $oldData = $laporan->only(['jenis_laporan', 'kondisi_barang', 'tanggal_dikembalikan']);
        $oldPeminjaman = Peminjaman::with('user')->find($laporan->id_peminjaman);

        $data = $request->only(['jenis_laporan', 'kondisi_barang', 'tanggal_dipinjam', 'tanggal_dikembalikan']);

        if ($request->hasFile('foto_bukti')) {
            if ($laporan->foto_bukti) {
                Storage::disk('public')->delete($laporan->foto_bukti);
            }
            $data['foto_bukti'] = $request->file('foto_bukti')->store('laporan/foto', 'public');
        }

        $laporan->update($data);

        // === UPDATE POIN USER ===
        if ($oldPeminjaman && $oldPeminjaman->user) {
            $user = $oldPeminjaman->user;
            $tanggalJatuhTempo = $oldPeminjaman->tanggal_kembali;

            // Hitung poin lama (sebelum update)
            $poinLama = $this->hitungPoin(
                $oldData['jenis_laporan'],
                $oldData['kondisi_barang'],
                $oldData['tanggal_dikembalikan'] ? new \DateTime($oldData['tanggal_dikembalikan']) : null,
                $tanggalJatuhTempo
            );

            // Hitung poin baru
            $poinBaru = $this->hitungPoin(
                $request->jenis_laporan,
                $request->kondisi_barang,
                $request->tanggal_dikembalikan ? new \DateTime($request->tanggal_dikembalikan) : null,
                $tanggalJatuhTempo
            );

            // Koreksi poin: kurangi poin lama, tambah poin baru
            $user->points = ($user->points ?? 0) - $poinLama + $poinBaru;
            $user->save();
        }
        // =================================

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui. Poin user telah disesuaikan.');
    }

    // DESTROY – soft delete
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $peminjaman = Peminjaman::with('user')->find($laporan->id_peminjaman);

        if ($peminjaman && $peminjaman->user) {
            $user = $peminjaman->user;
            $tanggalJatuhTempo = $peminjaman->tanggal_kembali;
            $poinYangDiberikan = $this->hitungPoin(
                $laporan->jenis_laporan,
                $laporan->kondisi_barang,
                $laporan->tanggal_dikembalikan ? new \DateTime($laporan->tanggal_dikembalikan) : null,
                $tanggalJatuhTempo
            );
            // Kembalikan poin karena laporan dihapus
            $user->points = ($user->points ?? 0) - $poinYangDiberikan;
            $user->save();
        }

        $laporan->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan dipindahkan ke tempat sampah. Poin user dikembalikan.');
    }

    // TRASH – daftar laporan di sampah
    public function trash(Request $request)
    {
        $search = $request->get('search');

        $laporans = Laporan::onlyTrashed()
            ->with(['peminjaman.user', 'peminjaman.detailPeminjaman.barang'])  // relasi yang benar
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
        $peminjaman = Peminjaman::with('user')->find($laporan->id_peminjaman);

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
        }

        $laporan->restore();

        return redirect()->route('reports.trash')->with('success', 'Laporan berhasil dipulihkan. Poin user diperbarui.');
    }

    // FORCE DELETE – hapus permanen + foto
    public function forceDelete($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);

        if ($laporan->foto_bukti) {
            Storage::disk('public')->delete($laporan->foto_bukti);
        }

        $laporan->forceDelete();

        return redirect()->route('reports.trash')->with('success', 'Laporan berhasil dihapus secara permanen.');
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

    private function hitungPoin($jenis_laporan, $kondisi_barang, $tanggal_dikembalikan, $tanggal_jatuh_tempo)
    {
        $poin = 0;

        // Jika hilang, langsung -15 tanpa cek lainnya
        if ($jenis_laporan == 'hilang') {
            return -15;
        }

        // 1. Ketepatan waktu
        if ($jenis_laporan == 'telat mengembalikan') {
            $poin += -3; // telat
        } elseif ($jenis_laporan == 'dikembalikan') {
            // Cek apakah benar-benar tepat waktu berdasarkan tanggal
            if ($tanggal_dikembalikan && $tanggal_jatuh_tempo) {
                if ($tanggal_dikembalikan <= $tanggal_jatuh_tempo) {
                    $poin += 2; // tepat waktu
                } else {
                    $poin += -3; // sebenarnya telat, tapi mungkin admin salah pilih jenis? tetap ikuti aturan
                }
            } else {
                // fallback: jika tidak ada tanggal, asumsikan tepat waktu? sebaiknya diisi
                $poin += 2;
            }
        }

        // 2. Kondisi barang
        switch ($kondisi_barang) {
            case 'baik':
                $poin += 3;
                break;
            case 'rusak':
                $poin += -5;
                break;
            case 'masih di pinjam':
                // Tidak dapat poin karena belum dikembalikan
                $poin += 0;
                break;
        }

        return $poin;
    }
}
