<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Mediator</title>
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
                        Dashboard Mediator
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Pusat Kendali Pengaduan Hubungan Industrial dan Pelaporan PHK Kota Padang
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('pelaporan-phk.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                        Verifikasi PHK ({{ $stats['phk_menunggu'] }})
                    </a>
                    <a href="{{ route('pengaduan.kelola') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                        Kelola Kasus
                    </a>
                </div>
            </div>
        </x-slot>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                {{-- Welcome Section --}}
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-8 text-white mb-6">
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ $user->mediator->nama_mediator ?? $user->getName() }}</h3>
                    <p class="text-green-100">Dashboard Mediator - Sistem Informasi Penyelesaian Perselisihan Hubungan Industrial & Pelaporan PHK Kota Padang</p>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="bg-green-400 px-3 py-1 rounded-full text-sm font-medium text-green-900">
                            Role: {{ ucfirst($user->active_role) }}
                        </span>
                        <span class="text-xs text-green-100">NIP: {{ $user->mediator->nip ?? '-' }}</span>
                    </div>
                </div>

                {{-- Statistics Terintegrasi --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Total Seluruh Berkas</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_berkas_terpadu'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $stats['total_pengaduan'] }} Aduan | {{ $stats['total_phk'] }} PHK</p>
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
                                <p class="text-gray-600 text-sm">Perselisihan Aktif</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['pengaduan_proses'] + $stats['pengaduan_pending'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $stats['pengaduan_selesai'] }} Telah Selesai</p>
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
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_phk'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $stats['phk_menunggu'] }} Menunggu | {{ $stats['phk_terverifikasi'] }} Sah</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Perlu Tindakan Segera</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ $stats['total_butuh_tindakan'] }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Verifikasi & Aduan Baru</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h4 class="text-lg font-semibold mb-4 text-gray-900">Aksi Cepat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('pelaporan-phk.index') }}"
                            class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-300 transition-colors">
                            <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Verifikasi PHK</p>
                                <p class="text-xs text-gray-600">{{ $stats['phk_menunggu'] }} Berkas Menunggu</p>
                            </div>
                        </a>

                        <a href="{{ route('pengaduan.kelola') }}"
                            class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-colors">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h2z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Kelola Kasus</p>
                                <p class="text-xs text-gray-600">Pengaduan Hubungan Industrial</p>
                            </div>
                        </a>

                        <a href="{{ route('jadwal.index') }}"
                            class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-colors">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Jadwal</p>
                                <p class="text-xs text-gray-600">Sesi Sidang Klarifikasi & Mediasi</p>
                            </div>
                        </a>

                        <a href="{{ route('laporan.index') }}"
                            class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-colors">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Buku Register & Laporan</p>
                                <p class="text-xs text-gray-600">Hasil Mediasi & Register PHK</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Dua Bagian Antrean Berkas --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Antrean Verifikasi Pelaporan PHK -->
                    <div class="bg-white rounded-lg shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between border-b pb-3 mb-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-base">Antrean Pelaporan PHK (PP 35/2021)</h4>
                                    <p class="text-xs text-gray-500">Berkas masuk memerlukan verifikasi administratif</p>
                                </div>
                                <a href="{{ route('pelaporan-phk.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                                    Semua PHK ({{ $stats['total_phk'] }})
                                </a>
                            </div>

                            <div class="space-y-3">
                                @forelse($antreanPhk as $phk)
                                    <div class="p-3.5 rounded-lg border border-gray-100 hover:bg-gray-50 transition flex items-center justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-mono font-semibold text-blue-600">{{ $phk->nomor_lapor }}</span>
                                                @if($phk->status === 'menunggu_verifikasi')
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-yellow-100 text-yellow-800">
                                                        Menunggu Verifikasi
                                                    </span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-orange-100 text-orange-800">
                                                        Perlu Revisi
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm font-semibold text-gray-900 truncate mt-1">{{ $phk->nama_perusahaan }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $phk->sektor_usaha }} | {{ $phk->total_pekerja }} Pekerja | Rp {{ number_format($phk->total_kompensasi, 0, ',', '.') }}</p>
                                        </div>
                                        <a href="{{ route('pelaporan-phk.show', $phk->pelaporan_phk_id) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs font-semibold transition flex-shrink-0">
                                            Periksa
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-gray-400 text-xs">
                                        Tidak ada berkas pelaporan PHK yang menunggu verifikasi saat ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t text-xs text-gray-500 flex justify-between items-center">
                            <span>Total Tenaga Kerja Ter-PHK Kota Padang:</span>
                            <span class="text-indigo-600 font-semibold">{{ $stats['total_pekerja_phk'] }} Orang</span>
                        </div>
                    </div>

                    <!-- Kasus Perselisihan HI Aktif -->
                    <div class="bg-white rounded-lg shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between border-b pb-3 mb-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-base">Kasus Perselisihan HI Aktif</h4>
                                    <p class="text-xs text-gray-500">Pengaduan dalam proses klarifikasi & mediasi</p>
                                </div>
                                <a href="{{ route('pengaduan.kelola') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                                    Semua Kasus ({{ $stats['total_pengaduan'] }})
                                </a>
                            </div>

                            <div class="space-y-3">
                                @forelse($pengaduanAktif as $aduan)
                                    <div class="p-3.5 rounded-lg border border-gray-100 hover:bg-gray-50 transition flex items-center justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-mono font-semibold text-gray-600">{{ $aduan->nomor_pengaduan ?? 'PGD-' . $aduan->pengaduan_id }}</span>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $aduan->status === 'proses' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($aduan->status) }}
                                                </span>
                                                <span class="text-[10px] text-gray-500">
                                                    {{ $aduan->perihal }}
                                                </span>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-900 truncate mt-1">
                                                {{ $aduan->pelapor->nama_pelapor ?? '-' }} <span class="text-gray-400 font-normal">vs</span> {{ $aduan->terlapor->nama_terlapor ?? $aduan->nama_terlapor }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">Tgl Lapor: {{ \Carbon\Carbon::parse($aduan->tanggal_laporan)->format('d M Y') }}</p>
                                        </div>
                                        <a href="{{ route('pengaduan.kelola.show', $aduan->pengaduan_id) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold transition flex-shrink-0">
                                            Detail
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-gray-400 text-xs">
                                        Tidak ada kasus perselisihan aktif saat ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t text-xs text-gray-500 flex justify-between items-center">
                            <span>Total Kasus Berhasil Selesai:</span>
                            <span class="text-green-600 font-semibold">{{ $stats['pengaduan_selesai'] }} Kasus</span>
                        </div>
                    </div>

                </div>

                {{-- Jadwal Mediasi Mendatang --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between border-b pb-3 mb-4">
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Jadwal Sidang Mediasi Mendatang</h4>
                            <p class="text-xs text-gray-500">Agenda pemanggilan sidang klarifikasi dan mediasi para pihak</p>
                        </div>
                        <a href="{{ route('jadwal.index') }}" class="text-xs text-blue-600 font-semibold hover:underline">
                            Kelola Jadwal
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-xs">
                            <thead class="bg-gray-50 font-medium text-gray-500 uppercase">
                                <tr>
                                    <th class="px-4 py-3 text-left">No. Jadwal & Sidang</th>
                                    <th class="px-4 py-3 text-left">Waktu & Tempat</th>
                                    <th class="px-4 py-3 text-left">Para Pihak</th>
                                    <th class="px-4 py-3 text-center">Konfirmasi Kehadiran</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($jadwalMendatang as $j)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="font-mono text-blue-600 font-semibold">{{ $j->nomor_jadwal ?? 'JAD-' . substr($j->jadwal_id, 0, 8) }}</div>
                                            <div class="text-[10px] text-gray-500">{{ $j->sidang_ke ?? 'Sidang Mediasi' }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">
                                            <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l, d F Y') }}</div>
                                            <div class="text-gray-500">Pukul: {{ $j->waktu }} WIB | Ruang: {{ $j->tempat ?? 'Ruang Mediasi' }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900">
                                            <div class="font-semibold">{{ $j->pengaduan->pelapor->nama_pelapor ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">vs {{ $j->pengaduan->terlapor->nama_terlapor ?? $j->pengaduan->nama_terlapor }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $j->konfirmasi_pelapor === 'hadir' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                    Pelapor: {{ ucfirst($j->konfirmasi_pelapor ?? 'Pending') }}
                                                </span>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $j->konfirmasi_terlapor === 'hadir' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                    Terlapor: {{ ucfirst($j->konfirmasi_terlapor ?? 'Pending') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('jadwal.show', $j->jadwal_id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                            Belum ada jadwal mediasi mendatang.
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
</body>

</html>
