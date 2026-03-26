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

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPeminjam()
    {
        return $this->role === 'peminjam';
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_user', 'id_user');
    }

    public function approvedPeminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_admin', 'id_user');
    }

    public function pointLogs()
    {
        return $this->hasMany(PointLog::class, 'id_user', 'id_user');
    }

    public function getTierLabelAttribute()
    {
        return match ($this->tier) {
            'Paragon' => 'Paragon',
            'Exemplar' => 'Exemplar',
            'Sentinel' => 'Sentinel',
            'Steward' => 'Steward',
            'Reliant' => 'Reliant',
            'Negligent' => 'Negligent',
            default => 'Reliant',
        };
    }

    public function getMaxItemsAttribute()
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

    public function getMaxDaysAttribute()
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

    public function getMaxElectronicsAttribute()
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

    public function updateTier()
    {
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
        $this->saveQuietly();
    }
}
