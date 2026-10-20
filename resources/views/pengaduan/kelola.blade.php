<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kelola Berkas Kasus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        Kelola Berkas Hubungan Industrial & PHK
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Integrasi Pengaduan Perselisihan dan Pelaporan PHK (PP No. 35 Tahun 2021)
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('pelaporan-phk.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                        Verifikasi PHK ({{ $stats['phk_menunggu'] ?? 0 }})
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- 4 Top KPI Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Total Seluruh Berkas</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_semua_berkas'] ?? 0 }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $stats['total_semua_pengaduan'] ?? 0 }} Aduan | {{ $stats['total_phk'] ?? 0 }} PHK</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Perselisihan HI</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_semua_pengaduan'] ?? 0 }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Aktif: {{ $stats['kasus_aktif'] ?? 0 }} | Selesai: {{ $stats['kasus_selesai'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Pelaporan PHK</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_phk'] ?? 0 }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Menunggu: {{ $stats['phk_menunggu'] ?? 0 }} | Sah: {{ $stats['phk_terverifikasi'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Tenaga Kerja Ter-PHK</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['phk_total_pekerja'] ?? 0 }} Orang</p>
                                <p class="text-xs text-gray-500 mt-0.5">Penerima Kompensasi Sah</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Switcher & Search Bar -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-gray-200 pb-4 mb-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('pengaduan.kelola', ['tab' => 'perselisihan']) }}"
                                class="px-4 py-2 rounded-md font-medium text-sm flex items-center gap-2 transition {{ ($activeTab ?? 'perselisihan') === 'perselisihan' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                <span>Perselisihan Hubungan Industrial</span>
                                <span class="px-2 py-0.5 text-xs rounded-full {{ ($activeTab ?? 'perselisihan') === 'perselisihan' ? 'bg-blue-800 text-white' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $stats['total_semua_pengaduan'] ?? 0 }}
                                </span>
                            </a>

                            <a href="{{ route('pengaduan.kelola', ['tab' => 'phk']) }}"
                                class="px-4 py-2 rounded-md font-medium text-sm flex items-center gap-2 transition {{ ($activeTab ?? 'perselisihan') === 'phk' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                <span>Pelaporan PHK (PP No. 35/2021)</span>
                                <span class="px-2 py-0.5 text-xs rounded-full {{ ($stats['phk_menunggu'] ?? 0) > 0 ? 'bg-yellow-400 text-gray-900 font-semibold' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $stats['total_phk'] ?? 0 }} ({{ $stats['phk_menunggu'] ?? 0 }} Menunggu)
                                </span>
                            </a>
                        </div>

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('pengaduan.kelola') }}" class="flex items-center gap-2 w-full sm:w-auto">
                            <input type="hidden" name="tab" value="{{ $activeTab ?? 'perselisihan' }}">
                            <input type="text" name="q" value="{{ request('q') }}"
                                placeholder="{{ ($activeTab ?? 'perselisihan') === 'phk' ? 'Cari nama perusahaan / no. lapor...' : 'Cari nomor pengaduan / nama pihak...' }}"
                                class="text-sm rounded-md border-gray-300 w-full sm:w-64 focus:ring-blue-500 focus:border-blue-500" />
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium py-2 px-4 rounded-md transition">
                                Cari
                            </button>
                            @if (request('q'))
                                <a href="{{ route('pengaduan.kelola', ['tab' => $activeTab ?? 'perselisihan']) }}"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-3 rounded-md transition">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- TAB 1: KONTEN PERSELISIHAN HI -->
                    @if (($activeTab ?? 'perselisihan') === 'perselisihan')
                        @if (isset($pengaduans) && $pengaduans->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Pengaduan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pihak Terlapor</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mediator</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Laporan</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                        @foreach ($pengaduans as $index => $pengaduan)
                                            @php
                                                $currentUser = auth()->user();
                                                $currentMediator = $currentUser->active_role === 'mediator' ? $currentUser->mediator : null;
                                                $isAssignedToCurrentUser = $currentMediator && $pengaduan->mediator_id === $currentMediator->mediator_id;
                                                $isUnassigned = !$pengaduan->mediator_id;
                                                $canTakeAction = $isAssignedToCurrentUser || $currentUser->active_role === 'kepala_dinas';
                                            @endphp
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                                    {{ ($pengaduans->currentPage() - 1) * $pengaduans->perPage() + $index + 1 }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="font-mono text-blue-600 font-semibold">{{ $pengaduan->nomor_pengaduan ?? 'PGD-' . $pengaduan->pengaduan_id }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                                    {{ $pengaduan->pelapor->nama_pelapor ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $pengaduan->perihal }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                                    {{ $pengaduan->terlapor->nama_terlapor ?? $pengaduan->nama_terlapor }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                                    @if ($pengaduan->mediator)
                                                        <span class="font-medium text-gray-900">{{ $pengaduan->mediator->nama_mediator }}</span>
                                                    @else
                                                        <span class="text-orange-600 italic">Belum Ditugaskan</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    @if($pengaduan->status === 'selesai')
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                                    @elseif($pengaduan->status === 'proses')
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Proses</span>
                                                    @else
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                                    {{ \Carbon\Carbon::parse($pengaduan->tanggal_laporan)->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                                    <a href="{{ route('pengaduan.kelola.show', $pengaduan->pengaduan_id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                                        Detail
                                                    </a>
                                                    @if ($isUnassigned && $currentUser->active_role === 'mediator')
                                                        <form method="POST" action="{{ route('pengaduan.assign', $pengaduan->pengaduan_id) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900 font-medium" onclick="return confirm('Ambil pengaduan ini untuk Anda tangani?')">
                                                                Ambil Kasus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if (method_exists($pengaduans, 'links'))
                                <div class="px-6 py-4 border-t border-gray-200">
                                    {{ $pengaduans->links() }}
                                </div>
                            @endif
                        @else
                            <div class="p-12 text-center text-gray-500">
                                <h3 class="text-base font-medium text-gray-900">Belum ada pengaduan perselisihan</h3>
                                <p class="text-sm text-gray-500 mt-1">Pengaduan perselisihan hubungan industrial baru akan muncul di sini.</p>
                            </div>
                        @endif

                    <!-- TAB 2: KONTEN PELAPORAN PHK -->
                    @else
                        @if (isset($pelaporanPhkList) && $pelaporanPhkList->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Lapor & Tanggal</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan & Sektor</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan PHK (PP 35/2021)</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerja</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Kompensasi</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Disnakerin</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                        @foreach ($pelaporanPhkList as $phk)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="font-mono text-blue-600 font-semibold">{{ $phk->nomor_lapor }}</div>
                                                    <div class="text-xs text-gray-500">{{ $phk->created_at->format('d M Y') }}</div>
                                                    @if($phk->nomor_bukti_lapor_dinas)
                                                        <div class="text-xs font-mono text-green-700 font-medium mt-0.5">
                                                            {{ $phk->nomor_bukti_lapor_dinas }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="font-semibold text-gray-900">{{ $phk->nama_perusahaan }}</div>
                                                    <div class="text-xs text-gray-500">{{ $phk->sektor_usaha }}</div>
                                                </td>
                                                <td class="px-6 py-4 max-w-xs">
                                                    <div class="text-xs text-gray-800">{{ $phk->alasan_phk }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">Efektif: {{ $phk->tanggal_efektif_phk->format('d M Y') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        {{ $phk->total_pekerja }} Orang
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right font-medium text-gray-900">
                                                    Rp {{ number_format($phk->total_kompensasi, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    @if($phk->status === 'terverifikasi')
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Terverifikasi
                                                        </span>
                                                    @elseif($phk->status === 'menunggu_verifikasi')
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Menunggu Verifikasi
                                                        </span>
                                                    @elseif($phk->status === 'perlu_revisi')
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                            Perlu Revisi
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Ditolak
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                                    <a href="{{ route('pelaporan-phk.show', $phk->pelaporan_phk_id) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">
                                                        Verifikasi
                                                    </a>
                                                    @if($phk->status === 'terverifikasi')
                                                        <a href="{{ route('pelaporan-phk.cetak', $phk->pelaporan_phk_id) }}" target="_blank" class="text-green-600 hover:text-green-800 font-medium">
                                                            Bukti Lapor
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if (method_exists($pelaporanPhkList, 'links'))
                                <div class="px-6 py-4 border-t border-gray-200">
                                    {{ $pelaporanPhkList->links() }}
                                </div>
                            @endif
                        @else
                            <div class="p-12 text-center text-gray-500">
                                <h3 class="text-base font-medium text-gray-900">Belum ada pelaporan PHK</h3>
                                <p class="text-sm text-gray-500 mt-1">Berkas pelaporan PHK yang didaftarkan perusahaan akan muncul di sini.</p>
                            </div>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    </x-app-layout>
</body>

</html>
