<?php

// app/Http/Controllers/Dashboard/DashboardController.php
namespace App\Http\Controllers\Dashboard;

use App\Models\Pelapor;
use App\Models\Pengaduan;
use App\Models\Jadwal;
use App\Models\PelaporanPhk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function roleSelection()
    {
        return view('dashboard.role-selection');
    }

    public function setRole(Request $request)
    {
        $user = Auth::user();
        $role = $request->input('role');

        if (!in_array($role, $user->roles)) {
            return back()->withErrors(['role' => 'Role tidak valid.']);
        }

        $user->setActiveRole($role);

        switch ($role) {
            case 'pelapor':
                return redirect()->route('dashboard.pelapor');
            case 'terlapor':
                return redirect()->route('dashboard.terlapor');
            case 'mediator':
                return redirect()->route('dashboard.mediator');
            case 'kepala_dinas':
                return redirect()->route('dashboard.kepala-dinas');
            default:
                return redirect()->route('dashboard.role-selection')
                    ->withErrors(['role' => 'Role tidak valid.']);
        }
    }

    public function pelapor()
    {
        // Gunakan Auth facade untuk lebih aman
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Pastikan user adalah pelapor
        if ($user->active_role !== 'pelapor') {
            abort(403, 'Access denied');
        }

        // Ambil data pelapor berdasarkan user_id
        $pelapor = Pelapor::where('user_id', $user->user_id)->first();

        // Inisialisasi pengaduans sebagai collection kosong
        $pengaduans = collect();
        $jadwal = collect();

        // Stats default
        $stats = [
            'total_pengaduan' => 0,
            'pengaduan_proses' => 0,
            'pengaduan_selesai' => 0,
            'jadwal_menunggu_konfirmasi' => 0,
        ];

        // Jika pelapor ada, ambil pengaduan dan hitung stats
        if ($pelapor) {
            // Ambil semua pengaduan milik pelapor ini
            $pengaduans = Pengaduan::where('pelapor_id', $pelapor->pelapor_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Ambil jadwal yang aktif (dijadwalkan) untuk ditampilkan
            $jadwal = Jadwal::with(['pengaduan', 'mediator'])
                ->whereHas('pengaduan', function ($query) use ($pelapor) {
                    $query->where('pelapor_id', $pelapor->pelapor_id);
                })
                ->where('status_jadwal', 'dijadwalkan')
                ->orderBy('tanggal', 'asc')
                ->get();

            // Hitung stats berdasarkan pengaduan real
            $stats = [
                'total_pengaduan' => $pengaduans->count(),
                'pengaduan_proses' => $pengaduans->whereIn('status', ['pending', 'proses'])->count(),
                'pengaduan_selesai' => $pengaduans->where('status', 'selesai')->count(),
                'jadwal_menunggu_konfirmasi' => $jadwal->where('konfirmasi_pelapor', 'pending')->count(),
            ];
        }

        // Ambil anjuran yang sudah dipublish tapi belum direspon oleh pelapor
        $pendingAnjuran = collect();
        if ($pelapor) {
            $pendingAnjuran = \App\Models\Anjuran::with(['dokumenHI.pengaduan'])
                ->whereHas('dokumenHI.pengaduan', function ($query) use ($pelapor) {
                    $query->where('pelapor_id', $pelapor->pelapor_id);
                })
                ->where('status_approval', 'published')
                ->where(function ($query) {
                    $query->whereNull('response_pelapor')
                        ->orWhere('response_pelapor', 'pending');
                })
                ->where('created_at', '>=', now()->subDays(10)) // Hanya anjuran dalam 10 hari terakhir
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Tambahkan statistik anjuran yang menunggu respon
        $stats['anjuran_menunggu_respon'] = $pendingAnjuran->count();

        return view('dashboard.pelapor', compact('user', 'stats', 'pengaduans', 'pelapor', 'jadwal', 'pendingAnjuran'));
    }

    public function terlapor()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->active_role !== 'terlapor') {
            abort(403, 'Access denied');
        }

        // Inisialisasi
        $jadwal = collect();

        // Data khusus untuk terlapor
        $stats = [
            'total_aduan_terhadap_saya' => 0,
            'menunggu_respons' => 0,
            'dalam_mediasi' => 0,
            'jadwal_menunggu_konfirmasi' => 0,
        ];

        // Ambil data pengaduan yang melibatkan terlapor ini
        if ($terlapor = $user->terlapor) {
            // Ambil semua pengaduan yang melibatkan terlapor ini
            $pengaduans = Pengaduan::where('terlapor_id', $terlapor->terlapor_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Ambil jadwal  yang perlu dikonfirmasi
            $jadwal = Jadwal::with(['pengaduan', 'mediator'])
                ->whereHas('pengaduan', function ($query) use ($terlapor) {
                    $query->where('terlapor_id', $terlapor->terlapor_id);
                })
                ->where('status_jadwal', 'dijadwalkan')
                ->orderBy('tanggal', 'asc')
                ->get();

            // Hitung stats berdasarkan pengaduan real
            $stats = [
                'total_aduan_terhadap_saya' => $pengaduans->count() ?? 0,
                'menunggu_respons' => $pengaduans->where('status', 'pending')->count() ?? 0,
                'dalam_mediasi' => $pengaduans->where('status', 'proses')->count() ?? 0,
                'jadwal_menunggu_konfirmasi' => $jadwal->where('konfirmasi_terlapor', 'pending')->count(),
                'selesai' => $pengaduans->where('status', 'selesai')->count() ?? 0,
            ];
        }

        // Ambil anjuran yang sudah dipublish tapi belum direspon oleh terlapor
        $pendingAnjuran = collect();
        if ($terlapor) {
            $pendingAnjuran = \App\Models\Anjuran::with(['dokumenHI.pengaduan'])
                ->whereHas('dokumenHI.pengaduan', function ($query) use ($terlapor) {
                    $query->where('terlapor_id', $terlapor->terlapor_id);
                })
                ->where('status_approval', 'published')
                ->where(function ($query) {
                    $query->whereNull('response_terlapor')
                        ->orWhere('response_terlapor', 'pending');
                })
                ->where('created_at', '>=', now()->subDays(10)) // Hanya anjuran dalam 10 hari terakhir
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Tambahkan statistik anjuran yang menunggu respon
        $stats['anjuran_menunggu_respon'] = $pendingAnjuran->count();

        return view('dashboard.terlapor', compact('user', 'stats', 'jadwal', 'pendingAnjuran'));
    }

    public function mediator()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->active_role !== 'mediator') {
            abort(403, 'Access denied');
        }

        // Data statistik terintegrasi untuk mediator (Perselisihan HI + Pelaporan PHK)
        $totalPengaduan = Pengaduan::count();
        $totalPhk = PelaporanPhk::count();

        $stats = [
            'total_berkas_terpadu' => $totalPengaduan + $totalPhk,
            // Perselisihan Hubungan Industrial
            'total_pengaduan' => $totalPengaduan,
            'pengaduan_pending' => Pengaduan::where('status', 'pending')->count(),
            'pengaduan_proses' => Pengaduan::where('status', 'proses')->count(),
            'pengaduan_selesai' => Pengaduan::where('status', 'selesai')->count(),
            // Pelaporan PHK (PP 35/2021)
            'total_phk' => $totalPhk,
            'phk_menunggu' => PelaporanPhk::where('status', 'menunggu_verifikasi')->count(),
            'phk_terverifikasi' => PelaporanPhk::where('status', 'terverifikasi')->count(),
            'phk_perlu_revisi' => PelaporanPhk::where('status', 'perlu_revisi')->count(),
            'total_pekerja_phk' => PelaporanPhk::sum('total_pekerja'),
            'total_kompensasi_phk' => PelaporanPhk::sum('total_kompensasi'),
            // Jadwal
            'jadwal_hari_ini' => Jadwal::whereDate('tanggal', today())->count(),
            'menunggu_konfirmasi' => Jadwal::menungguKonfirmasi()->count(),
            // Butuh Tindakan Cepat (Pending Pengaduan + Menunggu Verifikasi PHK)
            'total_butuh_tindakan' => Pengaduan::where('status', 'pending')->count() + PelaporanPhk::where('status', 'menunggu_verifikasi')->count(),
        ];

        // Antrean Pelaporan PHK yang butuh verifikasi
        $antreanPhk = PelaporanPhk::with('pekerja')
            ->whereIn('status', ['menunggu_verifikasi', 'perlu_revisi'])
            ->latest()
            ->take(5)
            ->get();

        // Kasus Perselisihan aktif terbaru
        $pengaduanAktif = Pengaduan::with(['pelapor', 'terlapor'])
            ->whereIn('status', ['pending', 'proses'])
            ->latest()
            ->take(5)
            ->get();

        // Jadwal Mediasi terdekat
        $jadwalMendatang = Jadwal::with(['pengaduan.pelapor', 'pengaduan.terlapor'])
            ->where('status_jadwal', 'dijadwalkan')
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        return view('dashboard.mediator', compact('user', 'stats', 'antreanPhk', 'pengaduanAktif', 'jadwalMendatang'));
    }

    public function kepalaDinas()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->active_role !== 'kepala_dinas') {
            abort(403, 'Access denied');
        }

        // Data khusus untuk kepala dinas
        $stats = [
            'total_pengaduan' => Pengaduan::count(),
            'menunggu_approval' => \App\Models\Anjuran::where('status_approval', 'pending_kepala_dinas')->count(),
            'dalam_proses' => Pengaduan::where('status', 'proses')->count(),
            'selesai_bulan_ini' => Pengaduan::where('status', 'selesai')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->count(),
            'mediator_pending' => \App\Models\Mediator::where('status', 'pending')->count(),
        ];

        return view('dashboard.kepala-dinas', compact('user', 'stats'));
    }
}
