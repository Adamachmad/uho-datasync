<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Penting biar bisa Login
use Illuminate\Notifications\Notifiable;

class Pengaju extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengaju';
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relasi: Pengaju memiliki banyak Pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'id_pengaju');
    }
}