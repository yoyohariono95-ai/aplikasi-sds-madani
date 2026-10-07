<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'nis',
        'password',
        'pin',
        'role',
        'avatar',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'pin',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isOrangTua(): bool
    {
        return $this->role === 'orang_tua';
    }

    public function getRoleLabelAttribute(): string
    {
        switch ($this->role) {
            case 'guru':
                return 'Guru Pengajar';
            case 'orang_tua':
                return 'Orang Tua Murid';
            case 'siswa':
            default:
                return 'Siswa';
        }
    }

    public function getRoleIconAttribute(): string
    {
        switch ($this->role) {
            case 'guru':
                return '👨‍🏫';
            case 'orang_tua':
                return '👨‍👩‍👧';
            case 'siswa':
            default:
                return '🎒';
        }
    }

    public function getRoleBadgeColorAttribute(): string
    {
        switch ($this->role) {
            case 'guru':
                return '#3b82f6';
            case 'orang_tua':
                return '#10b981';
            case 'siswa':
            default:
                return '#f59e0b';
        }
    }
}
