<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan & Buku Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#0000AB',
                        'primary-light': '#3333CC',
                        'primary-lighter': '#6666DD',
                        'primary-dark': '#000088'
                    }
                }
            }
        }
    </script>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Laporan dan Buku Register
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Rekapitulasi Penanganan Hubungan Industrial dan Pelaporan PHK
                    </p>
                </div>
                @if(in_array($user->active_role, ['mediator', 'kepala_dinas']))
                    <a href="{{ route('pelaporan-phk.statistik') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                        Statistik PHK
                    </a>
                @endif
            </div>
        </x-slot>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Statistics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Perselisihan Selesai</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_selesai'] ?? 0 }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Sepakat PB: {{ $stats['sepakat'] ?? 0 }} | Anjuran: {{ $stats['tidak_sepakat'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-indigo-100 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Pelaporan PHK Sah</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['phk_terverifikasi'] ?? 0 }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Total: {{ $stats['total_phk'] ?? 0 }} Perusahaan</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Tenaga Kerja Ter-PHK</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pekerja_phk'] ?? 0 }} Orang</p>
                                <p class="text-xs text-gray-500 mt-0.5">Penerima Kompensasi</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Total Nilai Hak PHK</p>
                                <p class="text-lg font-bold text-gray-900 truncate max-w-[180px]" title="Rp {{ number_format($stats['total_kompensasi_phk'] ?? 0, 0, ',', '.') }}">
                                    Rp {{ number_format($stats['total_kompensasi_phk'] ?? 0, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">Pesangon & Penghargaan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Navigation Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Laporan Hasil Mediasi -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Laporan Hasil Mediasi</h3>
                                    <p class="text-sm text-gray-600">Lihat laporan hasil mediasi kasus yang telah selesai</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500">{{ $stats['total_selesai'] ?? 0 }} Berkas Selesai</span>
                            <a href="{{ route('laporan.hasil-mediasi') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Lihat Laporan
                            </a>
                        </div>
                    </div>

                    <!-- Buku Register Perselisihan -->
                    @if (in_array($user->active_role, ['mediator', 'kepala_dinas']))
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="p-3 bg-green-100 rounded-lg mr-4">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 5.477 5.754 5 7.5 5s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 5.477 18.246 5 16.5 5c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Buku Register Perselisihan</h3>
                                        <p class="text-sm text-gray-600">Lihat buku register perselisihan internal dinas</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500">Internal Disnakerin Kota Padang</span>
                                <a href="{{ route('laporan.buku-register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Lihat Register
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Buku Register Pelaporan PHK -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-3 bg-indigo-100 rounded-lg mr-4">
                                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Buku Register Pelaporan PHK</h3>
                                    <p class="text-sm text-gray-600">Pencatatan resmi pelaporan PHK PP 35/2021 dan penerbitan bukti lapor</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500">{{ $stats['phk_terverifikasi'] ?? 0 }} Terverifikasi Sah</span>
                            <a href="{{ route('pelaporan-phk.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Lihat Register PHK
                            </a>
                        </div>
                    </div>

                    <!-- Statistik PHK -->
                    @if (in_array($user->active_role, ['mediator', 'kepala_dinas']))
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="p-3 bg-purple-100 rounded-lg mr-4">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Statistik Kasus PHK Kota Padang</h3>
                                        <p class="text-sm text-gray-600">Rekapitulasi tren bulanan, sektor usaha, dan klasifikasi alasan PHK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500">Monitoring & Analisis</span>
                                <a href="{{ route('pelaporan-phk.statistik') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Buka Statistik
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Laporan Pengadilan Hubungan Industrial -->
                    @if (in_array($user->active_role, ['mediator', 'kepala_dinas']))
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 flex flex-col justify-between md:col-span-2">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Laporan ke Pengadilan Hubungan Industrial (PHI)</h3>
                                        <p class="text-sm text-gray-600">Arsip perkara anjuran yang tidak dicapai mufakat dan dilanjutkan ke PHI</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500">Pasal 14 & 15 UU No. 2 Tahun 2004</span>
                                <a href="{{ route('laporan.pengadilan-hi') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Lihat Laporan PHI
                                </a>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </x-app-layout>
</body>

</html>
