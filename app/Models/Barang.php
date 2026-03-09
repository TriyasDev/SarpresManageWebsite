<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Barang
 *
 * @property int $id_barang
 * @property string $nama_barang
 * @property string $kategori
 * @property string $kondisi
 * @property int $jumlah_total
 * @property int $jumlah_tersedia
 * @property string $deskripsi
 * @property string $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereIdBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereJumlahTersedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereJumlahTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereKondisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Barang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Barang extends Model
{
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'kondisi',
        'jumlah_total',
        'jumlah_tersedia',
        'deskripsi',
        'foto',
    ];
}
