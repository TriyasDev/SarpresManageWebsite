<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaAsetController extends Controller
{
    // ──────────────────────────────────────────────────────────────
    //  INDEX – daftar aset aktif (card grid)
    // ──────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $kategori = $request->input('kategori');
        $kondisi  = $request->input('kondisi'); // baru

        $query = Barang::query();

        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        if ($kondisi) { // baru
            $query->where('kondisi', $kondisi);
        }

        $barangs = $query->latest()->paginate(12)->withQueryString();
        $trashedCount = Barang::onlyTrashed()->count();

        return view('admin.kelola_aset.index', compact('barangs', 'trashedCount'));
    }

    // ──────────────────────────────────────────────────────────────
    //  CREATE – form tambah aset
    // ──────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.kelola_aset.create');
    }

    // ──────────────────────────────────────────────────────────────
    //  STORE – simpan aset baru
    // ──────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori'    => 'required|string|max:100',
            'kondisi'     => 'required|in:baik,rusak ringan,rusak berat',
            'jumlah'      => 'required|integer|min:1',
            'deskripsi'   => 'required|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('barang', 'public');
        }

        Barang::create([
            'nama_barang'     => $request->nama_barang,
            'kategori'        => $request->kategori,
            'kondisi'         => $request->kondisi,
            'jumlah_total'    => $request->jumlah,
            'jumlah_tersedia' => $request->jumlah,
            'deskripsi'       => $request->deskripsi,
            'foto'            => $fotoPath,
        ]);

        return redirect()->route('assets.index')
            ->with('success', 'Aset berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────────────────────
    //  EDIT – form edit aset
    // ──────────────────────────────────────────────────────────────
    public function edit(Barang $barang)
    {
        return view('admin.kelola_aset.edit', compact('barang'));
    }

    // ──────────────────────────────────────────────────────────────
    //  UPDATE – simpan perubahan aset
    // ──────────────────────────────────────────────────────────────
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori'    => 'required|string|max:100',
            'kondisi'     => 'required|in:baik,rusak ringan,rusak berat',
            'jumlah'      => 'required|integer|min:1',
            'deskripsi'   => 'required|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fotoPath = $barang->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('barang', 'public');
        }

        $barang->update([
            'nama_barang'     => $request->nama_barang,
            'kategori'        => $request->kategori,
            'kondisi'         => $request->kondisi,
            'jumlah_total'    => $request->jumlah,
            'jumlah_tersedia' => $request->jumlah,
            'deskripsi'       => $request->deskripsi,
            'foto'            => $fotoPath,
        ]);

        return redirect()->route('assets.index')
            ->with('success', 'Aset berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────────────────
    //  DESTROY – soft delete
    // ──────────────────────────────────────────────────────────────
    public function destroy(Barang $barang)
    {
        $barang->delete(); // soft delete — foto tetap ada di storage

        return redirect()->route('assets.index')
            ->with('success', 'Aset dipindahkan ke tempat sampah.');
    }

    // ──────────────────────────────────────────────────────────────
    //  TRASH – daftar aset yang dihapus sementara
    // ──────────────────────────────────────────────────────────────
    public function trash(Request $request)
    {
        $search = $request->get('search');

        $trashedBarangs = Barang::onlyTrashed()
            ->when($search, fn($q) => $q->where('nama_barang', 'like', "%{$search}%"))
            ->latest('deleted_at')
            ->paginate(12)
            ->appends($request->query());

        return view('admin.kelola_aset.trash', compact('trashedBarangs', 'search'));
    }

    // ──────────────────────────────────────────────────────────────
    //  RESTORE – pulihkan aset dari sampah
    // ──────────────────────────────────────────────────────────────
    public function restore($id)
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);
        $barang->restore();

        return redirect()->route('assets.trash')
            ->with('success', 'Aset berhasil dipulihkan.');
    }

    // ──────────────────────────────────────────────────────────────
    //  FORCE DELETE – hapus permanen beserta fotonya
    // ──────────────────────────────────────────────────────────────
    public function forceDelete($id)
    {
        $barang = Barang::onlyTrashed()->findOrFail($id);

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->forceDelete();

        return redirect()->route('assets.trash')
            ->with('success', 'Aset berhasil dihapus secara permanen.');
    }
}
