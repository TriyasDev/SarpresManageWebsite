<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table      = 'tb_barang';
    protected $primaryKey = 'id_barang';
    public $incrementing  = true;
    protected $keyType    = 'int';

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
        'jumlah_total'    => 'integer',
        'jumlah_tersedia' => 'integer',
        'deleted_at'      => 'datetime',
    ];
}
