<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPengajuan extends Model
{
    use HasFactory;

    protected $table = 'status_pengajuan';
    protected $guarded = ['id'];

    // Relasi: Status Pengajuan memiliki banyak Pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'id_status_pengajuan');
    }

    // Relasi: Status Pengajuan memiliki banyak Riwayat Pengajuan
    public function riwayats()
    {
        return $this->hasMany(RiwayatPengajuan::class, 'id_status_pengajuan');
    }
}