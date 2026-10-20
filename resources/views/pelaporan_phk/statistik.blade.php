<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik & Rekapitulasi Kasus PHK Kota Padang
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    Monitoring Tingkat Pemutusan Hubungan Kerja — Dinas Tenaga Kerja dan Perindustrian Kota Padang
                </p>
            </div>
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('pelaporan-phk.statistik') }}" class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-gray-600">Tahun:</label>
                    <select name="tahun" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-300 font-bold focus:ring-blue-500 focus:border-blue-500">
                        @for($y = (int)date('Y'); $y >= (int)date('Y') - 4; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
                <a href="{{ route('pelaporan-phk.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
                    ← Daftar Laporan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 4 KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Laporan PHK</p>
                    <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $totalLaporan }}</p>
                    <p class="text-xs text-gray-500 mt-1">Perusahaan melapor tahun {{ $tahun }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tenaga Kerja Ter-PHK</p>
                    <p class="text-3xl font-extrabold text-purple-600 mt-2">{{ $totalPekerja }} <span class="text-sm font-semibold text-gray-500">Orang</span></p>
                    <p class="text-xs text-gray-500 mt-1">Telah menerima kesepakatan</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Hak Disalurkan</p>
                    <p class="text-2xl font-extrabold text-green-600 mt-2">Rp {{ number_format($totalKompensasi, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Pesangon, UPMK & UPH</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanda Bukti Diterbitkan</p>
                    <p class="text-3xl font-extrabold text-teal-600 mt-2">{{ $totalTerverifikasi }}</p>
                    <p class="text-xs text-gray-500 mt-1">Terverifikasi Disnakerin</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Rekap per Sektor Usaha -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-base text-gray-900 border-b pb-3 mb-4 flex items-center justify-between">
                        <span>Distribusi PHK Berdasarkan Sektor Usaha</span>
                        <span class="text-xs font-normal text-gray-500">Tahun {{ $tahun }}</span>
                    </h3>

                    <div class="space-y-4">
                        @forelse($rekapSektor as $item)
                            <div>
                                <div class="flex justify-between text-xs font-semibold text-gray-700 mb-1">
                                    <span>{{ $item->sektor_usaha }}</span>
                                    <span>{{ $item->pekerja }} Orang ({{ $item->count }} Laporan)</span>
                                </div>
                                @php
                                    $percent = $totalPekerja > 0 ? ($item->pekerja / $totalPekerja) * 100 : 0;
                                @endphp
                                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-6">Tidak ada data untuk tahun {{ $tahun }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Rekap per Alasan PHK PP 35/2021 -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-base text-gray-900 border-b pb-3 mb-4 flex items-center justify-between">
                        <span>Klasifikasi Alasan PHK (PP 35/2021)</span>
                        <span class="text-xs font-normal text-gray-500">Tahun {{ $tahun }}</span>
                    </h3>

                    <div class="space-y-4">
                        @forelse($rekapAlasan as $item)
                            <div>
                                <div class="flex justify-between text-xs font-semibold text-gray-700 mb-1">
                                    <span class="truncate max-w-xs" title="{{ $item->alasan_phk }}">{{ $item->alasan_phk }}</span>
                                    <span>{{ $item->pekerja }} Orang</span>
                                </div>
                                @php
                                    $percent = $totalPekerja > 0 ? ($item->pekerja / $totalPekerja) * 100 : 0;
                                @endphp
                                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-6">Tidak ada data untuk tahun {{ $tahun }}</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Tren Bulanan -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-base text-gray-900 border-b pb-3 mb-4 flex items-center justify-between">
                    <span>Tren Bulanan Kasus & Tenaga Kerja Ter-PHK di Kota Padang</span>
                    <span class="text-xs font-semibold text-gray-500">Januari - Desember {{ $tahun }}</span>
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50 font-bold text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-left">Bulan</th>
                                <th class="px-4 py-3 text-center">Jumlah Perusahaan Melapor</th>
                                <th class="px-4 py-3 text-center">Jumlah Tenaga Kerja</th>
                                <th class="px-4 py-3 text-left">Status Tren</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($daftarBulan as $num => $namaBulan)
                                @php
                                    $bulanData = $trenBulanan->get($num);
                                    $jmlLaporan = $bulanData->total_laporan ?? 0;
                                    $jmlPekerja = $bulanData->total_pekerja ?? 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2.5 font-bold text-gray-800">{{ $namaBulan }}</td>
                                    <td class="px-4 py-2.5 text-center font-semibold text-blue-600">{{ $jmlLaporan }}</td>
                                    <td class="px-4 py-2.5 text-center font-bold text-purple-700">{{ $jmlPekerja }} Orang</td>
                                    <td class="px-4 py-2.5">
                                        @if($jmlPekerja > 0)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                                Tercatat
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-[10px]">Nihil</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
