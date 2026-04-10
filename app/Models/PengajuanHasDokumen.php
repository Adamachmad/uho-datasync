<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanHasDokumen extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya sesuai dengan yang di migration
    protected $table = 'pengajuan_has_dokumen';
    
    protected $guarded = ['id'];

    // Relasi ke tabel Jenis Dokumen (KTP, Ijazah, dll)
    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen');
    }
    
    // Relasi ke tabel Pengajuan (Header Transaksi)
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }
}