<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Pusat Laporan & Buku Register Hubungan Industrial
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    Rekapitulasi Terpadu Hasil Mediasi & Pencatatan Pelaporan PHK (PP 35/2021) — Disnakerin Kota Padang
                </p>
            </div>
            @if(in_array($user->active_role, ['mediator', 'kepala_dinas']))
                <a href="{{ route('pelaporan-phk.statistik') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold shadow-sm transition">
                    📊 Statistik Lengkap PHK
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Top Aggregate Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perselisihan Selesai</p>
                        <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ $stats['total_selesai'] ?? 0 }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Sepakat PB: <strong class="text-green-600">{{ $stats['sepakat'] ?? 0 }}</strong> | Anjuran: <strong class="text-orange-600">{{ $stats['tidak_sepakat'] ?? 0 }}</strong>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        ⚖️
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pelaporan PHK Sah</p>
                        <p class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $stats['phk_terverifikasi'] ?? 0 }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Total Laporan: <strong class="text-gray-800">{{ $stats['total_phk'] ?? 0 }} Perusahaan</strong>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        📄
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tenaga Kerja Ter-PHK</p>
                        <p class="text-3xl font-extrabold text-purple-600 mt-1">{{ $stats['total_pekerja_phk'] ?? 0 }} <span class="text-sm font-semibold text-gray-500">Orang</span></p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Penerima Hak Kompensasi
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        👥
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Nilai Hak PHK</p>
                        <p class="text-xl font-extrabold text-green-600 mt-1 truncate max-w-[180px]" title="Rp {{ number_format($stats['total_kompensasi_phk'] ?? 0, 0, ',', '.') }}">
                            Rp {{ number_format($stats['total_kompensasi_phk'] ?? 0, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Pesangon, UPMK & UPH
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        💰
                    </div>
                </div>
            </div>

            <!-- Report Navigation Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 1. Laporan Hasil Mediasi -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-blue-100 rounded-xl text-blue-600 flex-shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Perselisihan HI</span>
                                <h3 class="text-lg font-bold text-gray-900 mt-1">Laporan Hasil Mediasi</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    Daftar rekapitulasi penanganan kasus perselisihan yang telah selesai mediasi, memuat ringkasan posisi hukum dan kesepakatan akhir.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ $stats['total_selesai'] ?? 0 }} Berkas Selesai</span>
                        <a href="{{ route('laporan.hasil-mediasi') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition">
                            Buka Laporan Mediasi →
                        </a>
                    </div>
                </div>

                <!-- 2. Buku Register Perselisihan HI -->
                @if (in_array($user->active_role, ['mediator', 'kepala_dinas']))
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-green-100 rounded-xl text-green-600 flex-shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 5.477 18.246 5 16.5 5c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="bg-green-50 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Buku Register</span>
                                    <h3 class="text-lg font-bold text-gray-900 mt-1">Buku Register Perselisihan HI</h3>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                        Pencatatan resmi internal buku register perselisihan ketenagakerjaan Disnakerin Kota Padang (Klasifikasi Hak, Kepentingan, PHK Sengketa, SP/SB).
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Internal Disnakerin Padang</span>
                            <a href="{{ route('laporan.buku-register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition">
                                Buka Buku Register →
                            </a>
                        </div>
                    </div>
                @endif

                <!-- 3. Buku Register & Pelaporan PHK (PP 35/2021) -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-indigo-100 rounded-xl text-indigo-600 flex-shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="bg-indigo-50 text-indigo-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Buku Register PHK</span>
                                <h3 class="text-lg font-bold text-gray-900 mt-1">Buku Register Pelaporan PHK (PP 35/2021)</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    Pencatatan pelaporan PHK yang telah disepakati oleh pekerja, verifikasi berkas bukti pesangon, dan arsip Surat Tanda Bukti Lapor resmi dinas.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ $stats['phk_terverifikasi'] ?? 0 }} Terverifikasi Resmi</span>
                        <a href="{{ route('pelaporan-phk.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition">
                            Buka Register PHK →
                        </a>
                    </div>
                </div>

                <!-- 4. Statistik & Rekapitulasi Kasus PHK Kota Padang -->
                @if (in_array($user->active_role, ['mediator', 'kepala_dinas']))
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-purple-100 rounded-xl text-purple-600 flex-shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="bg-purple-50 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Analisis & Tren</span>
                                    <h3 class="text-lg font-bold text-gray-900 mt-1">Statistik & Rekapitulasi PHK Padang</h3>
                                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                        Dashboard monitoring agregat tingkat PHK Kota Padang per bulan, distribusi sektor industri manufaktur/perdagangan, serta alasan PHK PP 35/2021.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Laporan Eksekutif Kadis & Mediator</span>
                            <a href="{{ route('pelaporan-phk.statistik') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition">
                                Buka Statistik PHK →
                            </a>
                        </div>
                    </div>
                @endif

                <!-- 5. Laporan Pengadilan Hubungan Industrial (PHI) -->
                @if (in_array($user->active_role, ['mediator', 'kepala_dinas']))
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col justify-between hover:shadow-md transition md:col-span-2">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-amber-100 rounded-xl text-amber-600 flex-shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="bg-amber-50 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Eskalasi Pengadilan</span>
                                <h3 class="text-lg font-bold text-gray-900 mt-1">Laporan ke Pengadilan Hubungan Industrial (PHI)</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    Arsip perkara mediasi yang tidak mencapai mufakat (anjuran ditolak salah satu pihak) dan dilanjutkan gugatannya ke Pengadilan Hubungan Industrial pada Pengadilan Negeri Padang.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Pasal 14 & 15 UU No. 2 Tahun 2004</span>
                            <a href="{{ route('laporan.pengadilan-hi') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition">
                                Buka Laporan PHI →
                            </a>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
