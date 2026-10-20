<?php

namespace Database\Seeders;

use App\Models\DetailPekerjaPhk;
use App\Models\PelaporanPhk;
use App\Models\User;
use Illuminate\Database\Seeder;

class PelaporanPhkSeeder extends Seeder
{
    public function run(): void
    {
        $mediator = User::whereJsonContains('roles', 'mediator')->first();
        $userTerlapor = User::whereJsonContains('roles', 'terlapor')->first();
        $userPelapor = User::whereJsonContains('roles', 'pelapor')->first();

        // 1. PT Semen Padang Distributor Logistik (Terverifikasi)
        $phk1 = PelaporanPhk::create([
            'user_id' => $userTerlapor ? $userTerlapor->user_id : null,
            'nomor_lapor' => 'PHK/PDG/20261015/0001',
            'nomor_bukti_lapor_dinas' => '560/018/HI-PHK/DISNAKERIN-PDG/X/2026',
            'nama_perusahaan' => 'PT Semen Padang Distributor Logistik',
            'nib' => '9120003847192',
            'sektor_usaha' => 'Transportasi, Pergudangan dan Logistik',
            'alamat_perusahaan' => 'Jl. Raya Padang - Indarung Km. 14, Kota Padang',
            'nama_kontak' => 'Bambang Sudarsono, S.E.',
            'jabatan_kontak' => 'Senior HR Manager',
            'no_telepon' => '081267891234',
            'email_perusahaan' => 'hrd@spdistributor.co.id',
            'alasan_phk' => 'Efisiensi Perusahaan Karena Mengalami Kerugian (Pasal 43 ayat 1 PP 35/2021)',
            'dasar_hukum' => 'PP No. 35 Tahun 2021 & UU No. 6 Tahun 2023',
            'tanggal_efektif_phk' => '2026-10-15',
            'tanggal_pemberitahuan' => '2026-09-28',
            'total_pekerja' => 2,
            'total_kompensasi' => 60300000,
            'status' => 'terverifikasi',
            'catatan_verifikasi' => 'Berkas persyaratan telah diperiksa lengkap. Surat persetujuan menerima PHK dan pemenuhan hak pesangon sesuai ketentuan PP 35/2021 telah terbukti.',
            'verifikator_id' => $mediator ? $mediator->user_id : null,
            'tanggal_diverifikasi' => now()->subDays(4),
        ]);

        DetailPekerjaPhk::create([
            'pelaporan_phk_id' => $phk1->pelaporan_phk_id,
            'nama_pekerja' => 'Ilham Ramadhan',
            'nik' => '1371011204920003',
            'nomor_kpj' => '180293849102',
            'jabatan' => 'Driver Logistik Tronton',
            'masa_kerja' => '4 Tahun 2 Bulan',
            'uang_pesangon' => 24000000,
            'uang_penghargaan' => 8000000,
            'uang_penggantian_hak' => 2500000,
            'total_kompensasi' => 34500000,
        ]);

        DetailPekerjaPhk::create([
            'pelaporan_phk_id' => $phk1->pelaporan_phk_id,
            'nama_pekerja' => 'Rahmat Hidayat',
            'nik' => '1371031908950002',
            'nomor_kpj' => '190392819201',
            'jabatan' => 'Operator Gudang',
            'masa_kerja' => '3 Tahun 1 Bulan',
            'uang_pesangon' => 18000000,
            'uang_penghargaan' => 6000000,
            'uang_penggantian_hak' => 1800000,
            'total_kompensasi' => 25800000,
        ]);

        // 2. PT Grand Zuri Hotel Padang (Terverifikasi)
        $phk2 = PelaporanPhk::create([
            'user_id' => $userTerlapor ? $userTerlapor->user_id : null,
            'nomor_lapor' => 'PHK/PDG/20261018/0002',
            'nomor_bukti_lapor_dinas' => '560/019/HI-PHK/DISNAKERIN-PDG/X/2026',
            'nama_perusahaan' => 'PT Grand Zuri Hotel Padang',
            'nib' => '8120002938471',
            'sektor_usaha' => 'Akomodasi, Hotel dan Restoran',
            'alamat_perusahaan' => 'Jl. MH Thamrin No. 27, Alang Laweh, Kec. Padang Selatan, Kota Padang',
            'nama_kontak' => 'Dewi Sartika',
            'jabatan_kontak' => 'HR & General Affair',
            'no_telepon' => '081374567890',
            'email_perusahaan' => 'hr@grandzuripadang.com',
            'alasan_phk' => 'Pekerja Memasuki Usia Pensiun (Pasal 56 PP 35/2021)',
            'dasar_hukum' => 'PP No. 35 Tahun 2021 & UU No. 6 Tahun 2023',
            'tanggal_efektif_phk' => '2026-10-18',
            'tanggal_pemberitahuan' => '2026-09-15',
            'total_pekerja' => 1,
            'total_kompensasi' => 96000000,
            'status' => 'terverifikasi',
            'catatan_verifikasi' => 'Memasuki usia pensiun sesuai batas usia Peraturan Perusahaan. Hak pensiun telah dibayarkan penuh.',
            'verifikator_id' => $mediator ? $mediator->user_id : null,
            'tanggal_diverifikasi' => now()->subDays(2),
        ]);

        DetailPekerjaPhk::create([
            'pelaporan_phk_id' => $phk2->pelaporan_phk_id,
            'nama_pekerja' => 'Syafruddin Tanjung',
            'nik' => '1371020503680001',
            'nomor_kpj' => '110293840192',
            'jabatan' => 'Chief Engineering Hotel',
            'masa_kerja' => '18 Tahun',
            'uang_pesangon' => 65000000,
            'uang_penghargaan' => 25000000,
            'uang_penggantian_hak' => 6000000,
            'total_kompensasi' => 96000000,
        ]);

        // 3. PT Hayati Pratama Mandiri (Menunggu Verifikasi)
        $phk3 = PelaporanPhk::create([
            'user_id' => $userPelapor ? $userPelapor->user_id : null,
            'nomor_lapor' => 'PHK/PDG/20261020/0003',
            'nama_perusahaan' => 'PT Hayati Pratama Mandiri (Honda Padang)',
            'nib' => '0220005829104',
            'sektor_usaha' => 'Perdagangan Besar dan Eceran',
            'alamat_perusahaan' => 'Jl. Pemuda No. 35, Olo, Kec. Padang Barat, Kota Padang',
            'nama_kontak' => 'Faisal Reza, S.Psi',
            'jabatan_kontak' => 'HR Specialist',
            'no_telepon' => '082170984532',
            'email_perusahaan' => 'personalia@hayatimotor.com',
            'alasan_phk' => 'Pekerja Menerima PHK Sesuai Kesepakatan Bersama Bipartit (Pasal 39 PP 35/2021)',
            'dasar_hukum' => 'PP No. 35 Tahun 2021 & UU No. 6 Tahun 2023',
            'tanggal_efektif_phk' => '2026-10-20',
            'tanggal_pemberitahuan' => '2026-10-05',
            'total_pekerja' => 2,
            'total_kompensasi' => 66700000,
            'status' => 'menunggu_verifikasi',
        ]);

        DetailPekerjaPhk::create([
            'pelaporan_phk_id' => $phk3->pelaporan_phk_id,
            'nama_pekerja' => 'Doni Kurniawan',
            'nik' => '1371042507930005',
            'nomor_kpj' => '170492819302',
            'jabatan' => 'Sales Counter Supervisor',
            'masa_kerja' => '5 Tahun 3 Bulan',
            'uang_pesangon' => 32000000,
            'uang_penghargaan' => 10000000,
            'uang_penggantian_hak' => 3200000,
            'total_kompensasi' => 45200000,
        ]);

        DetailPekerjaPhk::create([
            'pelaporan_phk_id' => $phk3->pelaporan_phk_id,
            'nama_pekerja' => 'Anita Wijaya',
            'nik' => '1371051411960002',
            'nomor_kpj' => '190582910403',
            'jabatan' => 'Staff Administrasi Keuangan',
            'masa_kerja' => '2 Tahun 8 Bulan',
            'uang_pesangon' => 15000000,
            'uang_penghargaan' => 5000000,
            'uang_penggantian_hak' => 1500000,
            'total_kompensasi' => 21500000,
        ]);

        // 4. CV Minang Kriya Lestari (Perlu Revisi)
        $phk4 = PelaporanPhk::create([
            'user_id' => $userTerlapor ? $userTerlapor->user_id : null,
            'nomor_lapor' => 'PHK/PDG/20261019/0004',
            'nama_perusahaan' => 'CV Minang Kriya Lestari',
            'nib' => '9120004928103',
            'sektor_usaha' => 'Industri Pengolahan / Manufaktur',
            'alamat_perusahaan' => 'Jl. Veteran No. 12, Purus, Kec. Padang Barat, Kota Padang',
            'nama_kontak' => 'Hendra Putra',
            'jabatan_kontak' => 'Operational Manager',
            'no_telepon' => '081275432198',
            'email_perusahaan' => 'admin@minangkriya.com',
            'alasan_phk' => 'Perusahaan Melakukan Penggabungan, Peleburan, atau Pemisahan (Pasal 41 PP 35/2021)',
            'dasar_hukum' => 'PP No. 35 Tahun 2021 & UU No. 6 Tahun 2023',
            'tanggal_efektif_phk' => '2026-10-19',
            'tanggal_pemberitahuan' => '2026-10-01',
            'total_pekerja' => 1,
            'total_kompensasi' => 18500000,
            'status' => 'perlu_revisi',
            'catatan_verifikasi' => 'Lampiran surat tanda terima pembayaran hak pesangon belum terbaca jelas. Mohon unggah ulang bukti transfer bank yang valid.',
            'verifikator_id' => $mediator ? $mediator->user_id : null,
            'tanggal_diverifikasi' => now()->subDay(),
        ]);

        DetailPekerjaPhk::create([
            'pelaporan_phk_id' => $phk4->pelaporan_phk_id,
            'nama_pekerja' => 'Yuliana Fitri',
            'nik' => '1371060905970004',
            'nomor_kpj' => '200492810293',
            'jabatan' => 'Desainer Produk',
            'masa_kerja' => '2 Tahun 1 Bulan',
            'uang_pesangon' => 12000000,
            'uang_penghargaan' => 4500000,
            'uang_penggantian_hak' => 2000000,
            'total_kompensasi' => 18500000,
        ]);
    }
}
