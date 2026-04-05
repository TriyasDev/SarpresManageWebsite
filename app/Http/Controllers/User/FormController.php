<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Carbon\Carbon;
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

        $barangs = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->get();
            
        $activeItemsCount = $this->countActiveItems($user->id_user);

        return view('user.form', compact('user', 'barang', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'      => 'required|exists:tb_barang,id_barang',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:today',
            'keperluan'      => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $barang = Barang::findOrFail($request->barang_id);
        $today = Carbon::today();

        // =============================================================
        // ATURAN DARI PROPOSAL
        // =============================================================

        // 1. Cek apakah user dibekukan (is_banned)
        if ($user->is_banned) {
            return back()->withErrors(['msg' => 'Akun Anda sedang dibekukan. Hubungi admin.']);
        }

        // 2. Cek stok barang
        if ($barang->jumlah_tersedia < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi. Tersedia: ' . $barang->jumlah_tersedia]);
        }

        // 3. Cek durasi maksimal berdasarkan tier
        $maxDays = $user->max_days; // dari model User
        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $durationDays = $today->diffInDays($tanggalKembali);

        if ($durationDays > $maxDays) {
            return back()->withErrors([
                'tanggal_kembali' => "Tier {$user->tier} hanya boleh meminjam maksimal {$maxDays} hari. Anda memilih {$durationDays} hari."
            ]);
        }

        // 4. Hitung total item yang sedang aktif dipinjam (status disetujui atau dipinjam)
        $activeItemsCount = $this->countActiveItems($user->id_user);
        $maxItems = $user->max_items;
        $requestedItems = $request->jumlah;

        if (($activeItemsCount + $requestedItems) > $maxItems) {
            $sisa = $maxItems - $activeItemsCount;
            return back()->withErrors([
                'jumlah' => "Batas maksimal barang yang bisa dipinjam adalah {$maxItems} item (tier {$user->tier}). Saat ini Anda sudah meminjam {$activeItemsCount} item. Sisa kuota: {$sisa} item."
            ]);
        }

        // 5. Cek batas barang elektronik
        $maxElectronics = $user->max_electronics;
        if ($barang->isElectronic()) {
            if ($maxElectronics == 0) {
                return back()->withErrors([
                    'barang_id' => "Tier {$user->tier} tidak diizinkan meminjam barang elektronik."
                ]);
            }

            $activeElectronicsCount = $this->countActiveElectronics($user->id_user);
            $newTotal = $activeElectronicsCount + $requestedItems;
            if ($newTotal > $maxElectronics) {
                $sisaElec = $maxElectronics - $activeElectronicsCount;
                return back()->withErrors([
                    'barang_id' => "Batas elektronik untuk tier {$user->tier} adalah {$maxElectronics}. Anda sudah meminjam {$activeElectronicsCount} elektronik. Sisa kuota: {$sisaElec}."
                ]);
            }
        }

        // 6. Cek apakah ada pinjaman yang lewat jatuh tempo
        if ($user->hasOverdueItems()) {
            return back()->withErrors([
                'msg' => 'Anda masih memiliki pinjaman yang melewati batas waktu. Harap kembalikan terlebih dahulu.'
            ]);
        }

        // =============================================================
        // SIMPAN PEMINJAMAN (tanggal_pinjam otomatis hari ini)
        // =============================================================
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_user'           => $user->id_user,
                'id_admin'          => null,
                'tanggal_pinjam'    => $today, // otomatis hari ini
                'tanggal_kembali'   => $tanggalKembali,
                'status'            => 'menunggu',
                'catatan'           => $request->keperluan,
            ]);

            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_barang'     => $barang->id_barang,
                'jumlah'        => $request->jumlah,
                'kondisi_pinjam' => $barang->kondisi,
            ]);

            DB::commit();
            return redirect()->route('my.dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hitung total item (jumlah barang) yang sedang aktif dipinjam user
     */
    private function countActiveItems($userId)
    {
        $activeLoans = Peminjaman::where('id_user', $userId)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->with('detailPeminjaman')
            ->get();

        $totalItems = 0;
        foreach ($activeLoans as $loan) {
            foreach ($loan->detailPeminjaman as $detail) {
                $totalItems += $detail->jumlah;
            }
        }
        return $totalItems;
    }

    /**
     * Hitung total barang elektronik yang sedang aktif dipinjam
     */
    private function countActiveElectronics($userId)
    {
        $activeLoans = Peminjaman::where('id_user', $userId)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->with('detailPeminjaman.barang')
            ->get();

        $totalElectronic = 0;
        foreach ($activeLoans as $loan) {
            foreach ($loan->detailPeminjaman as $detail) {
                if ($detail->barang && $detail->barang->isElectronic()) {
                    $totalElectronic += $detail->jumlah;
                }
            }
        }
        return $totalElectronic;
    }
}
