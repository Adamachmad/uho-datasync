<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Panggil semua Model
use App\Models\JenisDokumen;
use App\Models\JenisPengajuan;
use App\Models\StatusPengajuan;
use App\Models\SyaratPengajuan;
use App\Models\Pengaju;
use App\Models\Pengajuan;
use App\Models\RiwayatPengajuan;
use App\Models\PengajuanHasDokumen;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
        // ==========================================
        // 1. MASTER STATUS (SESUAI SQL DUMP)
        // ==========================================
        $stDraft = StatusPengajuan::updateOrCreate(['nama_status' => 'Draft'], ['urutan' => 0]);
        $stTerkirimPustik = StatusPengajuan::updateOrCreate(
            ['nama_status' => StatusPengajuan::TERKIRIM_PUSTIK],
            ['urutan' => 1]
        );
        $stVerifikasiPustik = StatusPengajuan::updateOrCreate(
            ['nama_status' => StatusPengajuan::VERIFIKASI_PUSTIK],
            ['urutan' => 2]
        );
        $stTerkirimPDDIKTI = StatusPengajuan::updateOrCreate(
            ['nama_status' => StatusPengajuan::TERKIRIM_PDDIKTI],
            ['urutan' => 3]
        );
        $stSelesai = StatusPengajuan::updateOrCreate(
            ['nama_status' => StatusPengajuan::SELESAI],
            ['urutan' => 4]
        );
        $stDitolak = StatusPengajuan::updateOrCreate(
            ['nama_status' => StatusPengajuan::DITOLAK],
            ['urutan' => 99]
        );

        // ==========================================
        // 2. MASTER DOKUMEN
        // ==========================================
        $docKTP = JenisDokumen::updateOrCreate(['nama_dokumen' => 'Scan KTP Asli']);
        $docKK = JenisDokumen::updateOrCreate(['nama_dokumen' => 'Scan Kartu Keluarga']);
        $docAkte = JenisDokumen::updateOrCreate(['nama_dokumen' => 'Scan Akte Kelahiran']);
        $docTranskrip = JenisDokumen::updateOrCreate(['nama_dokumen' => 'Scan Transkrip Nilai']);
        $docSurat = JenisDokumen::updateOrCreate(['nama_dokumen' => 'Surat Pernyataan Bermaterai']);

        // ==========================================
        // 3. MASTER JENIS PENGAJUAN
        // ==========================================
        $jpNama = JenisPengajuan::updateOrCreate(['nama_pengajuan' => 'Perubahan Nama']);
        $jpNIM = JenisPengajuan::updateOrCreate(['nama_pengajuan' => 'Perubahan NIM']);
        $jpTglLahir = JenisPengajuan::updateOrCreate(['nama_pengajuan' => 'Perubahan Tanggal Lahir']);

        // ==========================================
        // 4. ATURAN MAIN (SYARAT)
        // ==========================================
        
        // A. Syarat "Ubah Nama": Wajib KTP & Akte
        SyaratPengajuan::updateOrCreate([
            'id_jenis_pengajuan' => $jpNama->id,
            'id_jenis_dokumen' => $docKTP->id,
        ],[
            'is_wajib' => true,
            'allowed_types' => 'pdf,jpg,jpeg',
            'max_size_kb' => 2048
        ]);
        
        SyaratPengajuan::updateOrCreate([
            'id_jenis_pengajuan' => $jpNama->id,
            'id_jenis_dokumen' => $docAkte->id,
        ],[
            'is_wajib' => true,
            'allowed_types' => 'pdf',
            'max_size_kb' => 5120
        ]);

        // B. Syarat "Ubah NIM": Wajib KTP & Transkrip
        SyaratPengajuan::updateOrCreate([
            'id_jenis_pengajuan' => $jpNIM->id,
            'id_jenis_dokumen' => $docKTP->id,
        ],[
            'is_wajib' => true,
            'allowed_types' => 'pdf,jpg', 
            'max_size_kb' => 2048
        ]);
        
        SyaratPengajuan::updateOrCreate([
            'id_jenis_pengajuan' => $jpNIM->id,
            'id_jenis_dokumen' => $docTranskrip->id,
        ],[
            'is_wajib' => true,
            'allowed_types' => 'pdf', 
            'max_size_kb' => 2048
        ]);

        // ==========================================
        // 5. DATA DUMMY MAHASISWA (Pengaju)
        // ==========================================
        $adam = Pengaju::updateOrCreate(
            ['nik' => '747100000001'],
            [
                'nama_lengkap' => 'Adam Achmad',
                'nim' => 'E1E120001',
                'email' => 'adam@uho.ac.id',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. H.E.A. Mokodompit, Kendari',
                'password' => bcrypt('password'), 
            ]
        );

        // ==========================================
        // 6. DATA DUMMY TRANSAKSI
        // ==========================================
        
        // Ceritanya Adam mengajukan Perubahan Nama
        // Statusnya: Menunggu Verifikasi (Sedang diperiksa kampus)
        $transaksi = Pengajuan::updateOrCreate(
            [
                'id_pengaju' => $adam->id,
                'id_jenis_pengajuan' => $jpNama->id,
            ],
            [
                'id_status_pengajuan' => $stTerkirimPustik->id,
                'keterangan_user' => 'Mohon maaf pak, nama saya salah ketik di PDDIKTI.',
                'keterangan_penolakan' => null,
            ]
        );

        // Simulasi File yang diupload Adam
        PengajuanHasDokumen::updateOrCreate([
            'id_pengajuan' => $transaksi->id,
            'id_jenis_dokumen' => $docKTP->id,
        ],[
            'path_file' => 'uploads/dummy_ktp.pdf',
            'file_type' => 'pdf',
            'file_size_kb' => 500
        ]);

        PengajuanHasDokumen::updateOrCreate([
            'id_pengajuan' => $transaksi->id,
            'id_jenis_dokumen' => $docAkte->id,
        ],[
            'path_file' => 'uploads/dummy_akte.pdf',
            'file_type' => 'pdf',
            'file_size_kb' => 1200
        ]);

        // Catat History Awal
        RiwayatPengajuan::updateOrCreate([
            'id_pengajuan' => $transaksi->id,
            'id_status_pengajuan' => $stTerkirimPustik->id,
        ],[
            'catatan' => 'Pengajuan baru berhasil dikirim oleh mahasiswa.',
            'keterangan_penolakan' => null,
            'created_by' => 'Mahasiswa'
        ]);

        // ==========================================
        // 7. DATA DUMMY ADMIN & SUPER ADMIN
        // ==========================================
        User::updateOrCreate(
            ['email' => 'admin@uho.ac.id'],
            [
                'nama' => 'Admin UHO-Datasync',
                'password' => bcrypt('Password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'superadmin@uho.ac.id'],
            [
                'nama' => 'Super Admin UHO-Datasync',
                'password' => bcrypt('Password123'),
                'role' => 'super_admin',
            ]
        );
        });
    }
}