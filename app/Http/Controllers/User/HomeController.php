<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList   = Barang::whereNull('deleted_at')
                            ->distinct()
                            ->pluck('kategori')
                            ->sort()
                            ->values();

        $activeKategori = $request->get('kategori', '');

        $barangs = Barang::whereNull('deleted_at')
            ->when($activeKategori, fn($q) => $q->where('kategori', $activeKategori))
            ->latest()
            ->get();

        $popularItems = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->orderByDesc('jumlah_tersedia')
            ->limit(3)
            ->get();

        return view('user.home', compact(
            'barangs', 'popularItems', 'kategoriList', 'activeKategori'
        ));
    }
}
