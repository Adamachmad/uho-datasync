<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengajuan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pengajuan';
    protected $guarded = ['id'];
    
    // Relasi ke Syarat (Rules)
    public function syarat()
    {
        return $this->hasMany(SyaratPengajuan::class, 'id_jenis_pengajuan');
    }
}