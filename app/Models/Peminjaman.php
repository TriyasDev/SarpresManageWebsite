<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'approved_at',
        'rejected_at',
        'return_condition',
        'is_late',
        'point_earned',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_kembali_aktual' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'is_late' => 'boolean',
        'point_earned' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh', 'id_user');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function laporan()
    {
        return $this->hasOne(Laporan::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function pointLogs()
    {
        return $this->hasMany(PointLog::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDipinjam($query)
    {
        return $query->where('status', 'dipinjam');
    }

    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function getLabelStatusAttribute()
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'dipinjam' => 'Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status ?? '-'),
        };
    }

    public function getBadgeStatusAttribute()
    {
        return match ($this->status) {
            'menunggu' => 'bg-yellow-100 text-yellow-800',
            'disetujui' => 'bg-blue-100 text-blue-800',
            'dipinjam' => 'bg-indigo-100 text-indigo-800',
            'dikembalikan' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getLabelReturnConditionAttribute()
    {
        return match ($this->return_condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'hilang' => 'Hilang',
            default => '-',
        };
    }

    public function getBadgeReturnConditionAttribute()
    {
        return match ($this->return_condition) {
            'baik' => 'bg-green-100 text-green-800',
            'rusak_ringan' => 'bg-yellow-100 text-yellow-800',
            'rusak_berat' => 'bg-orange-100 text-orange-800',
            'hilang' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function isLate()
    {
        if (!$this->tanggal_kembali_aktual) {
            return false;
        }
        return $this->tanggal_kembali_aktual->gt($this->tanggal_kembali);
    }

    public function calculateLateDays()
    {
        if (!$this->tanggal_kembali_aktual || !$this->tanggal_kembali) {
            return 0;
        }
        if ($this->tanggal_kembali_aktual->lte($this->tanggal_kembali)) {
            return 0;
        }
        return $this->tanggal_kembali_aktual->diffInDays($this->tanggal_kembali);
    }

    public function approve($adminId)
    {
        $this->status = 'disetujui';
        $this->id_admin = $adminId;
        $this->disetujui_oleh = $adminId;
        $this->approved_at = now();
        $this->save();
    }

    public function reject($adminId)
    {
        $this->status = 'ditolak';
        $this->id_admin = $adminId;
        $this->disetujui_oleh = $adminId;
        $this->rejected_at = now();
        $this->save();
    }

    public function markAsBorrowed()
    {
        $this->status = 'dipinjam';
        $this->save();

        foreach ($this->detailPeminjaman as $detail) {
            $detail->barang->decrementStock($detail->jumlah);
        }
    }

    public function markAsReturned($condition, $adminId)
    {
        $this->status = 'dikembalikan';
        $this->tanggal_kembali_aktual = now();
        $this->return_condition = $condition;
        $this->is_late = $this->isLate();
        $this->id_admin = $adminId;
        $this->save();

        foreach ($this->detailPeminjaman as $detail) {
            $detail->kondisi_kembali = $condition;
            $detail->save();
            $detail->barang->incrementStock($detail->jumlah);
        }
    }
}
