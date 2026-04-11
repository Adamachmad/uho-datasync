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
            $table->unsignedBigInteger('id_pengaju');
            $table->foreign('id_pengaju')->references('id')->on('pengaju')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_jenis_pengajuan');
            $table->foreign('id_jenis_pengajuan')->references('id')->on('jenis_pengajuan')->onDelete('cascade');
            
            $table->unsignedBigInteger('id_status_pengajuan');
            $table->foreign('id_status_pengajuan')->references('id')->on('status_pengajuan');
            
            $table->text('keterangan_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};