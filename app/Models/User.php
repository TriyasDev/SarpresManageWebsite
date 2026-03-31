<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telpon',
        'role',
        'nama',
        'kelas',
        'nipd',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'points',
        'tier',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'points' => 'integer',
        'is_banned' => 'boolean',
        'tanggal_lahir' => 'date',
        'deleted_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->isDirty('points')) {
                $user->updateTier();
            }
        });

        static::creating(function ($user) {
            if ($user->role === 'peminjam') {
                $user->points = $user->points ?? 50;
                $user->tier = $user->tier ?? 'Reliant';
            }
        });
    }

    public function addPoints(int $points)
    {
        $this->points =+ $points;
        $this->save();
        return $this;
    }

    public function reducePoints(int $points)
    {
        $this->points = max(0, $this->points - $points);
        $this->save();
        return $this;
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_user', 'id_user');
    }

    public function approvedPeminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_admin', 'id_user');
    }

    public function processedPeminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'disetujui_oleh', 'id_user');
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'id_admin', 'id_user');
    }

    public function pointLogs()
    {
        return $this->hasMany(PointLog::class, 'id_user', 'id_user');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super-admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super-admin']);
    }

    public function isPeminjam(): bool
    {
        return $this->role === 'peminjam';
    }

    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManageAssets(): bool
    {
        return $this->isAdmin();
    }

    public function canApproveLoan(): bool
    {
        return $this->isAdmin();
    }

    public function getTierLabelAttribute(): string
    {
        return $this->tier ?? 'Reliant';
    }

    public function getTierColorAttribute(): string
    {
        return match ($this->tier) {
            'Paragon' => 'bg-purple-100 text-purple-800 border-purple-200',
            'Exemplar' => 'bg-blue-100 text-blue-800 border-blue-200',
            'Sentinel' => 'bg-green-100 text-green-800 border-green-200',
            'Steward' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'Reliant' => 'bg-gray-100 text-gray-800 border-gray-200',
            'Negligent' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function getMaxItemsAttribute(): int
    {
        return match ($this->tier) {
            'Paragon' => 7,
            'Exemplar' => 6,
            'Sentinel' => 5,
            'Steward' => 4,
            'Reliant' => 3,
            'Negligent' => 1,
            default => 3,
        };
    }

    /**
     * Get maximum days for borrowing based on tier.
     */
    public function getMaxDaysAttribute(): int
    {
        return match ($this->tier) {
            'Paragon' => 9,
            'Exemplar' => 8,
            'Sentinel' => 7,
            'Steward' => 6,
            'Reliant' => 5,
            'Negligent' => 3,
            default => 5,
        };
    }

    /**
     * Get maximum electronic items that can be borrowed.
     */
    public function getMaxElectronicsAttribute(): int
    {
        return match ($this->tier) {
            'Paragon' => 4,
            'Exemplar' => 3,
            'Sentinel' => 2,
            'Steward' => 1,
            'Reliant' => 0,
            'Negligent' => 0,
            default => 0,
        };
    }

    /**
     * Update user tier based on current points.
     */
    public function updateTier(): void
    {
        $oldTier = $this->tier;

        if ($this->points >= 98) {
            $this->tier = 'Paragon';
        } elseif ($this->points >= 90) {
            $this->tier = 'Exemplar';
        } elseif ($this->points >= 75) {
            $this->tier = 'Sentinel';
        } elseif ($this->points >= 55) {
            $this->tier = 'Steward';
        } elseif ($this->points >= 35) {
            $this->tier = 'Reliant';
        } else {
            $this->tier = 'Negligent';
        }

        // Save without triggering events
        if ($oldTier !== $this->tier) {
            $this->saveQuietly();
        }
    }

    /**
     * Get tier requirements as array.
     */
    public static function getTierRequirements(): array
    {
        return [
            'Paragon' => ['min_points' => 98, 'max_items' => 7, 'max_days' => 9, 'max_electronics' => 4],
            'Exemplar' => ['min_points' => 90, 'max_items' => 6, 'max_days' => 8, 'max_electronics' => 3],
            'Sentinel' => ['min_points' => 75, 'max_items' => 5, 'max_days' => 7, 'max_electronics' => 2],
            'Steward' => ['min_points' => 55, 'max_items' => 4, 'max_days' => 6, 'max_electronics' => 1],
            'Reliant' => ['min_points' => 35, 'max_items' => 3, 'max_days' => 5, 'max_electronics' => 0],
            'Negligent' => ['min_points' => 0, 'max_items' => 1, 'max_days' => 3, 'max_electronics' => 0],
        ];
    }

    // =========================================================================
    //  BORROWING LIMIT METHODS
    // =========================================================================

    /**
     * Check if user can borrow more items.
     */
    public function canBorrowMore(): bool
    {
        if ($this->is_banned) {
            return false;
        }

        $activeBorrows = $this->peminjamans()
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->count();

        return $activeBorrows < 3; // Max 3 active borrows at once
    }

    /**
     * Get active borrowing count.
     */
    public function getActiveBorrowsCountAttribute(): int
    {
        return $this->peminjamans()
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->count();
    }

    /**
     * Get pending requests count.
     */
    public function getPendingRequestsCountAttribute(): int
    {
        return $this->peminjamans()
            ->where('status', 'menunggu')
            ->count();
    }

    /**
     * Check if user has overdue items.
     */
    public function hasOverdueItems(): bool
    {
        return $this->peminjamans()
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now())
            ->exists();
    }

    /**
     * Get overdue items count.
     */
    public function getOverdueItemsCountAttribute(): int
    {
        return $this->peminjamans()
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now())
            ->count();
    }

    // =========================================================================
    //  STATISTICS METHODS
    // =========================================================================

    /**
     * Get total borrowed items count.
     */
    public function getTotalBorrowedAttribute(): int
    {
        return $this->peminjamans()
            ->where('status', 'dikembalikan')
            ->count();
    }

    /**
     * Get late return count.
     */
    public function getLateReturnCountAttribute(): int
    {
        return $this->peminjamans()
            ->where('status', 'dikembalikan')
            ->where('is_late', true)
            ->count();
    }

    /**
     * Get on-time return percentage.
     */
    public function getOnTimePercentageAttribute(): float
    {
        $total = $this->total_borrowed;
        if ($total === 0) {
            return 100.0;
        }

        $onTime = $total - $this->late_return_count;
        return round(($onTime / $total) * 100, 1);
    }

    // =========================================================================
    //  ACCESSORS
    // =========================================================================

    /**
     * Get formatted role name.
     */
    public function getRoleNameAttribute(): string
    {
        return match ($this->role) {
            'super-admin' => 'Super Admin',
            'admin' => 'Admin',
            'peminjam' => 'Peminjam',
            default => ucfirst($this->role),
        };
    }

    /**
     * Get role badge color.
     */
    public function getRoleBadgeAttribute(): string
    {
        return match ($this->role) {
            'super-admin' => 'bg-purple-100 text-purple-800',
            'admin' => 'bg-blue-100 text-blue-800',
            'peminjam' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get full name (fallback to username if nama is null).
     */
    public function getFullNameAttribute(): string
    {
        return $this->nama ?? $this->username;
    }

    /**
     * Get formatted phone number.
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (!$this->no_telpon) {
            return null;
        }

        // Format: 0812-3456-789
        $phone = preg_replace('/\D/', '', $this->no_telpon);
        if (strlen($phone) >= 10) {
            return substr($phone, 0, 4) . '-' . substr($phone, 4, 4) . '-' . substr($phone, 8);
        }

        return $this->no_telpon;
    }

    // =========================================================================
    //  BOOT METHODS
    // =========================================================================

    protected static function boot()
    {
        parent::boot();

        // Set default points and tier for new peminjam
        static::creating(function ($user) {
            if ($user->role === 'peminjam') {
                if ($user->points === null) {
                    $user->points = 50; // Default starting points
                }
                if ($user->tier === null) {
                    $user->tier = 'Reliant'; // Default tier
                }
            }
        });
    }
}
