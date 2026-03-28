<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username', 'email', 'password', 'no_telpon', 'role',
        'nama', 'kelas', 'nipd', 'alamat', 'tanggal_lahir',
        'jenis_kelamin', 'points', 'tier', 'is_banned',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'points' => 'integer',
        'is_banned' => 'boolean',
        'tanggal_lahir' => 'date',
    ];
}
