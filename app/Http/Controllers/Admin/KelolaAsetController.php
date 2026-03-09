<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaAsetController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->get();
        return view('admin.kelola_aset.index', compact('barangs'));
    }

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

        return redirect()->route('admin.kelola_aset')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

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

        return redirect()->route('admin.kelola_aset')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('admin.kelola_aset')->with('success', 'Aset berhasil dihapus.');
    }
}
