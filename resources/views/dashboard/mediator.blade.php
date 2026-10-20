<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Pusat Kendali Mediator Hubungan Industrial
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    Integrasi Pengaduan Perselisihan & Pelaporan PHK (PP No. 35 Tahun 2021) — Disnakerin Kota Padang
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('pelaporan-phk.index') }}" class="inline-flex items-center px-3.5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs font-bold shadow-sm transition">
                    ⚠️ Verifikasi PHK ({{ $stats['phk_menunggu'] }})
                </a>
                <a href="{{ route('pengaduan.kelola') }}" class="inline-flex items-center px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold shadow-sm transition">
                    📋 Kelola Kasus Perselisihan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Hero -->
            <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-blue-800 rounded-2xl p-6 sm:p-8 text-white shadow-md relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-white/20 backdrop-blur-sm text-xs font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider">
                            Jabatan Fungsional Mediator HI
                        </span>
                        <span class="bg-emerald-500/80 text-xs font-semibold px-2.5 py-1 rounded-full">
                            Aktif
                        </span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Selamat Datang, {{ $user->mediator->nama_mediator ?? $user->getName() }}
                    </h3>
                    <p class="text-emerald-100 text-sm mt-1 max-w-2xl leading-relaxed">
                        NIP: {{ $user->mediator->nip ?? '-' }} | Dinas Tenaga Kerja dan Perindustrian Kota Padang. Seluruh data penanganan perselisihan bipartit/mediasi dan pencatatan administratif pelaporan PHK terintegrasi di portal ini.
                    </p>
                </div>
            </div>

            <!-- Unified 4 KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Berkas Terpadu -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Seluruh Berkas</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['total_berkas_terpadu'] }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            <span class="text-blue-600 font-semibold">{{ $stats['total_pengaduan'] }} Perselisihan</span> + <span class="text-indigo-600 font-semibold">{{ $stats['total_phk'] }} PHK</span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        📁
                    </div>
                </div>

                <!-- Perselisihan Hubungan Industrial -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Perselisihan HI</p>
                        <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ $stats['total_pengaduan'] }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Aktif: <strong class="text-yellow-600">{{ $stats['pengaduan_proses'] + $stats['pengaduan_pending'] }}</strong> | Selesai: <strong class="text-green-600">{{ $stats['pengaduan_selesai'] }}</strong>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        ⚖️
                    </div>
                </div>

                <!-- Pelaporan PHK (PP 35/2021) -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Pelaporan PHK</p>
                        <p class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $stats['total_phk'] }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Menunggu: <strong class="text-yellow-600">{{ $stats['phk_menunggu'] }}</strong> | Sah: <strong class="text-green-600">{{ $stats['phk_terverifikasi'] }}</strong>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        📄
                    </div>
                </div>

                <!-- Butuh Tindakan Mediator -->
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider">Tindakan Diperlukan</p>
                        <p class="text-3xl font-extrabold text-yellow-600 mt-1">{{ $stats['total_butuh_tindakan'] }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Verifikasi PHK & Aduan Baru
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        ⚡
                    </div>
                </div>
            </div>

            <!-- Quick Action Links -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Menu Aksi Terpadu</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="{{ route('pelaporan-phk.index') }}" class="p-3.5 rounded-xl border border-gray-100 hover:border-yellow-300 hover:bg-yellow-50/50 transition flex flex-col items-center text-center group">
                        <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">📝</span>
                        <span class="text-xs font-bold text-gray-800">Verifikasi PHK</span>
                        <span class="text-[10px] text-gray-500 mt-0.5">{{ $stats['phk_menunggu'] }} Menunggu</span>
                    </a>
                    <a href="{{ route('pengaduan.kelola') }}" class="p-3.5 rounded-xl border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 transition flex flex-col items-center text-center group">
                        <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">⚖️</span>
                        <span class="text-xs font-bold text-gray-800">Kelola Kasus HI</span>
                        <span class="text-[10px] text-gray-500 mt-0.5">{{ $stats['total_pengaduan'] }} Terdaftar</span>
                    </a>
                    <a href="{{ route('jadwal.index') }}" class="p-3.5 rounded-xl border border-gray-100 hover:border-purple-300 hover:bg-purple-50/50 transition flex flex-col items-center text-center group">
                        <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">📅</span>
                        <span class="text-xs font-bold text-gray-800">Jadwal Mediasi</span>
                        <span class="text-[10px] text-gray-500 mt-0.5">{{ $stats['jadwal_hari_ini'] }} Hari Ini</span>
                    </a>
                    <a href="{{ route('dokumen.index') }}" class="p-3.5 rounded-xl border border-gray-100 hover:border-teal-300 hover:bg-teal-50/50 transition flex flex-col items-center text-center group">
                        <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">📑</span>
                        <span class="text-xs font-bold text-gray-800">Dokumen HI</span>
                        <span class="text-[10px] text-gray-500 mt-0.5">Anjuran & PB</span>
                    </a>
                    <a href="{{ route('laporan.index') }}" class="p-3.5 rounded-xl border border-gray-100 hover:border-emerald-300 hover:bg-emerald-50/50 transition flex flex-col items-center text-center group">
                        <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">📖</span>
                        <span class="text-xs font-bold text-gray-800">Buku Register</span>
                        <span class="text-[10px] text-gray-500 mt-0.5">Rekap Kasus</span>
                    </a>
                    <a href="{{ route('pelaporan-phk.statistik') }}" class="p-3.5 rounded-xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/50 transition flex flex-col items-center text-center group">
                        <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">📊</span>
                        <span class="text-xs font-bold text-gray-800">Statistik PHK</span>
                        <span class="text-[10px] text-gray-500 mt-0.5">{{ $stats['total_pekerja_phk'] }} Pekerja</span>
                    </a>
                </div>
            </div>

            <!-- Two Main Data Sections Side by Side -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Section 1: Antrean Pelaporan PHK (PP 35/2021) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b pb-3 mb-4">
                            <div>
                                <h3 class="font-bold text-base text-gray-900 flex items-center gap-2">
                                    <span class="w-3 h-3 bg-yellow-500 rounded-full animate-ping"></span>
                                    Antrean Pelaporan PHK (PP 35/2021)
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">Memerlukan verifikasi berkas kesepakatan bipartit & hak pesangon</p>
                            </div>
                            <a href="{{ route('pelaporan-phk.index') }}" class="text-xs text-blue-600 font-bold hover:underline">
                                Semua PHK ({{ $stats['total_phk'] }}) →
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($antreanPhk as $phk)
                                <div class="p-3.5 rounded-xl border border-gray-100 hover:bg-gray-50 transition flex items-center justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-xs font-mono font-bold text-blue-600">{{ $phk->nomor_lapor }}</p>
                                            @if($phk->status === 'menunggu_verifikasi')
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800">
                                                    Menunggu Verifikasi
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-800">
                                                    Perlu Revisi
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm font-bold text-gray-900 truncate mt-1">{{ $phk->nama_perusahaan }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $phk->sektor_usaha }} | {{ $phk->total_pekerja }} Pekerja | Rp {{ number_format($phk->total_kompensasi, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('pelaporan-phk.show', $phk->pelaporan_phk_id) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs font-bold transition flex-shrink-0">
                                        Periksa
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400 text-xs">
                                    ✓ Tidak ada berkas pelaporan PHK yang menunggu verifikasi saat ini.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t text-xs text-gray-500 flex justify-between items-center">
                        <span>Total Tenaga Kerja Ter-PHK Kota Padang:</span>
                        <strong class="text-indigo-600 text-sm font-bold">{{ $stats['total_pekerja_phk'] }} Orang</strong>
                    </div>
                </div>

                <!-- Section 2: Kasus Perselisihan HI Aktif -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between border-b pb-3 mb-4">
                            <div>
                                <h3 class="font-bold text-base text-gray-900 flex items-center gap-2">
                                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                    Kasus Perselisihan HI Aktif
                                </h3>
                                <p class="text-xs text-gray-500 mt-0.5">Pengaduan dalam tahap klarifikasi dan sidang mediasi</p>
                            </div>
                            <a href="{{ route('pengaduan.kelola') }}" class="text-xs text-blue-600 font-bold hover:underline">
                                Semua Kasus ({{ $stats['total_pengaduan'] }}) →
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($pengaduanAktif as $aduan)
                                <div class="p-3.5 rounded-xl border border-gray-100 hover:bg-gray-50 transition flex items-center justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="text-xs font-mono font-bold text-gray-600">{{ $aduan->nomor_pengaduan ?? 'PGD-' . $aduan->pengaduan_id }}</p>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $aduan->status === 'proses' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($aduan->status) }}
                                            </span>
                                            <span class="text-[10px] font-semibold text-gray-500">
                                                {{ $aduan->perihal }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900 truncate mt-1">
                                            {{ $aduan->pelapor->nama_pelapor ?? '-' }} <span class="text-gray-400 font-normal">vs</span> {{ $aduan->terlapor->nama_terlapor ?? $aduan->nama_terlapor }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">Tgl Lapor: {{ \Carbon\Carbon::parse($aduan->tanggal_laporan)->format('d M Y') }}</p>
                                    </div>
                                    <a href="{{ route('pengaduan.kelola.show', $aduan->pengaduan_id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition flex-shrink-0">
                                        Detail
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400 text-xs">
                                    Tidak ada kasus perselisihan aktif yang ditangani saat ini.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t text-xs text-gray-500 flex justify-between items-center">
                        <span>Total Kasus Berhasil Selesai:</span>
                        <strong class="text-green-600 text-sm font-bold">{{ $stats['pengaduan_selesai'] }} Kasus</strong>
                    </div>
                </div>

            </div>

            <!-- Section 3: Jadwal Sidang Mediasi Mendatang -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between border-b pb-3 mb-4">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 flex items-center gap-2">
                            <span>📅 Agenda & Jadwal Sidang Mediasi Mendatang</span>
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">Daftar pemanggilan sidang klarifikasi dan mediasi para pihak di Disnakerin Padang</p>
                    </div>
                    <a href="{{ route('jadwal.index') }}" class="text-xs text-blue-600 font-bold hover:underline">
                        Kelola Seluruh Jadwal →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50 font-semibold text-gray-600 uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">No. Jadwal & Sidang</th>
                                <th class="px-4 py-3 text-left">Waktu & Tempat</th>
                                <th class="px-4 py-3 text-left">Para Pihak (Pelapor vs Terlapor)</th>
                                <th class="px-4 py-3 text-center">Konfirmasi Kehadiran</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($jadwalMendatang as $j)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        <div class="font-mono text-blue-600">{{ $j->nomor_jadwal ?? 'JAD-' . substr($j->jadwal_id, 0, 8) }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase">{{ $j->sidang_ke ?? 'Sidang Mediasi' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        <div class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l, d F Y') }}</div>
                                        <div class="text-gray-500">Pukul: {{ $j->waktu }} WIB | Ruang: {{ $j->tempat ?? 'Ruang Mediasi Disnakerin' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900">
                                        <div class="font-semibold">{{ $j->pengaduan->pelapor->nama_pelapor ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">vs {{ $j->pengaduan->terlapor->nama_terlapor ?? $j->pengaduan->nama_terlapor }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $j->konfirmasi_pelapor === 'hadir' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                P: {{ ucfirst($j->konfirmasi_pelapor ?? 'Pending') }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $j->konfirmasi_terlapor === 'hadir' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                T: {{ ucfirst($j->konfirmasi_terlapor ?? 'Pending') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('jadwal.show', $j->jadwal_id) }}" class="text-blue-600 hover:text-blue-900 font-bold">
                                            Lihat Sesi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                        Belum ada jadwal mediasi mendatang yang ditetapkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
