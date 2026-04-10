<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    // Pastikan nama tabel benar (singular)
    protected $table = 'pengajuan'; 

    // Izinkan semua kolom diisi
    protected $guarded = [];

    // --- RELASI PENTING (INI PENYEBAB ERRORNYA) ---

    // 1. Relasi ke Status
    public function status_pengajuan()
    {
        // Pastikan 'id_status_pengajuan' sesuai dengan kolom di database
        return $this->belongsTo(StatusPengajuan::class, 'id_status_pengajuan');
    }

    // 2. Relasi ke Jenis Pengajuan
    public function jenis_pengajuan()
    {
        return $this->belongsTo(JenisPengajuan::class, 'id_jenis_pengajuan');
    }

    // 3. Relasi ke Dokumen
    public function dokumens()
    {
        return $this->hasMany(PengajuanHasDokumen::class, 'id_pengajuan');
    }

    // 4. Relasi ke Pengaju
    public function pengaju()
    {
        return $this->belongsTo(Pengaju::class, 'id_pengaju');
    }
}