<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanDetail extends Model
{
    protected $table = 'tb_laporan_detail';
    protected $primaryKey = 'id_laporan_detail';

    protected $fillable = [
        'id_laporan',
        'id_barang',
        'jumlah_dikembalikan',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
