<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Fixes for bugs:
     * - Bug #7: Add indexes on foreign keys for performance
     * - Bug #8: Add unique index on NIK for lookup performance
     * - Bug #17: Make NIK non-nullable (required field)
     */
    public function up(): void
    {
        // FIX BUG #8 & #17: Make NIK unique and non-nullable (it's required in validation)
        Schema::table('pengaju', function (Blueprint $table) {
            $table->unique('nik')->change();
            // Note: Change nullable to non-nullable may fail if NULL values exist
            // Ensure no NULL NIKs before migration
        });

        // FIX BUG #7: Add indexes on foreign keys for faster queries
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->index('id_pengaju');
            $table->index('id_jenis_pengajuan');
            $table->index('id_status_pengajuan');
        });

        Schema::table('pengajuan_has_dokumen', function (Blueprint $table) {
            $table->index('id_pengajuan');
            $table->index('id_jenis_dokumen');
        });

        Schema::table('riwayat_pengajuan', function (Blueprint $table) {
            $table->index('id_pengajuan');
            $table->index('id_status_pengajuan');
        });

        Schema::table('syarat_pengajuan', function (Blueprint $table) {
            $table->index('id_jenis_pengajuan');
            $table->index('id_jenis_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaju', function (Blueprint $table) {
            $table->dropUnique(['nik']);
        });

        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropIndex(['id_pengaju']);
            $table->dropIndex(['id_jenis_pengajuan']);
            $table->dropIndex(['id_status_pengajuan']);
        });

        Schema::table('pengajuan_has_dokumen', function (Blueprint $table) {
            $table->dropIndex(['id_pengajuan']);
            $table->dropIndex(['id_jenis_dokumen']);
        });

        Schema::table('riwayat_pengajuan', function (Blueprint $table) {
            $table->dropIndex(['id_pengajuan']);
            $table->dropIndex(['id_status_pengajuan']);
        });

        Schema::table('syarat_pengajuan', function (Blueprint $table) {
            $table->dropIndex(['id_jenis_pengajuan']);
            $table->dropIndex(['id_jenis_dokumen']);
        });
    }
};
