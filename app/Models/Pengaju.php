<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Penting biar bisa Login
use Illuminate\Notifications\Notifiable;

class Pengaju extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'pengaju';
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Override to disable remember_token functionality
     * since pengaju table doesn't have this column
     */
    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Do nothing - this table doesn't have remember_token column
    }

    public function getRememberTokenName()
    {
        return null;
    }

    // Relasi: Pengaju memiliki banyak Pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'id_pengaju');
    }
}