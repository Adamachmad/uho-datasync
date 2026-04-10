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
        $table->foreignId('id_jenis_pengajuan')->constrained('jenis_pengajuan')->onDelete('cascade');
        $table->foreignId('id_jenis_dokumen')->constrained('jenis_dokumen')->onDelete('cascade');
        
        // Fitur Dinamis Papan Tulis
        $table->boolean('is_wajib')->default(true);
        $table->string('allowed_types')->default('pdf,jpg'); // Validasi ekstensi
        $table->integer('max_size_kb')->default(2048); // Validasi ukuran
        $table->boolean('is_aktif')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_pengajuans');
    }
};
