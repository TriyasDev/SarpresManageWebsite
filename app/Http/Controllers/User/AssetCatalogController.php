<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class AssetCatalogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dan pencarian
        $activeKategori = $request->get('kategori', '');
        $search = $request->get('search', '');

        // Daftar kategori unik (untuk tombol filter)
        $kategoriList = Barang::whereNull('deleted_at')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        // Query aset
        $barangs = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->when($activeKategori, fn($q) => $q->where('kategori', $activeKategori))
            ->when($search, fn($q) => $q->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            }))
            ->orderBy('nama_barang')
            ->paginate(12)
            ->withQueryString(); // Mempertahankan query string saat paginasi

        // Kirim semua variabel ke view
        return view('user.catalog', compact('barangs', 'kategoriList', 'activeKategori', 'search'));
    }
}
