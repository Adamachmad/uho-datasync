<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPengajuan extends Model
{
    use HasFactory;

    protected $table = 'status_pengajuan';
    protected $guarded = ['id'];

    public const TERKIRIM_PUSTIK = 'TERKIRIM_PUSTIK';
    public const VERIFIKASI_PUSTIK = 'VERIFIKASI_PUSTIK';
    public const TERKIRIM_PDDIKTI = 'TERKIRIM_PDDIKTI';
    public const SELESAI = 'SELESAI';
    public const DITOLAK = 'DITOLAK';

    public const LABELS = [
        self::TERKIRIM_PUSTIK => 'Pengajuan perubahan data terkirim ke pustik UHO',
        self::VERIFIKASI_PUSTIK => 'Telah diverifikasi oleh admin pustik',
        self::TERKIRIM_PDDIKTI => 'Terkirim ke pusat pangkalan data di PDDIKTI',
        self::SELESAI => 'Pengajuan data telah berhasil, perubahan sudah dilakukan',
        self::DITOLAK => 'Pengajuan Ditolak',
    ];

    public const BADGE_CLASSES = [
        self::TERKIRIM_PUSTIK => 'bg-yellow-100 text-yellow-800',
        self::VERIFIKASI_PUSTIK => 'bg-yellow-100 text-yellow-800',
        self::TERKIRIM_PDDIKTI => 'bg-blue-100 text-blue-800',
        self::SELESAI => 'bg-green-100 text-green-800',
        self::DITOLAK => 'bg-red-100 text-red-800',
    ];

    public function getLabelAttribute(): string
    {
        return self::LABELS[$this->nama_status] ?? $this->nama_status;
    }

    public function getBadgeClassAttribute(): string
    {
        return self::BADGE_CLASSES[$this->nama_status] ?? 'bg-gray-100 text-gray-800';
    }

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