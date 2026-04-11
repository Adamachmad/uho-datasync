<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPengajuan extends Model
{
    // Pastikan nama tabel benar
    protected $table = 'riwayat_pengajuan'; 

    protected $fillable = [
        'id_pengajuan',
        'id_status_pengajuan',
        'catatan',
        'keterangan_penolakan',
        'created_by',
    ];

    // --- RELASI PENTING (INI YANG HILANG) ---

    // 1. Relasi ke Status (Agar ->with('status_pengajuan') di Controller jalan)
    public function status_pengajuan()
    {
        return $this->belongsTo(StatusPengajuan::class, 'id_status_pengajuan');
    }

    // 2. Relasi ke Pengajuan Induk (Opsional tapi berguna)
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan');
    }
}