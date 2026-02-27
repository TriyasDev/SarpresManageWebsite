<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class KelolaLaporanController extends Controller
{
    // Halaman Utama Tabel Aset
    public function index()
    {
        return view('admin.kelola_laporan.index');
    }

    // // Fungsi simpan (kosongkan dulu logikanya)
    // public function store(Request $request)
    // {
    //     // Logika simpan nanti di sini
    //     return redirect()->back()->with('success', 'Data berhasil ditambah');
    // }

    // // Fungsi update (kosongkan dulu logikanya)
    // public function update(Request $request, $id)
    // {
    //     // Logika update nanti di sini
    //     return redirect()->back()->with('success', 'Data berhasil diupdate');
    // }

    // // Fungsi hapus
    // public function destroy($id)
    // {
    //     // Logika hapus nanti di sini
    //     return redirect()->back()->with('success', 'Data berhasil dihapus');
    // }
}

