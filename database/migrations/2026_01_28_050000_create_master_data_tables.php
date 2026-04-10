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
        // A. Jenis Dokumen (KTP, Ijazah, dll)
        Schema::create('jenis_dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // B. Jenis Pengajuan (Ubah Nama, dll)
        Schema::create('jenis_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengajuan');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        // C. Status Pengajuan (Draft, Menunggu, Selesai)
        Schema::create('status_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status');
            $table->integer('urutan')->default(0); // Untuk sorting progress
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pengajuan');
        Schema::dropIfExists('jenis_pengajuan');
        Schema::dropIfExists('jenis_dokumen');
    }
};