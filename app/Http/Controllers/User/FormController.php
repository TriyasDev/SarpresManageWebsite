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
    /**
     * Show the borrowing form, pre-filled with user data.
     *
     * @param int|null $barangId
     * @return \Illuminate\View\View
     */
    public function index($barangId = null)
    {
        $user = Auth::user();

        $barang = null;
        if ($barangId) {
            $barang = Barang::where('id_barang', $barangId)
                ->whereNull('deleted_at')
                ->firstOrFail();
        }

        // If no specific asset, fetch all available assets for the dropdown
        $barangs = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->get();

        return view('user.form', compact('user', 'barang', 'barangs'));
    }

    /**
     * Store a new loan request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id'     => 'required|exists:tb_barang,id_barang',
            'jumlah'        => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'keperluan'     => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $barang = Barang::findOrFail($request->barang_id);

        // Check stock
        if ($barang->jumlah_tersedia < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Jumlah yang diminta melebihi stok tersedia.']);
        }

        // Begin transaction
        DB::beginTransaction();
        try {
            // 1. Create Peminjaman record
            $peminjaman = Peminjaman::create([
                'id_user'           => $user->id_user,
                'id_admin'          => null,         // not approved yet
                'tanggal_pinjam'    => $request->tanggal_pinjam,
                'tanggal_kembali'   => $request->tanggal_kembali,
                'tanggal_kembali_aktual' => null,
                'status'            => 'pending',
                'catatan'           => $request->keperluan,
                'disetujui_oleh'    => null,
                'point'             => 0,
            ]);

            // 2. Create DetailPeminjaman record
            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_barang'     => $barang->id_barang,
                'jumlah'        => $request->jumlah,
            ]);

            // 3. (Optional) Reduce temporary stock? Usually only after approval.
            // We'll keep stock untouched until admin approves.

            DB::commit();

            return redirect()->route('my.dashboard')
                ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
