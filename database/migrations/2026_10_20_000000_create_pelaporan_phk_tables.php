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
        Schema::create('pelaporan_phk', function (Blueprint $table) {
            $table->uuid('pelaporan_phk_id')->primary();
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');

            $table->string('nomor_lapor', 60)->unique();
            $table->string('nomor_bukti_lapor_dinas', 120)->nullable()->unique();
            $table->string('nama_perusahaan', 255);
            $table->string('nib', 50)->nullable();
            $table->string('sektor_usaha', 100);
            $table->text('alamat_perusahaan');
            $table->string('nama_kontak', 150);
            $table->string('jabatan_kontak', 100)->nullable();
            $table->string('no_telepon', 30);
            $table->string('email_perusahaan', 150);

            // Alasan PHK sesuai PP 35/2021
            $table->string('alasan_phk', 255);
            $table->string('dasar_hukum', 255)->default('PP No. 35 Tahun 2021');
            $table->date('tanggal_efektif_phk');
            $table->date('tanggal_pemberitahuan')->nullable();

            $table->integer('total_pekerja')->default(1);
            $table->decimal('total_kompensasi', 15, 2)->default(0);

            // File kelengkapan berkas administratif (syarat wajib verifikasi Disnakerin)
            $table->string('file_surat_pemberitahuan', 255)->nullable();
            $table->string('file_persetujuan_pekerja', 255)->nullable()->comment('Surat persetujuan menerima PHK / PB Bipartit');
            $table->string('file_bukti_kompensasi', 255)->nullable()->comment('Bukti pemenuhan hak/transfer pesangon');

            // Status Verifikasi oleh Petugas Disnakerin Padang
            $table->enum('status', ['menunggu_verifikasi', 'terverifikasi', 'perlu_revisi', 'ditolak'])->default('menunggu_verifikasi');
            $table->text('catatan_verifikasi')->nullable();
            $table->uuid('verifikator_id')->nullable();
            $table->foreign('verifikator_id')->references('user_id')->on('users')->onDelete('set null');
            $table->datetime('tanggal_diverifikasi')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('detail_pekerja_phk', function (Blueprint $table) {
            $table->uuid('detail_pekerja_id')->primary();
            $table->uuid('pelaporan_phk_id');
            $table->foreign('pelaporan_phk_id')->references('pelaporan_phk_id')->on('pelaporan_phk')->onDelete('cascade');

            $table->string('nama_pekerja', 255);
            $table->string('nik', 30);
            $table->string('nomor_kpj', 50)->nullable()->comment('Nomor BPJS Ketenagakerjaan');
            $table->string('jabatan', 100);
            $table->string('masa_kerja', 50)->comment('Contoh: 3 Tahun 2 Bulan');

            // Rincian Hak Kompensasi PHK PP 35/2021
            $table->decimal('uang_pesangon', 15, 2)->default(0);
            $table->decimal('uang_penghargaan', 15, 2)->default(0);
            $table->decimal('uang_penggantian_hak', 15, 2)->default(0);
            $table->decimal('total_kompensasi', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pekerja_phk');
        Schema::dropIfExists('pelaporan_phk');
    }
};
