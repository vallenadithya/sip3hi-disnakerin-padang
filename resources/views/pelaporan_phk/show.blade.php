<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Detail Pelaporan PHK
                    </h2>
                    @if($pelaporan->status === 'terverifikasi')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                            ✓ Terverifikasi
                        </span>
                    @elseif($pelaporan->status === 'menunggu_verifikasi')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                            ⏳ Menunggu Verifikasi
                        </span>
                    @elseif($pelaporan->status === 'perlu_revisi')
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-800">
                            ⚠️ Perlu Revisi
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                            ✕ Ditolak
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-0.5">
                    No. Registrasi: <span class="font-mono font-bold text-blue-600">{{ $pelaporan->nomor_lapor }}</span>
                    @if($pelaporan->nomor_bukti_lapor_dinas)
                        | No. Bukti Lapor Dinas: <span class="font-mono font-bold text-green-700">{{ $pelaporan->nomor_bukti_lapor_dinas }}</span>
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('pelaporan-phk.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
                    ← Kembali
                </a>
                @if($pelaporan->status === 'terverifikasi')
                    <a href="{{ route('pelaporan-phk.cetak', $pelaporan->pelaporan_phk_id) }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-bold hover:bg-green-700 shadow-sm transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Surat Tanda Bukti Lapor
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Panel Verifikasi Khusus Petugas Disnakerin / Kadis -->
            @if(in_array(Auth::user()->active_role, ['mediator', 'kepala_dinas']))
                <div class="bg-gradient-to-r from-blue-900 to-indigo-900 text-white rounded-xl shadow-md p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <span class="bg-blue-800 text-blue-200 text-xs px-2.5 py-1 rounded font-bold uppercase tracking-wider">Aksi Petugas Disnakerin</span>
                            <h3 class="text-lg font-bold mt-2">Verifikasi Dokumen & Administrasi PHK</h3>
                            <p class="text-xs text-blue-200 mt-1 max-w-xl">
                                Pastikan berkas surat persetujuan pekerja / perjanjian bersama telah terlampir dan hak pesangon telah sesuai ketentuan PP No. 35 Tahun 2021 sebelum memverifikasi.
                            </p>
                        </div>
                        <button type="button" onclick="document.getElementById('modalVerifikasi').classList.remove('hidden')" class="px-5 py-2.5 bg-yellow-400 text-gray-900 rounded-lg text-sm font-bold hover:bg-yellow-300 shadow transition flex items-center gap-1.5">
                            ⚙️ Proses Verifikasi Berkas
                        </button>
                    </div>

                    @if($pelaporan->catatan_verifikasi)
                        <div class="mt-4 pt-4 border-t border-blue-800/60 text-xs text-blue-100">
                            <strong>Catatan Verifikator:</strong> {{ $pelaporan->catatan_verifikasi }}
                            @if($pelaporan->verifikator)
                                <span class="text-blue-300"> (Oleh: {{ $pelaporan->verifikator->getName() }} - {{ $pelaporan->tanggal_diverifikasi ? $pelaporan->tanggal_diverifikasi->format('d M Y H:i') : '' }})</span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Modal Verifikasi -->
                <div id="modalVerifikasi" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden">
                    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl text-gray-800">
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h4 class="font-bold text-lg text-gray-900">Form Verifikasi Disnakerin</h4>
                            <button type="button" onclick="document.getElementById('modalVerifikasi').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                        </div>
                        <form action="{{ route('pelaporan-phk.verifikasi', $pelaporan->pelaporan_phk_id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Keputusan Status Verifikasi <span class="text-red-500">*</span></label>
                                    <select name="status" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="terverifikasi" {{ $pelaporan->status === 'terverifikasi' ? 'selected' : '' }}>✓ Terverifikasi (Terbitkan Nomor Bukti Lapor Resmi)</option>
                                        <option value="perlu_revisi" {{ $pelaporan->status === 'perlu_revisi' ? 'selected' : '' }}>⚠️ Perlu Revisi (Berkas Kurang / Belum Sesuai)</option>
                                        <option value="ditolak" {{ $pelaporan->status === 'ditolak' ? 'selected' : '' }}>✕ Ditolak (Tidak Memenuhi Syarat Administratif)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Catatan / Uraian Hasil Pemeriksaan</label>
                                    <textarea name="catatan_verifikasi" rows="4" placeholder="Tuliskan catatan pemeriksaan berkas, kelengkapan surat tanda terima persetujuan pekerja, dsb..." class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('catatan_verifikasi', $pelaporan->catatan_verifikasi) }}</textarea>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 mt-6 pt-3 border-t">
                                <button type="button" onclick="document.getElementById('modalVerifikasi').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200">
                                    Batal
                                </button>
                                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 shadow">
                                    Simpan Hasil Verifikasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Ringkasan Data Pokok -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Perusahaan Pelapor</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $pelaporan->nama_perusahaan }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Sektor: {{ $pelaporan->sektor_usaha }}</p>
                    @if($pelaporan->nib)
                        <p class="text-xs text-gray-500">NIB: {{ $pelaporan->nib }}</p>
                    @endif
                    <p class="text-xs text-gray-600 mt-2">PIC: {{ $pelaporan->nama_kontak }} ({{ $pelaporan->no_telepon }})</p>
                    <p class="text-xs text-gray-500">Email: {{ $pelaporan->email_perusahaan }}</p>
                    <p class="text-xs text-gray-500 mt-1">Alamat: {{ $pelaporan->alamat_perusahaan }}</p>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Dasar & Ketentuan PHK</p>
                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ $pelaporan->alasan_phk }}</p>
                    <div class="mt-3 pt-3 border-t border-gray-100 text-xs space-y-1">
                        <p><span class="text-gray-500">Dasar Hukum:</span> <span class="font-medium text-gray-800">{{ $pelaporan->dasar_hukum }}</span></p>
                        <p><span class="text-gray-500">Tgl Efektif PHK:</span> <span class="font-semibold text-gray-800">{{ $pelaporan->tanggal_efektif_phk->format('d F Y') }}</span></p>
                        @if($pelaporan->tanggal_pemberitahuan)
                            <p><span class="text-gray-500">Tgl Pemberitahuan:</span> <span class="text-gray-800">{{ $pelaporan->tanggal_pemberitahuan->format('d F Y') }}</span></p>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-bold text-gray-400 uppercase">Rekapitulasi Kompensasi</p>
                    <p class="text-2xl font-black text-green-600 mt-1">Rp {{ number_format($pelaporan->total_kompensasi, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Total Pekerja: <strong class="text-gray-800">{{ $pelaporan->total_pekerja }} Orang</strong></p>
                    <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-500">
                        Status Persetujuan Pekerja: <strong class="text-green-700">✓ Disetujui/Diterima</strong>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Pekerja yang Menerima PHK -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-sm">
                        Daftar Pekerja Ter-PHK & Rincian Hak Pesangon (PP 35/2021)
                    </h3>
                    <span class="text-xs font-semibold text-gray-500">
                        Total {{ $pelaporan->pekerja->count() }} Orang
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama Pekerja</th>
                                <th class="px-4 py-3 text-left">NIK (KTP)</th>
                                <th class="px-4 py-3 text-left">No. KPJ BPJS</th>
                                <th class="px-4 py-3 text-left">Jabatan</th>
                                <th class="px-4 py-3 text-left">Masa Kerja</th>
                                <th class="px-4 py-3 text-right">Pesangon</th>
                                <th class="px-4 py-3 text-right">UPMK</th>
                                <th class="px-4 py-3 text-right">UPH</th>
                                <th class="px-4 py-3 text-right">Total Hak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-xs bg-white">
                            @foreach($pelaporan->pekerja as $index => $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $p->nama_pekerja }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-600">{{ $p->nik }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-500">{{ $p->nomor_kpj ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $p->jabatan }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $p->masa_kerja }}</td>
                                    <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($p->uang_pesangon, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($p->uang_penghargaan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($p->uang_penggantian_hak, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-bold text-green-700">Rp {{ number_format($p->total_kompensasi, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold text-xs text-gray-800">
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-right uppercase">Total Keseluruhan Kompensasi:</td>
                                <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($pelaporan->pekerja->sum('uang_pesangon'), 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($pelaporan->pekerja->sum('uang_penghargaan'), 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right text-gray-700">Rp {{ number_format($pelaporan->pekerja->sum('uang_penggantian_hak'), 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right text-green-700 text-sm">Rp {{ number_format($pelaporan->total_kompensasi, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Berkas Terlampir -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-sm border-b pb-3 mb-4">
                    Berkas Administratif yang Diunggah
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Berkas 1: Persetujuan Pekerja -->
                    <div class="p-4 border rounded-xl bg-gray-50 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold text-blue-600 uppercase">Berkas Wajib</span>
                            <p class="text-sm font-semibold text-gray-900 mt-1">Surat Persetujuan / PB Pekerja</p>
                            <p class="text-xs text-gray-500 mt-1">Bukti pekerja menerima dan menyepakati PHK.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t">
                            @if($pelaporan->file_persetujuan_pekerja)
                                <a href="{{ asset('storage/' . $pelaporan->file_persetujuan_pekerja) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                                    📂 Buka / Unduh Berkas
                                </a>
                            @else
                                <span class="text-xs text-red-500 font-medium">Tidak ada berkas</span>
                            @endif
                        </div>
                    </div>

                    <!-- Berkas 2: Pemberitahuan PHK -->
                    <div class="p-4 border rounded-xl bg-gray-50 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-500 uppercase">Dokumen Pendukung</span>
                            <p class="text-sm font-semibold text-gray-900 mt-1">Surat Pemberitahuan PHK</p>
                            <p class="text-xs text-gray-500 mt-1">Maksud & alasan dari pihak pemberi kerja.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t">
                            @if($pelaporan->file_surat_pemberitahuan)
                                <a href="{{ asset('storage/' . $pelaporan->file_surat_pemberitahuan) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                                    📂 Buka / Unduh Berkas
                                </a>
                            @else
                                <span class="text-xs text-gray-400">Tidak dilampirkan</span>
                            @endif
                        </div>
                    </div>

                    <!-- Berkas 3: Bukti Kompensasi -->
                    <div class="p-4 border rounded-xl bg-gray-50 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-500 uppercase">Dokumen Pendukung</span>
                            <p class="text-sm font-semibold text-gray-900 mt-1">Bukti Transfer / Pesangon</p>
                            <p class="text-xs text-gray-500 mt-1">Tanda terima pembayaran kompensasi hak.</p>
                        </div>
                        <div class="mt-4 pt-3 border-t">
                            @if($pelaporan->file_bukti_kompensasi)
                                <a href="{{ asset('storage/' . $pelaporan->file_bukti_kompensasi) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                                    📂 Buka / Unduh Berkas
                                </a>
                            @else
                                <span class="text-xs text-gray-400">Tidak dilampirkan</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
