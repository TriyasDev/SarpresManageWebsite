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
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    public function index($barangId = null)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $barang = null;
        if ($barangId) {
            $barang = Barang::where('id_barang', $barangId)
                ->whereNull('deleted_at')
                ->firstOrFail();
        }

        $barangs = Barang::whereNull('deleted_at')
            ->where('jumlah_tersedia', '>', 0)
            ->get();

        // Hitung item aktif yang sedang dipinjam
        $activeItemsCount = $this->countActiveItems($user->id_user);

        return view('user.form', compact('user', 'barang', 'barangs', 'activeItemsCount'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'barang_id'      => 'required|exists:tb_barang,id_barang',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_kembali'=> 'required|date|after:today',
            'keperluan'      => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login.');
        }

        $barang = Barang::findOrFail($request->barang_id);
        $today = Carbon::today();

        // -----------------------------------------------------------------
        // 1. Cek banned
        if ($user->is_banned) {
            return back()->withErrors(['msg' => 'Akun Anda sedang dibekukan. Hubungi admin.'])->withInput();
        }

        // 2. Cek stok
        if ($barang->jumlah_tersedia < $request->jumlah) {
            return back()->withErrors(['jumlah' => "Stok tidak cukup. Tersedia: {$barang->jumlah_tersedia}."])->withInput();
        }

        // 3. Cek durasi maksimal (max_days)
        $maxDays = $user->max_days;
        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $durationDays = $today->diffInDays($tanggalKembali);
        if ($durationDays > $maxDays) {
            return back()->withErrors(['tanggal_kembali' => "Tier {$user->tier} maksimal pinjam {$maxDays} hari. Anda memilih {$durationDays} hari."])->withInput();
        }

        // 4. Cek total item aktif + item yang diajukan
        $activeItemsCount = $this->countActiveItems($user->id_user);
        $maxItems = $user->max_items;
        $requestedItems = $request->jumlah;
        if (($activeItemsCount + $requestedItems) > $maxItems) {
            $sisa = $maxItems - $activeItemsCount;
            return back()->withErrors(['jumlah' => "Batas maksimal barang adalah {$maxItems} (tier {$user->tier}). Anda sudah meminjam {$activeItemsCount}. Sisa kuota: {$sisa}."])->withInput();
        }

        // 5. Cek batas elektronik
        $maxElectronics = $user->max_electronics;
        if ($barang->isElectronic()) {
            if ($maxElectronics == 0) {
                return back()->withErrors(['barang_id' => "Tier {$user->tier} tidak boleh meminjam barang elektronik."])->withInput();
            }
            $activeElectronicsCount = $this->countActiveElectronics($user->id_user);
            if (($activeElectronicsCount + $requestedItems) > $maxElectronics) {
                $sisaElec = $maxElectronics - $activeElectronicsCount;
                return back()->withErrors(['barang_id' => "Batas elektronik tier {$user->tier} adalah {$maxElectronics}. Anda sudah meminjam {$activeElectronicsCount}. Sisa kuota: {$sisaElec}."])->withInput();
            }
        }

        // 6. Cek overdue
        if ($user->hasOverdueItems()) {
            return back()->withErrors(['msg' => 'Anda masih memiliki pinjaman yang terlambat. Selesaikan terlebih dahulu.'])->withInput();
        }

        // -----------------------------------------------------------------
        // Simpan ke database
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_user'         => $user->id_user,
                'id_admin'        => null,
                'tanggal_pinjam'  => $today,
                'tanggal_kembali' => $tanggalKembali,
                'status'          => 'menunggu',
                'catatan'         => $request->keperluan,
            ]);

            // Data detail peminjaman
            $detailData = [
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_barang'     => $barang->id_barang,
                'jumlah'        => $request->jumlah,
            ];
            // Jika kolom kondisi_pinjam ada, isi (optional)
            if (\Schema::hasColumn('tb_detail_peminjaman', 'kondisi_pinjam')) {
                $detailData['kondisi_pinjam'] = $barang->kondisi;
            }
            DetailPeminjaman::create($detailData);

            DB::commit();

            return redirect()->route('my.dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim. Tunggu persetujuan admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error store peminjaman: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }

    private function countActiveItems($userId)
    {
        $activeLoans = Peminjaman::where('id_user', $userId)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->with('detailPeminjaman')
            ->get();
        $total = 0;
        foreach ($activeLoans as $loan) {
            foreach ($loan->detailPeminjaman as $detail) {
                $total += $detail->jumlah;
            }
        }
        return $total;
    }

    private function countActiveElectronics($userId)
    {
        $activeLoans = Peminjaman::where('id_user', $userId)
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->with('detailPeminjaman.barang')
            ->get();
        $total = 0;
        foreach ($activeLoans as $loan) {
            foreach ($loan->detailPeminjaman as $detail) {
                if ($detail->barang && $detail->barang->isElectronic()) {
                    $total += $detail->jumlah;
                }
            }
        }
        return $total;
    }
}
