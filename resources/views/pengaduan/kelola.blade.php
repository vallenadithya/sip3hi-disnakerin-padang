<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Pusat Kelola Berkas Hubungan Industrial & PHK
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">
                    Integrasi Pengaduan Perselisihan Bipartit/Mediasi & Pelaporan PHK Resmi (PP No. 35 Tahun 2021) — Disnakerin Kota Padang
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('pelaporan-phk.index') }}" class="inline-flex items-center px-3.5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs font-bold shadow-sm transition">
                    ⚠️ Verifikasi PHK ({{ $stats['phk_menunggu'] ?? 0 }})
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 4 Top KPI Cards Terintegrasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Seluruh Berkas</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['total_semua_berkas'] ?? 0 }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            <span class="text-blue-600 font-semibold">{{ $stats['total_semua_pengaduan'] ?? 0 }} Perselisihan</span> + <span class="text-indigo-600 font-semibold">{{ $stats['total_phk'] ?? 0 }} PHK</span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        📁
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Perselisihan HI</p>
                        <p class="text-3xl font-extrabold text-blue-600 mt-1">{{ $stats['total_semua_pengaduan'] ?? 0 }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Aktif: <strong class="text-yellow-600">{{ $stats['kasus_aktif'] ?? 0 }}</strong> | Selesai: <strong class="text-green-600">{{ $stats['kasus_selesai'] ?? 0 }}</strong>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        ⚖️
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Pelaporan PHK</p>
                        <p class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $stats['total_phk'] ?? 0 }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Menunggu: <strong class="text-yellow-600">{{ $stats['phk_menunggu'] ?? 0 }}</strong> | Sah: <strong class="text-green-600">{{ $stats['phk_terverifikasi'] ?? 0 }}</strong>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        📄
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-purple-600 uppercase tracking-wider">Pekerja Ter-PHK</p>
                        <p class="text-3xl font-extrabold text-purple-600 mt-1">{{ $stats['phk_total_pekerja'] ?? 0 }} <span class="text-sm font-semibold text-gray-500">Orang</span></p>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Penerima Hak Kompensasi
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center font-bold text-xl">
                        👥
                    </div>
                </div>
            </div>

            <!-- Tab Switcher Terpadu -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b pb-4 mb-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('pengaduan.kelola', ['tab' => 'perselisihan']) }}"
                            class="px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm flex items-center gap-2 transition {{ ($activeTab ?? 'perselisihan') === 'perselisihan' ? 'bg-blue-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            ⚖️ Perselisihan Hubungan Industrial
                            <span class="px-2 py-0.5 text-xs rounded-full {{ ($activeTab ?? 'perselisihan') === 'perselisihan' ? 'bg-blue-800 text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $stats['total_semua_pengaduan'] ?? 0 }}
                            </span>
                        </a>

                        <a href="{{ route('pengaduan.kelola', ['tab' => 'phk']) }}"
                            class="px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm flex items-center gap-2 transition {{ ($activeTab ?? 'perselisihan') === 'phk' ? 'bg-indigo-600 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            📄 Pelaporan PHK (PP No. 35/2021)
                            <span class="px-2 py-0.5 text-xs rounded-full {{ ($stats['phk_menunggu'] ?? 0) > 0 ? 'bg-yellow-400 text-gray-900 font-extrabold animate-pulse' : 'bg-gray-200 text-gray-700' }}">
                                {{ $stats['total_phk'] ?? 0 }} ({{ $stats['phk_menunggu'] ?? 0 }} Butuh Verifikasi)
                            </span>
                        </a>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('pengaduan.kelola') }}" class="flex items-center gap-2 w-full sm:w-auto">
                        <input type="hidden" name="tab" value="{{ $activeTab ?? 'perselisihan' }}">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="{{ ($activeTab ?? 'perselisihan') === 'phk' ? 'Cari nama perusahaan / no. lapor...' : 'Cari nomor pengaduan / pihak...' }}"
                            class="text-xs rounded-lg border-gray-300 w-full sm:w-64 focus:ring-blue-500 focus:border-blue-500" />
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold py-2 px-3.5 rounded-lg transition">
                            Cari
                        </button>
                        @if (request('q'))
                            <a href="{{ route('pengaduan.kelola', ['tab' => $activeTab ?? 'perselisihan']) }}"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-medium py-2 px-2.5 rounded-lg transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- TAB 1: KONTEN PERSELISIHAN HI -->
                @if (($activeTab ?? 'perselisihan') === 'perselisihan')
                    @if (isset($pengaduans) && $pengaduans->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-xs">
                                <thead class="bg-gray-50 text-gray-500 uppercase font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 text-left">No</th>
                                        <th class="px-4 py-3 text-left">Nomor Kasus & Tanggal</th>
                                        <th class="px-4 py-3 text-left">Pelapor</th>
                                        <th class="px-4 py-3 text-left">Perihal Kasus</th>
                                        <th class="px-4 py-3 text-left">Pihak Terlapor</th>
                                        <th class="px-4 py-3 text-left">Mediator Ditugaskan</th>
                                        <th class="px-4 py-3 text-center">Status</th>
                                        <th class="px-4 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pengaduans as $index => $pengaduan)
                                        @php
                                            $currentUser = auth()->user();
                                            $currentMediator = $currentUser->active_role === 'mediator' ? $currentUser->mediator : null;
                                            $isAssignedToCurrentUser = $currentMediator && $pengaduan->mediator_id === $currentMediator->mediator_id;
                                            $isUnassigned = !$pengaduan->mediator_id;
                                            $canTakeAction = $isAssignedToCurrentUser || $currentUser->active_role === 'kepala_dinas';
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 font-semibold text-gray-500">
                                                {{ ($pengaduans->currentPage() - 1) * $pengaduans->perPage() + $index + 1 }}
                                            </td>
                                            <td class="px-4 py-3 font-medium">
                                                <div class="font-mono text-blue-600 font-bold">{{ $pengaduan->nomor_pengaduan ?? 'PGD-' . $pengaduan->pengaduan_id }}</div>
                                                <div class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($pengaduan->tanggal_laporan)->format('d M Y') }}</div>
                                            </td>
                                            <td class="px-4 py-3 font-semibold text-gray-900">
                                                {{ $pengaduan->pelapor->nama_pelapor ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700">
                                                    {{ $pengaduan->perihal }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-800">
                                                {{ $pengaduan->terlapor->nama_terlapor ?? $pengaduan->nama_terlapor }}
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($pengaduan->mediator)
                                                    <span class="font-semibold text-gray-900">{{ $pengaduan->mediator->nama_mediator }}</span>
                                                @else
                                                    <span class="text-orange-600 italic font-semibold">Belum Ditugaskan</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                @if($pengaduan->status === 'selesai')
                                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-green-100 text-green-800">Selesai</span>
                                                @elseif($pengaduan->status === 'proses')
                                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-blue-100 text-blue-800">Proses</span>
                                                @else
                                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-center space-x-1 whitespace-nowrap">
                                                <a href="{{ route('pengaduan.kelola.show', $pengaduan->pengaduan_id) }}" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold rounded-lg text-xs transition inline-block">
                                                    Detail
                                                </a>
                                                @if ($isUnassigned && $currentUser->active_role === 'mediator')
                                                    <form method="POST" action="{{ route('pengaduan.assign', $pengaduan->pengaduan_id) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="px-3 py-1.5 bg-green-600 text-white hover:bg-green-700 font-bold rounded-lg text-xs transition" onclick="return confirm('Ambil kasus ini untuk Anda tangani?')">
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
                            <div class="px-4 py-3 border-t border-gray-200">
                                {{ $pengaduans->links() }}
                            </div>
                        @endif
                    @else
                        <div class="p-10 text-center text-gray-500">
                            <p class="text-base font-semibold text-gray-800">Belum ada pengaduan perselisihan</p>
                            <p class="text-xs text-gray-500 mt-1">Semua kasus perselisihan bipartit dan mediasi akan tampil di tab ini.</p>
                        </div>
                    @endif

                <!-- TAB 2: KONTEN PELAPORAN PHK -->
                @else
                    @if (isset($pelaporanPhkList) && $pelaporanPhkList->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-xs">
                                <thead class="bg-gray-50 text-gray-500 uppercase font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 text-left">No. Lapor & Tanggal</th>
                                        <th class="px-4 py-3 text-left">Perusahaan & Sektor</th>
                                        <th class="px-4 py-3 text-left">Alasan PHK (PP 35/2021)</th>
                                        <th class="px-4 py-3 text-center">Pekerja</th>
                                        <th class="px-4 py-3 text-right">Total Hak</th>
                                        <th class="px-4 py-3 text-center">Status Disnakerin</th>
                                        <th class="px-4 py-3 text-center">Aksi Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pelaporanPhkList as $phk)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="font-mono text-blue-600 font-bold">{{ $phk->nomor_lapor }}</div>
                                                <div class="text-[10px] text-gray-500">{{ $phk->created_at->format('d M Y') }}</div>
                                                @if($phk->nomor_bukti_lapor_dinas)
                                                    <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-mono bg-green-50 text-green-700 font-semibold mt-1">
                                                        {{ $phk->nomor_bukti_lapor_dinas }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="font-bold text-gray-900">{{ $phk->nama_perusahaan }}</div>
                                                <div class="text-[10px] text-gray-500">{{ $phk->sektor_usaha }}</div>
                                            </td>
                                            <td class="px-4 py-3 max-w-xs">
                                                <div class="font-medium text-gray-800 line-clamp-2" title="{{ $phk->alasan_phk }}">{{ $phk->alasan_phk }}</div>
                                                <div class="text-[10px] text-gray-400 mt-0.5">Efektif: {{ $phk->tanggal_efektif_phk->format('d M Y') }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800">
                                                    {{ $phk->total_pekerja }} Orang
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-right whitespace-nowrap font-bold text-gray-900">
                                                Rp {{ number_format($phk->total_kompensasi, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                                @if($phk->status === 'terverifikasi')
                                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-green-100 text-green-800">
                                                        ✓ Terverifikasi
                                                    </span>
                                                @elseif($phk->status === 'menunggu_verifikasi')
                                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-yellow-100 text-yellow-800 animate-pulse">
                                                        ⏳ Menunggu Verifikasi
                                                    </span>
                                                @elseif($phk->status === 'perlu_revisi')
                                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-orange-100 text-orange-800">
                                                        ⚠️ Perlu Revisi
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-red-100 text-red-800">
                                                        ✕ Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-center space-x-1 whitespace-nowrap">
                                                <a href="{{ route('pelaporan-phk.show', $phk->pelaporan_phk_id) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg text-xs transition inline-block">
                                                    Verifikasi Berkas
                                                </a>
                                                @if($phk->status === 'terverifikasi')
                                                    <a href="{{ route('pelaporan-phk.cetak', $phk->pelaporan_phk_id) }}" target="_blank" class="px-2.5 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 font-bold rounded-lg text-xs transition inline-block">
                                                        🖨️ Cetak
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if (method_exists($pelaporanPhkList, 'links'))
                            <div class="px-4 py-3 border-t border-gray-200">
                                {{ $pelaporanPhkList->links() }}
                            </div>
                        @endif
                    @else
                        <div class="p-10 text-center text-gray-500">
                            <p class="text-base font-semibold text-gray-800">Belum ada pelaporan PHK yang tercatat</p>
                            <p class="text-xs text-gray-500 mt-1">Laporan PHK yang didaftarkan oleh perusahaan akan muncul di tab ini.</p>
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
