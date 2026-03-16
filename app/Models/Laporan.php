<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use SoftDeletes;

    protected $table      = 'tb_laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_peminjaman',
        'id_admin',
        'jenis_laporan',
        'kondisi_barang',
        'tanggal_dipinjam',
        'tanggal_dikembalikan',
        'foto_bukti',
    ];

    protected $casts = [
        'tanggal_dipinjam'     => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
        'deleted_at'           => 'datetime',
    ];

    // ──────────────────────────────────────────────────────────────
    //  Relationships
    // ──────────────────────────────────────────────────────────────

    /** Pengajuan/Peminjaman yang terkait laporan ini */
    public function peminjam()
    {
        return $this->belongsTo(Pengajuan::class, 'id_peminjaman', 'id_peminjaman');
    }

    /** Admin yang mencatat laporan */
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    // ──────────────────────────────────────────────────────────────
    //  Accessors – Jenis Laporan
    // ──────────────────────────────────────────────────────────────

    public function getLabelJenisAttribute(): string
    {
        return match ($this->jenis_laporan) {
            'dikembalikan'        => 'Dikembalikan',
            'telat mengembalikan' => 'Telat Mengembalikan',
            'hilang'              => 'Hilang',
            default               => ucfirst($this->jenis_laporan ?? '-'),
        };
    }

    public function getBadgeJenisAttribute(): string
    {
        return match ($this->jenis_laporan) {
            'dikembalikan'        => 'bg-green-100 text-green-700 border-green-200',
            'telat mengembalikan' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'hilang'              => 'bg-red-100 text-red-700 border-red-200',
            default               => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }

    // ──────────────────────────────────────────────────────────────
    //  Accessors – Kondisi Barang
    // ──────────────────────────────────────────────────────────────

    public function getLabelKondisiAttribute(): string
    {
        return match ($this->kondisi_barang) {
            'baik'            => 'Baik',
            'masih di pinjam' => 'Masih Di Pinjam',
            'rusak'           => 'Rusak',
            default           => ucfirst($this->kondisi_barang ?? '-'),
        };
    }

    public function getBadgeKondisiAttribute(): string
    {
        return match ($this->kondisi_barang) {
            'baik'            => 'bg-green-100 text-green-700 border-green-200',
            'masih di pinjam' => 'bg-blue-100 text-blue-700 border-blue-200',
            'rusak'           => 'bg-red-100 text-red-700 border-red-200',
            default           => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }
}
