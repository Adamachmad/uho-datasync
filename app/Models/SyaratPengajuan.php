<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratPengajuan extends Model
{
    use HasFactory;

    protected $table = 'syarat_pengajuan';
    protected $guarded = ['id'];

    // Relasi: Syarat ini butuh dokumen apa?
    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen');
    }
    
    // Relasi: Syarat ini untuk pengajuan jenis apa?
    public function jenisPengajuan()
    {
        return $this->belongsTo(JenisPengajuan::class, 'id_jenis_pengajuan');
    }
}