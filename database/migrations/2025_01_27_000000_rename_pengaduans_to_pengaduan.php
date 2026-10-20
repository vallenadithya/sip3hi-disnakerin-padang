<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('pengaduans')) {
            return;
        }

        // Step 1: Drop foreign key constraints yang mereferensikan pengaduans
        if (Schema::hasTable('jadwal')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->dropForeign(['pengaduan_id']);
            });
        }

        if (Schema::hasTable('dokumen_hubungan_industrial')) {
            Schema::table('dokumen_hubungan_industrial', function (Blueprint $table) {
                $table->dropForeign(['pengaduan_id']);
            });
        }

        if (Schema::hasTable('laporan_pengadilan_hi')) {
            Schema::table('laporan_pengadilan_hi', function (Blueprint $table) {
                $table->dropForeign(['pengaduan_id']);
            });
        }

        // Step 2: Rename tabel pengaduans menjadi pengaduan
        Schema::rename('pengaduans', 'pengaduan');

        // Step 3: Recreate foreign key constraints dengan nama tabel baru
        if (Schema::hasTable('jadwal')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->foreign('pengaduan_id')->references('pengaduan_id')->on('pengaduan')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('dokumen_hubungan_industrial')) {
            Schema::table('dokumen_hubungan_industrial', function (Blueprint $table) {
                $table->foreign('pengaduan_id')->references('pengaduan_id')->on('pengaduan');
            });
        }

        if (Schema::hasTable('laporan_pengadilan_hi')) {
            Schema::table('laporan_pengadilan_hi', function (Blueprint $table) {
                $table->foreign('pengaduan_id')->references('pengaduan_id')->on('pengaduan')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Drop foreign key constraints
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropForeign(['pengaduan_id']);
        });

        Schema::table('dokumen_hubungan_industrial', function (Blueprint $table) {
            $table->dropForeign(['pengaduan_id']);
        });

        Schema::table('laporan_pengadilan_hi', function (Blueprint $table) {
            $table->dropForeign(['pengaduan_id']);
        });

        // Step 2: Rename tabel kembali ke pengaduans
        Schema::rename('pengaduan', 'pengaduans');

        // Step 3: Recreate foreign key constraints
        Schema::table('jadwal', function (Blueprint $table) {
            $table->foreign('pengaduan_id')->references('pengaduan_id')->on('pengaduans')->onDelete('cascade');
        });

        Schema::table('dokumen_hubungan_industrial', function (Blueprint $table) {
            $table->foreign('pengaduan_id')->references('pengaduan_id')->on('pengaduans');
        });

        Schema::table('laporan_pengadilan_hi', function (Blueprint $table) {
            $table->foreign('pengaduan_id')->references('pengaduan_id')->on('pengaduans')->onDelete('cascade');
        });
    }
};
