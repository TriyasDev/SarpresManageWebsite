<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DetailPeminjaman
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DetailPeminjaman query()
 * @mixin \Eloquent
 */
class DetailPeminjaman extends Model
{
    protected $table = 'tb_detail_peminjaman';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'id_barang',
        'jumlah',
        'kondisi_pinjam',
        'kondisi_kembali',
        'keterangan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
