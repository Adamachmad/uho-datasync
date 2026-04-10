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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. MASTER STATUS (SESUAI PAPAN TULIS)
        // ==========================================
        // Urutan logis sesuai flow birokrasi kampus
        $stDraft = StatusPengajuan::create(['nama_status' => 'Draft oleh Pengaju', 'urutan' => 1]);
        $stDiajukanUPA = StatusPengajuan::create(['nama_status' => 'Diajukan ke UPA TIK', 'urutan' => 2]);
        $stProsesSurat = StatusPengajuan::create(['nama_status' => 'Diterima UPA TIK (Proses Surat)', 'urutan' => 3]);
        $stRevisiUPA = StatusPengajuan::create(['nama_status' => 'Ditolak UPA TIK (Revisi)', 'urutan' => 98]); 
        
        $stDiajukanDikti = StatusPengajuan::create(['nama_status' => 'Diajukan UPA TIK ke PDDIKTI', 'urutan' => 4]);
        $stSelesai = StatusPengajuan::create(['nama_status' => 'Diterima oleh PDDIKTI (Selesai)', 'urutan' => 5]);
        $stDitolakDikti = StatusPengajuan::create(['nama_status' => 'Ditolak PDDIKTI', 'urutan' => 99]);

        // ==========================================
        // 2. MASTER DOKUMEN
        // ==========================================
        $docKTP = JenisDokumen::create(['nama_dokumen' => 'Scan KTP Asli']);
        $docKK = JenisDokumen::create(['nama_dokumen' => 'Scan Kartu Keluarga']);
        $docAkte = JenisDokumen::create(['nama_dokumen' => 'Scan Akte Kelahiran']);
        $docTranskrip = JenisDokumen::create(['nama_dokumen' => 'Scan Transkrip Nilai']);
        $docSurat = JenisDokumen::create(['nama_dokumen' => 'Surat Pernyataan Bermaterai']);

        // ==========================================
        // 3. MASTER JENIS PENGAJUAN
        // ==========================================
        $jpNama = JenisPengajuan::create(['nama_pengajuan' => 'Perubahan Nama']);
        $jpNIM = JenisPengajuan::create(['nama_pengajuan' => 'Perubahan NIM']);
        $jpTglLahir = JenisPengajuan::create(['nama_pengajuan' => 'Perubahan Tanggal Lahir']);

        // ==========================================
        // 4. ATURAN MAIN (SYARAT)
        // ==========================================
        
        // A. Syarat "Ubah Nama": Wajib KTP & Akte
        SyaratPengajuan::create([
            'id_jenis_pengajuan' => $jpNama->id,
            'id_jenis_dokumen' => $docKTP->id,
            'is_wajib' => true,
            'allowed_types' => 'pdf,jpg,jpeg',
            'max_size_kb' => 2048
        ]);
        
        SyaratPengajuan::create([
            'id_jenis_pengajuan' => $jpNama->id,
            'id_jenis_dokumen' => $docAkte->id,
            'is_wajib' => true,
            'allowed_types' => 'pdf',
            'max_size_kb' => 5120
        ]);

        // B. Syarat "Ubah NIM": Wajib KTP & Transkrip
        SyaratPengajuan::create([
            'id_jenis_pengajuan' => $jpNIM->id,
            'id_jenis_dokumen' => $docKTP->id,
            'is_wajib' => true,
            'allowed_types' => 'pdf,jpg', 
            'max_size_kb' => 2048
        ]);
        
        SyaratPengajuan::create([
            'id_jenis_pengajuan' => $jpNIM->id,
            'id_jenis_dokumen' => $docTranskrip->id,
            'is_wajib' => true,
            'allowed_types' => 'pdf', 
            'max_size_kb' => 2048
        ]);

        // ==========================================
        // 5. DATA DUMMY MAHASISWA (Pengaju)
        // ==========================================
        // Data ini sudah sesuai dengan struktur tabel baru (ada NIK, Alamat, dll)
        // ==========================================
        // 5. DATA DUMMY MAHASISWA (Pengaju)
        // ==========================================
        $adam = Pengaju::create([
            'nama_lengkap' => 'Adam Achmad',
            'nim' => 'E1E120001',
            'nik' => '747100000001',
            'email' => 'adam@uho.ac.id',
            
            // --- BAGIAN INI YANG KURANG TADI ---
            'jurusan' => 'Teknik Informatika', 
            // -----------------------------------

            'no_hp' => '081234567890',
            'alamat' => 'Jl. H.E.A. Mokodompit, Kendari',
            'password' => bcrypt('password'), 
        ]);

        // ==========================================
        // 6. DATA DUMMY TRANSAKSI
        // ==========================================
        
        // Ceritanya Adam mengajukan Perubahan Nama
        // Statusnya: Diajukan ke UPA TIK (Sedang diperiksa kampus)
        $transaksi = Pengajuan::create([
            'id_pengaju' => $adam->id,
            'id_jenis_pengajuan' => $jpNama->id,
            'id_status_pengajuan' => $stDiajukanUPA->id, // Menggunakan variabel status baru
            'keterangan_user' => 'Mohon maaf pak, nama saya salah ketik di PDDIKTI.',
        ]);

        // Simulasi File yang diupload Adam
        PengajuanHasDokumen::create([
            'id_pengajuan' => $transaksi->id,
            'id_jenis_dokumen' => $docKTP->id,
            'path_file' => 'uploads/dummy_ktp.pdf',
            'file_type' => 'pdf',
            'file_size_kb' => 500
        ]);

        PengajuanHasDokumen::create([
            'id_pengajuan' => $transaksi->id,
            'id_jenis_dokumen' => $docAkte->id,
            'path_file' => 'uploads/dummy_akte.pdf',
            'file_type' => 'pdf',
            'file_size_kb' => 1200
        ]);

        // Catat History Awal
        RiwayatPengajuan::create([
            'id_pengajuan' => $transaksi->id,
            'id_status_pengajuan' => $stDiajukanUPA->id,
            'catatan' => 'Pengajuan berhasil dikirim ke UPA TIK.',
            'created_by' => 'Mahasiswa'
        ]);
    }
}