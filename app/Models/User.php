<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telpon',
        'role',
        'rank',
        'point',
        'nipd',        // ← tambah
        'alamat',      // ← tambah
        'tanggal_lahir', // ← tambah
        'jenis_kelamin', // ← tambah
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'point' => 'integer',
        'tanggal_lahir' => 'date', // ← tambah
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPeminjam(): bool
    {
        return $this->role === 'peminjam';
    }
}
