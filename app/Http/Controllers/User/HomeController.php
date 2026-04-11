<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->guest()) {
            return view('user.home', [
                'popularCategories' => [],
                'activeKategori' => '',
                'popularItems' => collect(),
            ]);
        }

        // Ambil 5 kategori terpopuler berdasarkan jumlah peminjaman
        $popularCategories = Peminjaman::select('tb_barang.kategori', DB::raw('COUNT(*) as total'))
            ->join('tb_detail_peminjaman', 'tb_peminjaman.id_peminjaman', '=', 'tb_detail_peminjaman.id_peminjaman')
            ->join('tb_barang', 'tb_detail_peminjaman.id_barang', '=', 'tb_barang.id_barang')
            ->whereNull('tb_barang.deleted_at')
            ->groupBy('tb_barang.kategori')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('tb_barang.kategori')
            ->toArray();

        // Jika belum ada data peminjaman, ambil 5 kategori pertama dari barang
        if (empty($popularCategories)) {
            $popularCategories = Barang::whereNull('deleted_at')
                ->distinct()
                ->pluck('kategori')
                ->sort()
                ->take(5)
                ->values()
                ->toArray();
        }

        $activeKategori = $request->get('kategori', $popularCategories[0] ?? '');

        // Data untuk section "Pinjam Sekarang" (9 aset tersedia terbanyak)
        $popularItems = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->inRandomOrder()
            ->limit(9)
            ->get();

        return view('user.home', compact(
            'popularCategories',
            'activeKategori',
            'popularItems'
        ));
    }

    /**
     * Endpoint JSON untuk AJAX: ambil grid aset + pagination
     */
    public function getAssetsJson(Request $request)
    {

        if (auth()->guest()) {
            return response()->json([
                'html' => '<div class="text-center py-12 text-slate-500">Silakan <a href="' . route('auth.login') . '" class="text-costume-primary underline">login</a> untuk melihat aset.</div>',
                'pagination' => ''
            ]);
        }

        $kategori = $request->get('kategori');
        $page = $request->get('page', 1);
        $perPage = 12;

        $barangs = Barang::whereNull('deleted_at')
            ->when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->orderBy('nama_barang')
            ->paginate($perPage, ['*'], 'page', $page);

        $html = view('components.asset-grid', ['barangs' => $barangs])->render();
        $pagination = $barangs->links('pagination::tailwind')->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $barangs->total()
        ]);
    }
}
