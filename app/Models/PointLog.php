<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    protected $table = 'tb_point_logs';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'id_peminjaman',
        'change',
        'reason',
    ];

    protected $casts = [
        'change' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function getReasonLabelAttribute()
    {
        return match ($this->reason) {
            'return_on_time' => 'Pengembalian Tepat Waktu',
            'return_late' => 'Keterlambatan Pengembalian',
            'good_condition' => 'Kondisi Barang Baik',
            'slightly_damaged' => 'Barang Rusak Ringan',
            'heavily_damaged' => 'Barang Rusak Berat',
            'lost' => 'Barang Hilang',
            'admin_adjustment' => 'Penyesuaian Admin',
            default => $this->reason,
        };
    }

    public function getChangeLabelAttribute()
    {
        if ($this->change > 0) {
            return '+' . $this->change;
        }
        return (string) $this->change;
    }

    public function getChangeColorAttribute()
    {
        if ($this->change > 0) {
            return 'text-green-600';
        }
        if ($this->change < 0) {
            return 'text-red-600';
        }
        return 'text-gray-600';
    }
}
