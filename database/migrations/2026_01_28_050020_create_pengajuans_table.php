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
    Schema::create('pengajuan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_pengaju')->constrained('pengaju')->onDelete('cascade');
        $table->foreignId('id_jenis_pengajuan')->constrained('jenis_pengajuan')->onDelete('cascade');
        
        // Relasi ke tabel Status (Bukan Enum lagi)
        $table->foreignId('id_status_pengajuan')->constrained('status_pengajuan');
        
        $table->text('keterangan_user')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
