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
        Schema::create('syarat_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jenis_pengajuan');
            $table->foreign('id_jenis_pengajuan')->references('id')->on('jenis_pengajuan')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_jenis_dokumen');
            $table->foreign('id_jenis_dokumen')->references('id')->on('jenis_dokumen')->onDelete('cascade');
            
            $table->boolean('is_wajib')->default(true);
            $table->string('allowed_types', 255)->default('pdf,jpg');
            $table->integer('max_size_kb')->default(2048);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_pengajuan');
    }
};