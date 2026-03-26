<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'kondisi',
        'jumlah_total',
        'jumlah_tersedia',
        'deskripsi',
        'foto',
    ];

    protected $casts = [
        'jumlah_total' => 'integer',
        'jumlah_tersedia' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_barang', 'id_barang');
    }

    public function isElectronic()
    {
        $electronicCategories = ['elektronik', 'multimedia'];
        return in_array(strtolower($this->kategori), $electronicCategories);
    }

    public function decrementStock($jumlah)
    {
        $this->jumlah_tersedia -= $jumlah;
        $this->save();
    }

    public function incrementStock($jumlah)
    {
        $this->jumlah_tersedia += $jumlah;
        $this->save();
    }
}
