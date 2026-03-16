<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table      = 'tb_peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_admin',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_kembali_aktual',
        'status',
        'catatan',          // ← nama kolom yang benar di DB
        'disetujui_oleh',
        'point',
    ];

    protected $casts = [
        'tanggal_pinjam'         => 'datetime',
        'tanggal_kembali'        => 'datetime',
        'tanggal_kembali_aktual' => 'datetime',
    ];

    // ──────────────────────────────────────────────────────────────
    //  Relationships
    // ──────────────────────────────────────────────────────────────

    /** Peminjam (User) */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /** Admin yang menyetujui */
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    /**
     * Detail barang yang dipinjam (bisa lebih dari satu)
     * tb_peminjaman → tb_detail_peminjaman → tb_barang
     */
    public function details()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * Shortcut: barang pertama dari detail_peminjaman
     * Dipakai di tabel index untuk tampilan ringkas.
     */
    public function firstDetail()
    {
        return $this->hasOne(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    // ──────────────────────────────────────────────────────────────
    //  Scopes
    // ──────────────────────────────────────────────────────────────

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('updated_at', now()->month)
                     ->whereYear('updated_at', now()->year);
    }

    // ──────────────────────────────────────────────────────────────
    //  Accessors – Status
    // ──────────────────────────────────────────────────────────────

    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'Menunggu',
            'disetujui'    => 'Disetujui',
            'dipinjam'     => 'Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'ditolak'      => 'Ditolak',
            default        => ucfirst($this->status ?? '-'),
        };
    }

    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'bg-yellow-50 text-yellow-700 border-yellow-200',
            'disetujui'    => 'bg-blue-50 text-blue-700 border-blue-200',
            'dipinjam'     => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'dikembalikan' => 'bg-green-50 text-green-700 border-green-200',
            'ditolak'      => 'bg-red-50 text-red-700 border-red-200',
            default        => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }

    public function getIconStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => '⏳',
            'disetujui'    => '✅',
            'dipinjam'     => '📦',
            'dikembalikan' => '🔄',
            'ditolak'      => '❌',
            default        => '•',
        };
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'menunggu';
    }
}
