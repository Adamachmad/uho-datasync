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
        Schema::table('pengajuan', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan', 'keterangan_penolakan')) {
                $table->text('keterangan_penolakan')->nullable()->after('keterangan_user');
            }
        });

        Schema::table('riwayat_pengajuan', function (Blueprint $table) {
            if (!Schema::hasColumn('riwayat_pengajuan', 'keterangan_penolakan')) {
                $table->text('keterangan_penolakan')->nullable()->after('catatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pengajuan', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_pengajuan', 'keterangan_penolakan')) {
                $table->dropColumn('keterangan_penolakan');
            }
        });

        Schema::table('pengajuan', function (Blueprint $table) {
            if (Schema::hasColumn('pengajuan', 'keterangan_penolakan')) {
                $table->dropColumn('keterangan_penolakan');
            }
        });
    }
};
