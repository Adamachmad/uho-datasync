<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumen';
    protected $guarded = ['id'];

    // Relasi: Jenis Dokumen memiliki banyak Syarat Pengajuan
    public function syarat()
    {
        return $this->hasMany(SyaratPengajuan::class, 'id_jenis_dokumen');
    }

    // Relasi: Jenis Dokumen memiliki banyak Pengajuan Has Dokumen
    public function pengajuanHasDokumen()
    {
        return $this->hasMany(PengajuanHasDokumen::class, 'id_jenis_dokumen');
    }
}