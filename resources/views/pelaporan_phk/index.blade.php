<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Pelaporan PHK (Pemutusan Hubungan Kerja)
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Pencatatan Administratif PHK yang Telah Disepakati Pekerja Berdasarkan PP No. 35 Tahun 2021 — Disnakerin Kota Padang
                </p>
            </div>
            <div class="flex items-center gap-2">
                @if(in_array(Auth::user()->active_role, ['mediator', 'kepala_dinas']))
                    <a href="{{ route('pelaporan-phk.statistik') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Statistik PHK
                    </a>
                @endif
                <a href="{{ route('pelaporan-phk.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 shadow-sm transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajukan Laporan PHK Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Banner Penjelasan Regulasi -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 text-sm text-blue-800">
                        <p class="font-semibold">Ketentuan Pelaporan PHK (Pasal 39 PP No. 35 Tahun 2021):</p>
                        <p class="mt-0.5 text-blue-700">
                            Modul ini khusus bagi perusahaan/pengusaha untuk <strong>mencatatkan PHK yang telah disepakati/diterima pekerja</strong> beserta pemenuhan hak kompensasi (pesangon). Laporan ini diverifikasi oleh Disnakerin Kota Padang untuk penerbitan <strong>Surat Tanda Bukti Lapor Resmi</strong> (persyaratan klaim JKP BPJS Ketenagakerjaan). Jika pekerja menolak/ada perselisihan, silakan gunakan menu Pengaduan Perselisihan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kartu Statistik Singkat -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase">Total Laporan</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-lg">
                        📄
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-yellow-600 uppercase">Menunggu Verifikasi</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['menunggu'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center font-bold text-lg">
                        ⏳
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-green-600 uppercase">Terverifikasi</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['terverifikasi'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center font-bold text-lg">
                        ✅
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-purple-600 uppercase">Total Pekerja Ter-PHK</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1">{{ $stats['total_pekerja'] }} Orang</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center font-bold text-lg">
                        👥
                    </div>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                <form method="GET" action="{{ route('pelaporan-phk.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Cari Perusahaan / No. Lapor</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status Verifikasi</label>
                        <select name="status" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            <option value="perlu_revisi" {{ request('status') == 'perlu_revisi' ? 'selected' : '' }}>Perlu Revisi</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Sektor Usaha</label>
                        <select name="sektor_usaha" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Sektor</option>
                            <option value="Perdagangan Besar dan Eceran" {{ request('sektor_usaha') == 'Perdagangan Besar dan Eceran' ? 'selected' : '' }}>Perdagangan</option>
                            <option value="Industri Pengolahan / Manufaktur" {{ request('sektor_usaha') == 'Industri Pengolahan / Manufaktur' ? 'selected' : '' }}>Manufaktur</option>
                            <option value="Akomodasi, Hotel dan Restoran" {{ request('sektor_usaha') == 'Akomodasi, Hotel dan Restoran' ? 'selected' : '' }}>Hotel & Resto</option>
                            <option value="Konstruksi dan Real Estate" {{ request('sektor_usaha') == 'Konstruksi dan Real Estate' ? 'selected' : '' }}>Konstruksi</option>
                            <option value="Transportasi, Pergudangan dan Logistik" {{ request('sektor_usaha') == 'Transportasi, Pergudangan dan Logistik' ? 'selected' : '' }}>Transportasi</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('pelaporan-phk.index') }}" class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Pelaporan PHK -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Lapor & Tanggal</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Perusahaan & Sektor</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alasan PHK (PP 35/2021)</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Pekerja</th>
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Kompensasi</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Disnakerin</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($pelaporans as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-blue-600">{{ $item->nomor_lapor }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</div>
                                        @if($item->nomor_bukti_lapor_dinas)
                                            <div class="mt-1 inline-flex items-center text-xs text-green-700 bg-green-50 px-2 py-0.5 rounded font-mono font-medium">
                                                {{ $item->nomor_bukti_lapor_dinas }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $item->nama_perusahaan }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->sektor_usaha }}</div>
                                        <div class="text-xs text-gray-400 truncate max-w-xs">{{ $item->alamat_perusahaan }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-700 max-w-xs font-medium">{{ $item->alasan_phk }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Efektif: {{ $item->tanggal_efektif_phk->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                            {{ $item->total_pekerja }} Orang
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($item->total_kompensasi, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($item->status === 'terverifikasi')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                ✓ Terverifikasi
                                            </span>
                                        @elseif($item->status === 'menunggu_verifikasi')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 animate-pulse">
                                                ⏳ Menunggu Verifikasi
                                            </span>
                                        @elseif($item->status === 'perlu_revisi')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                ⚠️ Perlu Revisi
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                ✕ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                        <a href="{{ route('pelaporan-phk.show', $item->pelaporan_phk_id) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-xs bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition inline-block">
                                            Lihat Detail
                                        </a>
                                        @if($item->status === 'terverifikasi')
                                            <a href="{{ route('pelaporan-phk.cetak', $item->pelaporan_phk_id) }}" target="_blank" class="text-green-600 hover:text-green-900 font-semibold text-xs bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition inline-block">
                                                🖨️ Bukti Lapor
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-base font-medium text-gray-800">Belum Ada Pelaporan PHK</p>
                                        <p class="text-xs text-gray-500 mt-1">Gunakan tombol "Ajukan Laporan PHK Baru" untuk mulai mencatat pelaporan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pelaporans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $pelaporans->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
