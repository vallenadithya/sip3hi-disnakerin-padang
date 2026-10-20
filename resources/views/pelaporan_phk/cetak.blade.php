<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Bukti Pencatatan PHK - {{ $pelaporan->nomor_bukti_lapor_dinas ?? $pelaporan->nomor_lapor }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 11pt; color: #000; background: #fff; }
            @page {
                size: A4;
                margin: 20mm 15mm 20mm 15mm;
            }
        }
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .header-line {
            border-bottom: 3px double #000;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 py-6">

    <!-- Tombol Cetak (Hanya tampil di layar) -->
    <div class="max-w-4xl mx-auto mb-4 px-4 no-print flex justify-between items-center">
        <a href="{{ route('pelaporan-phk.show', $pelaporan->pelaporan_phk_id) }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
            ← Kembali ke Detail Laporan
        </a>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow hover:bg-blue-700 flex items-center gap-2">
                🖨️ Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Halaman Dokumen Cetak A4 -->
    <div class="max-w-4xl mx-auto bg-white p-10 md:p-14 shadow-lg print:shadow-none print:p-0">

        <!-- KOP SURAT RESMI PEMKOT PADANG -->
        <div class="flex items-center justify-between pb-3 header-line mb-6">
            <div class="w-24 text-center">
                <img src="/img/logo_padang.svg" alt="Logo Pemkot Padang" class="w-20 h-20 mx-auto object-contain">
            </div>
            <div class="flex-1 text-center px-4">
                <h3 class="text-lg font-bold uppercase tracking-wider">Pemerintah Kota Padang</h3>
                <h2 class="text-xl font-extrabold uppercase tracking-wide">Dinas Tenaga Kerja dan Perindustrian</h2>
                <p class="text-xs mt-1">Jalan Rasuna Said No. 71, Rimbo Kaluang, Kec. Padang Barat, Kota Padang, Sumatera Barat 25111</p>
                <p class="text-xs">Telepon: (0751) 7052345 | Posel: disnakerin@padang.go.id | Laman: disnakerin.padang.go.id</p>
            </div>
            <div class="w-24 text-center">
                <!-- Simbol Akreditasi / Cap -->
                <div class="w-16 h-16 border-2 border-gray-400 rounded-full mx-auto flex items-center justify-center text-[9px] font-bold text-gray-500 uppercase leading-tight text-center">
                    Disnakerin<br>Padang
                </div>
            </div>
        </div>

        <!-- JUDUL DOKUMEN -->
        <div class="text-center mb-6">
            <h1 class="text-base font-bold uppercase underline tracking-wide">SURAT TANDA BUKTI PENCATATAN PELAPORAN</h1>
            <h2 class="text-base font-bold uppercase">PEMUTUSAN HUBUNGAN KERJA (PHK)</h2>
            <p class="text-sm font-semibold mt-1">
                Nomor: {{ $pelaporan->nomor_bukti_lapor_dinas ?? '560/XXX/HI-PHK/DISNAKERIN-PDG/' . now()->format('Y') }}
            </p>
        </div>

        <!-- KONSIDERAN & DASAR HUKUM -->
        <div class="text-justify text-sm leading-relaxed mb-4">
            <p class="indent-8">
                Berdasarkan ketentuan <strong>Pasal 39 ayat (3) Peraturan Pemerintah Republik Indonesia Nomor 35 Tahun 2021</strong> tentang Perjanjian Kerja Waktu Tertentu, Alih Daya, Waktu Kerja dan Waktu Istirahat, dan Pemutusan Hubungan Kerja juncto Undang-Undang Nomor 6 Tahun 2023, Kepala Dinas Tenaga Kerja dan Perindustrian Kota Padang dengan ini menerangkan bahwa telah menerima dan mencatat secara resmi pelaporan Pemutusan Hubungan Kerja (PHK) yang telah disepakati dan diterima oleh pekerja, dari:
            </p>
        </div>

        <!-- IDENTITAS PERUSAHAAN -->
        <div class="text-sm mb-5 pl-4">
            <table class="w-full">
                <tr>
                    <td class="w-48 py-1 font-semibold">Nama Perusahaan</td>
                    <td class="w-4 py-1">:</td>
                    <td class="py-1 font-bold">{{ $pelaporan->nama_perusahaan }}</td>
                </tr>
                @if($pelaporan->nib)
                <tr>
                    <td class="py-1 font-semibold">Nomor Induk Berusaha (NIB)</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-mono">{{ $pelaporan->nib }}</td>
                </tr>
                @endif
                <tr>
                    <td class="py-1 font-semibold">Sektor Usaha</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $pelaporan->sektor_usaha }}</td>
                </tr>
                <tr>
                    <td class="py-1 font-semibold">Alamat Kantor / Perusahaan</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $pelaporan->alamat_perusahaan }}</td>
                </tr>
                <tr>
                    <td class="py-1 font-semibold">Alasan PHK</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-semibold">{{ $pelaporan->alasan_phk }}</td>
                </tr>
                <tr>
                    <td class="py-1 font-semibold">Tanggal Efektif PHK</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $pelaporan->tanggal_efektif_phk->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="py-1 font-semibold">Nomor Registrasi Laporan</td>
                    <td class="py-1">:</td>
                    <td class="py-1 font-mono font-bold">{{ $pelaporan->nomor_lapor }}</td>
                </tr>
            </table>
        </div>

        <!-- PARAGRAF PEKERJA -->
        <div class="text-justify text-sm leading-relaxed mb-3">
            <p class="indent-8">
                Adapun daftar pekerja yang telah menerima pemutusan hubungan kerja dan telah diselesaikan hak-hak kompensasinya (uang pesangon, uang penghargaan masa kerja, dan uang penggantian hak) adalah sebagai berikut:
            </p>
        </div>

        <!-- TABEL RINCIAN PEKERJA -->
        <div class="mb-5">
            <table class="w-full border-collapse border border-gray-800 text-xs">
                <thead>
                    <tr class="bg-gray-100 text-center font-bold">
                        <th class="border border-gray-800 p-1.5 w-8">No</th>
                        <th class="border border-gray-800 p-1.5">Nama Pekerja</th>
                        <th class="border border-gray-800 p-1.5">NIK (KTP)</th>
                        <th class="border border-gray-800 p-1.5">No. KPJ (BPJS TK)</th>
                        <th class="border border-gray-800 p-1.5">Jabatan Terakhir</th>
                        <th class="border border-gray-800 p-1.5">Masa Kerja</th>
                        <th class="border border-gray-800 p-1.5 text-right">Kompensasi Hak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelaporan->pekerja as $index => $item)
                        <tr>
                            <td class="border border-gray-800 p-1.5 text-center">{{ $index + 1 }}</td>
                            <td class="border border-gray-800 p-1.5 font-bold">{{ $item->nama_pekerja }}</td>
                            <td class="border border-gray-800 p-1.5 text-center font-mono">{{ $item->nik }}</td>
                            <td class="border border-gray-800 p-1.5 text-center font-mono">{{ $item->nomor_kpj ?? '-' }}</td>
                            <td class="border border-gray-800 p-1.5">{{ $item->jabatan }}</td>
                            <td class="border border-gray-800 p-1.5 text-center">{{ $item->masa_kerja }}</td>
                            <td class="border border-gray-800 p-1.5 text-right font-semibold">Rp {{ number_format($item->total_kompensasi, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-bold bg-gray-50">
                        <td colspan="6" class="border border-gray-800 p-1.5 text-right uppercase">Total Kompensasi Disalurkan:</td>
                        <td class="border border-gray-800 p-1.5 text-right font-bold">Rp {{ number_format($pelaporan->total_kompensasi, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- KLAUSA PENUTUP & MANFAAT JKP -->
        <div class="text-justify text-sm leading-relaxed mb-6">
            <p class="indent-8">
                Surat Tanda Bukti Pencatatan ini diterbitkan setelah dilakukan verifikasi administratif terhadap kelengkapan bukti persetujuan pekerja dan pemenuhan hak-hak ketenagakerjaan. Dokumen ini sah dan dapat dipergunakan oleh pekerja yang bersangkutan sebagai salah satu persyaratan pengajuan <strong>Manfaat Program Jaminan Kehilangan Pekerjaan (JKP)</strong> pada BPJS Ketenagakerjaan sesuai peraturan perundang-undangan.
            </p>
        </div>

        <!-- TANDA TANGAN PEJABAT -->
        <div class="flex justify-between items-end mt-8 text-sm">
            <div class="text-center w-52">
                <div class="p-2 border border-dashed border-gray-400 rounded-lg">
                    <p class="text-[9px] text-gray-500 font-mono mb-1">Verifikasi Digital Disnakerin Padang</p>
                    <div class="w-20 h-20 bg-gray-100 mx-auto flex items-center justify-center border font-mono text-[10px] text-gray-400">
                        [QR CODE]
                    </div>
                    <p class="text-[8px] text-gray-400 mt-1 font-mono">{{ $pelaporan->nomor_lapor }}</p>
                </div>
            </div>

            <div class="text-center w-72">
                <p>Padang, {{ $pelaporan->tanggal_diverifikasi ? $pelaporan->tanggal_diverifikasi->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold uppercase mt-1">An. KEPALA DINAS TENAGA KERJA DAN PERINDUSTRIAN KOTA PADANG</p>
                <p class="text-xs font-semibold">Mediator Hubungan Industrial Ahli,</p>

                <!-- TTD space -->
                <div class="h-20 flex items-center justify-center">
                    <span class="text-blue-900 font-serif italic font-bold text-lg opacity-80 underline">
                        {{ $pelaporan->verifikator ? $pelaporan->verifikator->getName() : 'Mochammad Effendi, S.Sos' }}
                    </span>
                </div>

                <p class="font-bold underline text-sm">
                    {{ $pelaporan->verifikator ? $pelaporan->verifikator->getName() : 'Mochammad Effendi, S.Sos' }}
                </p>
                <p class="text-xs text-gray-700">NIP. 19820515 201110 1 008</p>
            </div>
        </div>

    </div>

</body>
</html>
