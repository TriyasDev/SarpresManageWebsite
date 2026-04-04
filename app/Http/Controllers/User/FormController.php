<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function index($barangId = null)
    {
        $user = Auth::user();
        $barang = null;
        if ($barangId) {
            $barang = Barang::where('id_barang', $barangId)
                ->whereNull('deleted_at')
                ->firstOrFail();
        }

        // Jika tidak ada barang spesifik, ambil semua barang yang tersedia
        $barangs = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->get();

        return view('user.form', compact('user', 'barang', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'      => 'required|exists:tb_barang,id_barang',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali'=> 'required|date|after:tanggal_pinjam',
            'keperluan'      => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $barang = Barang::findOrFail($request->barang_id);

        // Cek stok
        if ($barang->jumlah_tersedia < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi.']);
        }

        // Cek batas peminjaman aktif (opsional, sesuai tier)
        $activeLoans = Peminjaman::where('id_user', $user->id_user)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->count();
        if ($activeLoans >= $user->max_items) {
            return back()->withErrors(['msg' => "Anda hanya bisa meminjam maksimal {$user->max_items} item sekaligus."]);
        }

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_user'           => $user->id_user,
                'id_admin'          => null,
                'tanggal_pinjam'    => $request->tanggal_pinjam,
                'tanggal_kembali'   => $request->tanggal_kembali,
                'status'            => 'menunggu',
                'catatan'           => $request->keperluan,
            ]);

            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_barang'     => $barang->id_barang,
                'jumlah'        => $request->jumlah,
            ]);

            DB::commit();
            return redirect()->route('my.dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
