<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Exports\LaporanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KelolaLaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with(['peminjam.user', 'peminjam.aset', 'admin'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('peminjam.user', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%$search%");
                })->orWhereHas('peminjam.aset', function ($q2) use ($search) {
                    $q2->where('nama_aset', 'like', "%$search%");
                });
            });
        }

        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }

        if ($request->filled('kondisi_barang')) {
            $query->where('kondisi_barang', $request->kondisi_barang);
        }

        /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $laporans */
        $laporans = $query->paginate(10)->withQueryString();

        return view('admin.kelola_laporan.index', compact('laporans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'       => 'required|exists:tb_peminjaman,id_peminjaman',
            'jenis_laporan'       => 'required|in:dikembalikan,telat mengembalikan,hilang',
            'kondisi_barang'      => 'required|in:baik,masih di pinjam,rusak',
            'tanggal_dipinjam'    => 'nullable|date',
            'tanggal_dikembalikan' => 'nullable|date',
            'foto_bukti'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'id_peminjaman',
            'jenis_laporan',
            'kondisi_barang',
            'tanggal_dipinjam',
            'tanggal_dikembalikan',
        ]);

        $data['id_admin'] = Auth::id();

        // Upload foto bukti
        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')
                ->store('laporan/foto', 'public');
        }

        Laporan::create($data);

        return redirect()->route('admin.kelola_laporan')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $laporan = Laporan::with(['peminjaman.user', 'peminjaman.aset', 'admin'])
            ->findOrFail($id);

        return view('admin.kelola_aset.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('admin.kelola_aset.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'jenis_laporan'       => 'required|in:dikembalikan,telat mengembalikan,hilang',
            'kondisi_barang'      => 'required|in:baik,masih di pinjam,rusak',
            'tanggal_dipinjam'    => 'nullable|date',
            'tanggal_dikembalikan' => 'nullable|date',
            'foto_bukti'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'jenis_laporan',
            'kondisi_barang',
            'tanggal_dipinjam',
            'tanggal_dikembalikan',
        ]);

        // Ganti foto jika ada upload baru
        if ($request->hasFile('foto_bukti')) {
            // Hapus foto lama
            if ($laporan->foto_bukti) {
                Storage::disk('public')->delete($laporan->foto_bukti);
            }
            $data['foto_bukti'] = $request->file('foto_bukti')
                ->store('laporan/foto', 'public');
        }

        $laporan->update($data);

        return redirect()->route('admin.kelola_laporan')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.kelola_laporan')
            ->with('success', 'Laporan dipindahkan ke trash.');
    }

    public function trash()
    {
        $laporans = Laporan::onlyTrashed()
            ->with(['peminjam.user', 'peminjam.aset'])
            ->latest('delete_at')
            ->paginate(10);

        return view('admin.kelola_laporan.trash', compact('laporans'));
    }

    public function restore($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);
        $laporan->restore();

        return redirect()->route('admin.kelola_laporan.trash')
            ->with('success', 'Laporan berhasil dipulihkan');
    }

    public function forceDelete($id)
    {
        $laporan = Laporan::onlyTrashed()->findOrFail($id);

        if ($laporan->foto_bukti) {
            Storage::disk('public')->delete($laporan->foto_bukti);
        }

        $laporan->forceDelete();

        return redirect()->route('admin.kelola_laporan.trash')
            ->with('sucess', 'Laporan berhasil di hapus permanen.');
    }

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

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanExport($request->all()),
            'laporan-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
