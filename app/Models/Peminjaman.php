<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'tb_peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $incrementing = true;
    protected $keyType = 'int';

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

    public function getIsPendingAttribute()
    {
        return $this->status === 'menunggu';
    }

    public function getFirstDetailAttribute()
    {
        return $this->detailPeminjaman->first();
    }

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'dipinjam' => 'Sedang Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status ?? '-'),
        };
    }

    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'disetujui' => 'bg-blue-100 text-blue-800 border-blue-200',
            'dipinjam' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'dikembalikan' => 'bg-green-100 text-green-800 border-green-200',
            'ditolak' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function getIconStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'clock',
            'disetujui' => 'check-circle',
            'dipinjam' => 'box',
            'dikembalikan' => 'check-circle',
            'ditolak' => 'x-circle',
            default => 'circle',
        };
    }

    public function getLabelReturnConditionAttribute(): string
    {
        return match ($this->return_condition) {
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'hilang' => 'Hilang',
            default => '-',
        };
    }

    public function getBadgeReturnConditionAttribute(): string
    {
        return match ($this->return_condition) {
            'baik' => 'bg-green-100 text-green-800',
            'rusak_ringan' => 'bg-yellow-100 text-yellow-800',
            'rusak_berat' => 'bg-orange-100 text-orange-800',
            'hilang' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getDurationDaysAttribute(): int
    {
        if (!$this->tanggal_kembali) {
            return 0;
        }

        return $this->tanggal_pinjam->diffInDays($this->tanggal_kembali);
    }

    public function getTotalItemsAttribute(): int
    {
        return $this->detailPeminjaman->sum('jumlah');
    }

    public function isLate(): bool
    {
        if (!$this->tanggal_kembali_aktual || !$this->tanggal_kembali) {
            return false;
        }

        return $this->tanggal_kembali_aktual->gt($this->tanggal_kembali);
    }

    public function calculateLateDays(): int
    {
        if (!$this->tanggal_kembali_aktual || !$this->tanggal_kembali) {
            return 0;
        }

        if ($this->tanggal_kembali_aktual->lte($this->tanggal_kembali)) {
            return 0;
        }

        return $this->tanggal_kembali_aktual->diffInDays($this->tanggal_kembali);
    }

    public function getRemainingDaysAttribute(): int
    {
        if (!$this->tanggal_kembali || $this->status !== 'dipinjam') {
            return 0;
        }

        $diff = now()->diffInDays($this->tanggal_kembali, false);
        return (int) $diff;
    }

    public function getIsDueSoonAttribute(): bool
    {
        if ($this->status !== 'dipinjam') {
            return false;
        }

        $remaining = $this->remaining_days;
        return $remaining >= 0 && $remaining <= 2;
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->status !== 'dipinjam') {
            return false;
        }

        return $this->remaining_days < 0;
    }

    public function approve(int $adminId, ?string $catatan = null, ?Carbon $tanggalKembali = null): void
    {
        $this->update([
            'status' => 'disetujui',
            'id_admin' => $adminId,
            'disetujui_oleh' => $adminId,
            'approved_at' => now(),
            'catatan' => $catatan,
            'tanggal_kembali' => $tanggalKembali,
        ]);
    }

    public function reject(int $adminId, string $catatan): void
    {
        $this->update([
            'status' => 'ditolak',
            'id_admin' => $adminId,
            'disetujui_oleh' => $adminId,
            'rejected_at' => now(),
            'catatan' => $catatan,
        ]);
    }

    public function markAsBorrowed(): void
    {
        $this->update([
            'status' => 'dipinjam',
        ]);

        foreach ($this->detailPeminjaman as $detail) {
            $detail->barang->decrement('jumlah_tersedia', $detail->jumlah);
        }
    }

    public function markAsReturned(string $condition, int $adminId): void
    {
        $actualReturn = now();
        $isLate = $actualReturn->gt($this->tanggal_kembali);

        $this->update([
            'status' => 'dikembalikan',
            'tanggal_kembali_aktual' => $actualReturn,
            'return_condition' => $condition,
            'is_late' => $isLate,
            'id_admin' => $adminId,
        ]);

        foreach ($this->detailPeminjaman as $detail) {
            $detail->update([
                'kondisi_kembali' => $condition,
            ]);

            $detail->barang->increment('jumlah_tersedia', $detail->jumlah);
        }

        $this->calculateAndAddPoints();
    }

    private function calculateAndAddPoints(): void
    {
        $points = 0;
        $reasons = [];

        if (!$this->is_late) {
            $points += 10;
            $reasons[] = 'Pengembalian tepat waktu (+10)';
        } else {
            $lateDays = $this->calculateLateDays();
            $penalty = min($lateDays * 2, 20);
            $points -= $penalty;
            $reasons[] = "Keterlambatan {$lateDays} hari (-{$penalty})";
        }

        $conditionPoints = match ($this->return_condition) {
            'baik' => 5,
            'rusak_ringan' => -5,
            'rusak_berat' => -15,
            'hilang' => -30,
            default => 0,
        };

        $points += $conditionPoints;
        $reasons[] = match ($this->return_condition) {
            'baik' => 'Kondisi barang baik (+5)',
            'rusak_ringan' => 'Barang rusak ringan (-5)',
            'rusak_berat' => 'Barang rusak berat (-15)',
            'hilang' => 'Barang hilang (-30)',
            default => '',
        };

        $this->update(['point_earned' => $points]);

        $user = $this->user;
        $user->increment('points', $points);
        $user->updateTier();

        PointLog::create([
            'id_user' => $this->id_user,
            'id_peminjaman' => $this->id_peminjaman,
            'change' => $points,
            'reason' => implode(', ', array_filter($reasons)),
        ]);
    }

    public function canBeEditedBy(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $this->id_user === $user->id_user && $this->status === 'menunggu';
    }

    public function canBeApproved(): bool
    {
        return $this->status === 'menunggu' && !$this->user->is_banned;
    }

    public function canBeRejected(): bool
    {
        return $this->status === 'menunggu';
    }

    public function canBeHandedOver(): bool
    {
        return $this->status === 'disetujui';
    }

    public function canBeReturned(): bool
    {
        return $this->status === 'dipinjam';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($peminjaman) {
            if (!$peminjaman->tanggal_pinjam) {
                $peminjaman->tanggal_pinjam = now();
            }
        });
    }
}
