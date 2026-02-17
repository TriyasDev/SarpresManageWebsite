<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id_user
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $no_telpon
 * @property string $role
 * @property string|null $rank
 * @property int|null $point
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNoTelpon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama table di database
     */
    protected $table = 'tb_user';

    /**
     * Primary key table
     */
    protected $primaryKey = 'id_user';

    /**
     * Field yang boleh diisi mass assignment
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telpon',
        'role',
        'rank',
        'point',
    ];

    /**
     * Field yang di-hidden saat di-serialize (untuk keamanan)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting type data
     */
    protected $casts = [
        'point' => 'integer',
    ];

    /**
     * Check apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check apakah user adalah peminjam
     */
    public function isPeminjam()
    {
        return $this->role === 'peminjam';
    }
}
