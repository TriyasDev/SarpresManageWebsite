<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Peminjaman
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peminjaman query()
 * @mixin \Eloquent
 */
class Peminjaman extends Model
{
    protected $table = 'tb_peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_admin',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_kembali_aktual',
        'status',
        'catatan',
        'disetujui_oleh',
        'point',
    ];

    protected $casts = [
        'tanggal_pinjam'          => 'datetime',
        'tanggal_kembali'         => 'datetime',
        'tanggal_kembali_aktual'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}
