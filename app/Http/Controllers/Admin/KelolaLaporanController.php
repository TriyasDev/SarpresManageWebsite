<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KelolaLaporanController extends Controller
{
    // ──────────────────────────────────────────────────────────────
    //  INDEX – daftar laporan aktif
    // ──────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Laporan::with(['peminjam.user', 'peminjam.aset', 'admin'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas(
                    'peminjam.user',
                    fn($q2) =>
                    $q2->where('username', 'like', "%$search%")
                )->orWhereHas(
                    'peminjam.aset',
                    fn($q2) =>
                    $q2->where('nama_barang', 'like', "%$search%")
                );
            });
        }

        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }

        if ($request->filled('kondisi_barang')) {
            $query->where('kondisi_barang', $request->kondisi_barang);
        }

        $laporans     = $query->paginate(10)->withQueryString();
        $trashedCount = Laporan::onlyTrashed()->count();

        return view('admin.kelola_laporan.index', compact('laporans', 'trashedCount'));
    }

    // ──────────────────────────────────────────────────────────────
    //  CREATE – form tambah laporan
    // ──────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.kelola_laporan.create');
    }

    // ──────────────────────────────────────────────────────────────
    //  STORE – simpan laporan baru
    // ──────────────────────────────────────────────────────────────
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

        $data = $request->only([
            'id_peminjaman',
            'jenis_laporan',
            'kondisi_barang',
            'tanggal_dipinjam',
            'tanggal_dikembalikan',
        ]);

        $data['id_admin'] = Auth::id();

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')
                ->store('laporan/foto', 'public');
        }

        Laporan::create($data);

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────────────────────
    //  EDIT – form edit laporan
    // ──────────────────────────────────────────────────────────────
    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);

        return view('admin.kelola_laporan.edit', compact('laporan'));
    }

    // ──────────────────────────────────────────────────────────────
    //  UPDATE – simpan perubahan laporan
    // ──────────────────────────────────────────────────────────────
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

        $data = $request->only([
            'jenis_laporan',
            'kondisi_barang',
            'tanggal_dipinjam',
            'tanggal_dikembalikan',
        ]);

        if ($request->hasFile('foto_bukti')) {
            if ($laporan->foto_bukti) {
                Storage::disk('public')->delete($laporan->foto_bukti);
            }
            $data['foto_bukti'] = $request->file('foto_bukti')
                ->store('laporan/foto', 'public');
        }

        $laporan->update($data);

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────────────────
    //  DESTROY – soft delete
    // ──────────────────────────────────────────────────────────────
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan dipindahkan ke tempat sampah.');
    }

    // ──────────────────────────────────────────────────────────────
    //  TRASH – daftar laporan yang dihapus sementara
    // ──────────────────────────────────────────────────────────────
    public function trash(Request $request)
    {
        $search = $request->get('search');

        $laporans = Laporan::onlyTrashed()
            ->with(['peminjam.user', 'peminjam.aset'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas(
                    'peminjam.user',
                    fn($q2) =>
                    $q2->where('username', 'like', "%$search%")
                )->orWhereHas(
                    'peminjam.aset',
                    fn($q2) =>
                    $q2->where('nama_barang', 'like', "%$search%")
                );
            })
            ->latest('deleted_at') // ← fix: was 'delete_at' (typo)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.kelola_laporan.trash', compact('laporans', 'search'));
    }

    // ──────────────────────────────────────────────────────────────
    //  RESTORE – pulihkan laporan dari sampah
    // ──────────────────────────────────────────────────────────────
    public function restore($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);
        $laporan->restore();

        return redirect()->route('reports.trash')
            ->with('success', 'Laporan berhasil dipulihkan.');
    }

    // ──────────────────────────────────────────────────────────────
    //  FORCE DELETE – hapus permanen beserta foto
    // ──────────────────────────────────────────────────────────────
    public function forceDelete($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);

        if ($laporan->foto_bukti) {
            Storage::disk('public')->delete($laporan->foto_bukti);
        }

        $laporan->forceDelete();

        return redirect()->route('reports.trash')
            ->with('success', 'Laporan berhasil dihapus secara permanen.'); // ← fix: was 'sucess'
    }

    // ──────────────────────────────────────────────────────────────
    //  EXPORT PDF
    // ──────────────────────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $query = Laporan::with(['peminjam.user', 'peminjam.aset', 'admin'])->latest();

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

    // ──────────────────────────────────────────────────────────────
    //  EXPORT EXCEL
    // ──────────────────────────────────────────────────────────────
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanExport($request->all()),
            'laporan-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
