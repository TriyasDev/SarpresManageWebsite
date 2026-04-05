<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use SoftDeletes;

    protected $table = 'tb_laporan';
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
        'tanggal_dipinjam' => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    public function getLabelJenisAttribute()
    {
        return match ($this->jenis_laporan) {
            'dikembalikan' => 'Dikembalikan',
            'telat mengembalikan' => 'Telat Mengembalikan',
            'hilang' => 'Hilang',
            default => ucfirst($this->jenis_laporan ?? '-'),
        };
    }

    public function getBadgeJenisAttribute()
    {
        return match ($this->jenis_laporan) {
            'dikembalikan' => 'bg-green-100 text-green-800 border-green-200',
            'telat mengembalikan' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'hilang' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function getLabelKondisiAttribute()
    {
        return match ($this->kondisi_barang) {
            'baik' => 'Baik',
            'masih di pinjam' => 'Masih Dipinjam',
            'rusak' => 'Rusak',
            default => ucfirst($this->kondisi_barang ?? '-'),
        };
    }

    public function getBadgeKondisiAttribute()
    {
        return match ($this->kondisi_barang) {
            'baik' => 'bg-green-100 text-green-800 border-green-200',
            'masih di pinjam' => 'bg-blue-100 text-blue-800 border-blue-200',
            'rusak' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
