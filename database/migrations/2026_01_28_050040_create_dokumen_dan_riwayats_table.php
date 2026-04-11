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
            $table->unsignedBigInteger('id_pengajuan');
            $table->foreign('id_pengajuan')->references('id')->on('pengajuan')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_jenis_dokumen');
            $table->foreign('id_jenis_dokumen')->references('id')->on('jenis_dokumen');
            
            $table->string('path_file', 255);
            $table->string('file_type', 10)->nullable(); 
            $table->integer('file_size_kb')->nullable(); 
            $table->timestamps();
        });

        // B. Tabel Riwayat Status
        Schema::create('riwayat_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengajuan');
            $table->foreign('id_pengajuan')->references('id')->on('pengajuan')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_status_pengajuan');
            $table->foreign('id_status_pengajuan')->references('id')->on('status_pengajuan');
            
            $table->text('catatan')->nullable(); 
            $table->string('created_by', 255)->default('System'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pengajuan');
        Schema::dropIfExists('pengajuan_has_dokumen');
    }
};