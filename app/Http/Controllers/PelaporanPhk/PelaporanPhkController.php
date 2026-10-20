<?php

namespace App\Http\Controllers\PelaporanPhk;

use App\Http\Controllers\Controller;
use App\Models\DetailPekerjaPhk;
use App\Models\PelaporanPhk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PelaporanPhkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PelaporanPhk::with(['pekerja', 'verifikator'])->latest();

        // Scope data berdasarkan role
        if (in_array($user->active_role, ['pelapor', 'terlapor'])) {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->user_id)
                  ->orWhere('email_perusahaan', $user->email);
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter sektor usaha
        if ($request->filled('sektor_usaha')) {
            $query->where('sektor_usaha', $request->sektor_usaha);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                  ->orWhere('nomor_lapor', 'like', "%{$search}%")
                  ->orWhere('nomor_bukti_lapor_dinas', 'like', "%{$search}%");
            });
        }

        $pelaporans = $query->paginate(10)->withQueryString();

        // Statistik ringkas untuk widget
        $statQuery = PelaporanPhk::query();
        if (in_array($user->active_role, ['pelapor', 'terlapor'])) {
            $statQuery->where(function ($q) use ($user) {
                $q->where('user_id', $user->user_id)
                  ->orWhere('email_perusahaan', $user->email);
            });
        }

        $stats = [
            'total' => (clone $statQuery)->count(),
            'menunggu' => (clone $statQuery)->where('status', 'menunggu_verifikasi')->count(),
            'terverifikasi' => (clone $statQuery)->where('status', 'terverifikasi')->count(),
            'perlu_revisi' => (clone $statQuery)->where('status', 'perlu_revisi')->count(),
            'total_pekerja' => (clone $statQuery)->sum('total_pekerja'),
        ];

        return view('pelaporan_phk.index', compact('pelaporans', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $profile = $user->getProfile();

        $defaultData = [
            'nama_perusahaan' => '',
            'email_perusahaan' => $user->email ?? '',
            'alamat_perusahaan' => '',
            'no_telepon' => '',
            'nama_kontak' => $user->getName() ?? '',
        ];

        if ($user->active_role === 'terlapor' && $profile) {
            $defaultData['nama_perusahaan'] = $profile->nama_terlapor ?? '';
            $defaultData['alamat_perusahaan'] = $profile->alamat_kantor_cabang ?? '';
            $defaultData['no_telepon'] = $profile->no_hp_terlapor ?? '';
            $defaultData['email_perusahaan'] = $profile->email_terlapor ?? $user->email;
        } elseif ($user->active_role === 'pelapor' && $profile) {
            $defaultData['nama_perusahaan'] = $profile->perusahaan ?? '';
            $defaultData['no_telepon'] = $profile->no_hp ?? '';
        }

        $alasanList = [
            'Efisiensi Perusahaan Karena Mengalami Kerugian (Pasal 43 ayat 1 PP 35/2021)',
            'Efisiensi Untuk Mencegah Terjadinya Kerugian (Pasal 43 ayat 2 PP 35/2021)',
            'Perusahaan Tutup Karena Keadaan Memaksa / Force Majeure (Pasal 44 PP 35/2021)',
            'Perusahaan Melakukan Penggabungan, Peleburan, atau Pemisahan (Pasal 41 PP 35/2021)',
            'Perusahaan Dalam Keadaan Penundaan Kewajiban Pembayaran Utang / Pailit (Pasal 45 PP 35/2021)',
            'Pekerja Memasuki Usia Pensiun (Pasal 56 PP 35/2021)',
            'Pekerja Meninggal Dunia (Pasal 57 PP 35/2021)',
            'Pekerja Mengundurkan Diri Atas Kemauan Sendiri / Resign (Pasal 50 PP 35/2021)',
            'Pekerja Menerima PHK Sesuai Kesepakatan Bersama Bipartit (Pasal 39 PP 35/2021)',
        ];

        $sektorList = [
            'Perdagangan Besar dan Eceran',
            'Industri Pengolahan / Manufaktur',
            'Akomodasi, Hotel dan Restoran',
            'Jasa Keuangan dan Asuransi',
            'Konstruksi dan Real Estate',
            'Transportasi, Pergudangan dan Logistik',
            'Informasi dan Komunikasi',
            'Kesehatan dan Aktivitas Sosial',
            'Pendidikan',
            'Pertanian, Perkebunan dan Perikanan',
            'Lainnya',
        ];

        return view('pelaporan_phk.create', compact('defaultData', 'alasanList', 'sektorList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nib' => 'nullable|string|max:50',
            'sektor_usaha' => 'required|string|max:100',
            'alamat_perusahaan' => 'required|string',
            'nama_kontak' => 'required|string|max:150',
            'jabatan_kontak' => 'nullable|string|max:100',
            'no_telepon' => 'required|string|max:30',
            'email_perusahaan' => 'required|email|max:150',
            'alasan_phk' => 'required|string|max:255',
            'tanggal_efektif_phk' => 'required|date',
            'tanggal_pemberitahuan' => 'nullable|date',
            'file_surat_pemberitahuan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_persetujuan_pekerja' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_bukti_kompensasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'pekerja' => 'required|array|min:1',
            'pekerja.*.nama_pekerja' => 'required|string|max:255',
            'pekerja.*.nik' => 'required|string|max:30',
            'pekerja.*.nomor_kpj' => 'nullable|string|max:50',
            'pekerja.*.jabatan' => 'required|string|max:100',
            'pekerja.*.masa_kerja' => 'required|string|max:50',
            'pekerja.*.uang_pesangon' => 'nullable|numeric|min:0',
            'pekerja.*.uang_penghargaan' => 'nullable|numeric|min:0',
            'pekerja.*.uang_penggantian_hak' => 'nullable|numeric|min:0',
        ], [
            'file_persetujuan_pekerja.required' => 'Surat bukti persetujuan/penerimaan PHK dari pekerja wajib diunggah sesuai PP 35/2021.',
            'pekerja.required' => 'Daftar rincian pekerja yang menerima PHK wajib diisi minimal 1 orang.',
        ]);

        return DB::transaction(function () use ($request) {
            // Upload file
            $filePemberitahuan = null;
            if ($request->hasFile('file_surat_pemberitahuan')) {
                $filePemberitahuan = $request->file('file_surat_pemberitahuan')->store('pelaporan_phk/pemberitahuan', 'public');
            }

            $filePersetujuan = null;
            if ($request->hasFile('file_persetujuan_pekerja')) {
                $filePersetujuan = $request->file('file_persetujuan_pekerja')->store('pelaporan_phk/persetujuan', 'public');
            }

            $fileKompensasi = null;
            if ($request->hasFile('file_bukti_kompensasi')) {
                $fileKompensasi = $request->file('file_bukti_kompensasi')->store('pelaporan_phk/kompensasi', 'public');
            }

            // Hitung total pekerja dan total pesangon/kompensasi
            $totalPekerja = count($request->pekerja);
            $totalKompensasi = 0;

            $pekerjaData = [];
            foreach ($request->pekerja as $item) {
                $pesangon = (float)($item['uang_pesangon'] ?? 0);
                $upmk = (float)($item['uang_penghargaan'] ?? 0);
                $uph = (float)($item['uang_penggantian_hak'] ?? 0);
                $subtotal = $pesangon + $upmk + $uph;

                $totalKompensasi += $subtotal;

                $pekerjaData[] = [
                    'nama_pekerja' => $item['nama_pekerja'],
                    'nik' => $item['nik'],
                    'nomor_kpj' => $item['nomor_kpj'] ?? null,
                    'jabatan' => $item['jabatan'],
                    'masa_kerja' => $item['masa_kerja'],
                    'uang_pesangon' => $pesangon,
                    'uang_penghargaan' => $upmk,
                    'uang_penggantian_hak' => $uph,
                    'total_kompensasi' => $subtotal,
                ];
            }

            // Simpan header pelaporan PHK
            $pelaporan = PelaporanPhk::create([
                'user_id' => Auth::id(),
                'nama_perusahaan' => $request->nama_perusahaan,
                'nib' => $request->nib,
                'sektor_usaha' => $request->sektor_usaha,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'nama_kontak' => $request->nama_kontak,
                'jabatan_kontak' => $request->jabatan_kontak,
                'no_telepon' => $request->no_telepon,
                'email_perusahaan' => $request->email_perusahaan,
                'alasan_phk' => $request->alasan_phk,
                'dasar_hukum' => 'PP No. 35 Tahun 2021 & UU Cipta Kerja',
                'tanggal_efektif_phk' => $request->tanggal_efektif_phk,
                'tanggal_pemberitahuan' => $request->tanggal_pemberitahuan,
                'total_pekerja' => $totalPekerja,
                'total_kompensasi' => $totalKompensasi,
                'file_surat_pemberitahuan' => $filePemberitahuan,
                'file_persetujuan_pekerja' => $filePersetujuan,
                'file_bukti_kompensasi' => $fileKompensasi,
                'status' => 'menunggu_verifikasi',
            ]);

            // Simpan detail pekerja
            foreach ($pekerjaData as $p) {
                $pelaporan->pekerja()->create($p);
            }

            return redirect()->route('pelaporan-phk.show', $pelaporan->pelaporan_phk_id)
                ->with('success', 'Laporan PHK berhasil diajukan dengan nomor: ' . $pelaporan->nomor_lapor . '. Berkas sedang menunggu verifikasi Disnakerin Kota Padang.');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelaporan = PelaporanPhk::with(['pekerja', 'user', 'verifikator'])->findOrFail($id);
        $user = Auth::user();

        // Security check
        if (in_array($user->active_role, ['pelapor', 'terlapor'])) {
            if ($pelaporan->user_id !== $user->user_id && $pelaporan->email_perusahaan !== $user->email) {
                abort(403, 'Anda tidak memiliki hak akses untuk melihat pelaporan ini.');
            }
        }

        return view('pelaporan_phk.show', compact('pelaporan'));
    }

    /**
     * Verifikasi pelaporan PHK oleh Mediator / Petugas Disnakerin
     */
    public function verifikasi(Request $request, string $id)
    {
        $user = Auth::user();
        if (!in_array($user->active_role, ['mediator', 'kepala_dinas'])) {
            abort(403, 'Hanya petugas Disnakerin atau Kepala Dinas yang dapat melakukan verifikasi.');
        }

        $request->validate([
            'status' => 'required|in:terverifikasi,perlu_revisi,ditolak',
            'catatan_verifikasi' => 'nullable|string|max:1000',
        ]);

        $pelaporan = PelaporanPhk::findOrFail($id);

        if ($request->status === 'terverifikasi') {
            if (!$pelaporan->nomor_bukti_lapor_dinas) {
                $pelaporan->nomor_bukti_lapor_dinas = $pelaporan->generateNomorBuktiLapor();
            }
            $pelaporan->status = 'terverifikasi';
            $pelaporan->catatan_verifikasi = $request->catatan_verifikasi ?? 'Berkas persyaratan lengkap dan telah sesuai dengan ketentuan PP No. 35 Tahun 2021.';
        } else {
            $pelaporan->status = $request->status;
            $pelaporan->catatan_verifikasi = $request->catatan_verifikasi;
        }

        $pelaporan->verifikator_id = $user->user_id;
        $pelaporan->tanggal_diverifikasi = now();
        $pelaporan->save();

        $pesan = $request->status === 'terverifikasi'
            ? 'Pelaporan PHK berhasil diverifikasi! Nomor Bukti Lapor Resmi telah diterbitkan: ' . $pelaporan->nomor_bukti_lapor_dinas
            : 'Status pelaporan PHK diperbarui menjadi: ' . ucfirst(str_replace('_', ' ', $request->status));

        return redirect()->route('pelaporan-phk.show', $pelaporan->pelaporan_phk_id)
            ->with('success', $pesan);
    }

    /**
     * Cetak Surat Tanda Bukti Lapor PHK Resmi Disnakerin Kota Padang
     */
    public function cetak(string $id)
    {
        $pelaporan = PelaporanPhk::with(['pekerja', 'verifikator'])->findOrFail($id);

        return view('pelaporan_phk.cetak', compact('pelaporan'));
    }

    /**
     * Statistik & Rekap PHK Kota Padang untuk Kepala Dinas & Mediator
     */
    public function statistik(Request $request)
    {
        $tahun = $request->get('tahun', now()->format('Y'));

        // Agregat utama
        $totalLaporan = PelaporanPhk::whereYear('tanggal_efektif_phk', $tahun)->count();
        $totalPekerja = PelaporanPhk::whereYear('tanggal_efektif_phk', $tahun)->sum('total_pekerja');
        $totalKompensasi = PelaporanPhk::whereYear('tanggal_efektif_phk', $tahun)->sum('total_kompensasi');
        $totalTerverifikasi = PelaporanPhk::whereYear('tanggal_efektif_phk', $tahun)->where('status', 'terverifikasi')->count();

        // Rekap per sektor
        $rekapSektor = PelaporanPhk::whereYear('tanggal_efektif_phk', $tahun)
            ->select('sektor_usaha', DB::raw('count(*) as count'), DB::raw('sum(total_pekerja) as pekerja'))
            ->groupBy('sektor_usaha')
            ->orderByDesc('pekerja')
            ->get();

        // Rekap per alasan PHK
        $rekapAlasan = PelaporanPhk::whereYear('tanggal_efektif_phk', $tahun)
            ->select('alasan_phk', DB::raw('count(*) as count'), DB::raw('sum(total_pekerja) as pekerja'))
            ->groupBy('alasan_phk')
            ->orderByDesc('pekerja')
            ->get();

        // Tren per bulan
        $trenBulanan = PelaporanPhk::whereYear('tanggal_efektif_phk', $tahun)
            ->select(
                DB::raw('MONTH(tanggal_efektif_phk) as bulan'),
                DB::raw('count(*) as total_laporan'),
                DB::raw('sum(total_pekerja) as total_pekerja')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('pelaporan_phk.statistik', compact(
            'tahun',
            'totalLaporan',
            'totalPekerja',
            'totalKompensasi',
            'totalTerverifikasi',
            'rekapSektor',
            'rekapAlasan',
            'trenBulanan',
            'daftarBulan'
        ));
    }
}
