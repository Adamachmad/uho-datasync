<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // A. Tabel File Upload (Pengajuan HAS Dokumen)
        Schema::create('pengajuan_has_dokumen', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel 'pengajuan' (Sudah Benar Singular)
            $table->foreignId('id_pengajuan')->constrained('pengajuan')->onDelete('cascade');
            
            // Relasi ke jenis dokumen
            $table->foreignId('id_jenis_dokumen')->constrained('jenis_dokumen');
            
            $table->string('path_file');
            $table->string('file_type', 10)->nullable(); 
            $table->integer('file_size_kb')->nullable(); 
            $table->timestamps();
            
            // --- SUDAH BENAR: SOFT DELETE ---
            $table->softDeletes(); 
        });

        // B. Tabel Riwayat Status
        Schema::create('riwayat_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengajuan')->constrained('pengajuan')->onDelete('cascade');
            $table->foreignId('id_status_pengajuan')->constrained('status_pengajuan');
            
            $table->text('catatan')->nullable(); 
            $table->string('created_by')->default('System'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN DISINI: Hapus kedua tabel yang kamu buat di atas
        Schema::dropIfExists('riwayat_pengajuan');
        Schema::dropIfExists('pengajuan_has_dokumen');
    }
};