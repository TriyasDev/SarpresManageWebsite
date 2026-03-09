<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Laporan
 *
 * @property int $id_laporan
 * @property int $id_peminjaman
 * @property int $id_admin
 * @property string $jenis_laporan
 * @property string $kondisi_barang
 * @property \Illuminate\Support\Carbon|null $tanggal_dipinjam
 * @property \Illuminate\Support\Carbon|null $tanggal_dikembalikan
 * @property string $foto_bukti
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $admin
 * @property-read string $badge_jenis
 * @property-read string $badge_kondisi
 * @property-read string $label_jenis
 * @property-read string $label_kondisi
 * @property-read \App\Models\Peminjaman $peminjam
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereFotoBukti($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereIdAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereIdLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereIdPeminjaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereJenisLaporan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereKondisiBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereTanggalDikembalikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereTanggalDipinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Laporan withoutTrashed()
 * @mixin \Eloquent
 */
class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_peminjaman',
        'id_admin',
        'jenis_laporan',
        'kondisi_barang',
        'foto_bukti',
        'tanggal_dipinjam',
        'tanggal_dikembalikan',
    ];

    protected $casts = [
        'tanggal_dipinjam' => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
        'delete_at' => 'datetime',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    public function peminjam(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function getBadgeJenisAttribute(): string
    {
        return match ($this->jenis_laporan) {
            'dikembalikan'       => 'bg-green-100 text-green-700 border-green-200',
            'telat mengembalikan' => 'bg-orange-100 text-orange-700 border-orange-200',
            'hilang'             => 'bg-red-100 text-red-700 border-red-200',
            default              => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function getBadgeKondisiAttribute(): string
    {
        return match ($this->kondisi_barang) {
            'baik'          => 'bg-green-100 text-green-700 border-green-200',
            'masih di pinjam' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'rusak'         => 'bg-red-100 text-red-700 border-red-200',
            default         => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function getLabelJenisAttribute(): string
    {
        return ucwords($this->jenis_laporan);
    }

    public function getLabelKondisiAttribute(): string
    {
        return ucwords($this->kondisi_barang);
    }
}
