<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Form Pelaporan Pemutusan Hubungan Kerja (PHK)
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    Pencatatan Resmi Disnakerin Kota Padang Berdasarkan Pasal 39 PP No. 35 Tahun 2021
                </p>
            </div>
            <a href="{{ route('pelaporan-phk.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1 font-medium">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (isset($errors) && $errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0 text-red-500">
                            ✕
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Mohon lengkapi data berikut:</h3>
                            <ul class="mt-2 list-disc list-inside text-xs text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Box Regulasi -->
            <div class="mb-6 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="text-amber-600 text-lg mr-3">⚠️</div>
                    <div class="text-xs text-amber-800 leading-relaxed">
                        <p class="font-bold text-amber-900 text-sm">Persyaratan Administratif Pelaporan PHK (PP 35/2021):</p>
                        <p class="mt-1">
                            Pelaporan PHK ke Disnakerin Kota Padang hanya dapat diproses apabila <strong>pekerja telah menyatakan persetujuan / menerima PHK</strong> dan telah dicapai kesepakatan mengenai pemenuhan hak-haknya (uang pesangon, penghargaan masa kerja, dan penggantian hak). Pastikan mengunggah <strong>Surat Persetujuan Pekerja / Perjanjian Bersama</strong> yang ditandatangani kedua belah pihak.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('pelaporan-phk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="phkForm">
                @csrf

                <!-- Section 1: Profil Perusahaan -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        Identitas Perusahaan / Pemberi Kerja
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Perusahaan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $defaultData['nama_perusahaan']) }}" required placeholder="Contoh: PT Semen Padang Distributor" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Induk Berusaha (NIB)</label>
                            <input type="text" name="nib" value="{{ old('nib') }}" placeholder="Contoh: 9120001234567" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Sektor Usaha <span class="text-red-500">*</span></label>
                            <select name="sektor_usaha" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih Sektor Usaha --</option>
                                @foreach($sektorList as $sektor)
                                    <option value="{{ $sektor }}" {{ old('sektor_usaha') == $sektor ? 'selected' : '' }}>{{ $sektor }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Email Resmi Perusahaan <span class="text-red-500">*</span></label>
                            <input type="email" name="email_perusahaan" value="{{ old('email_perusahaan', $defaultData['email_perusahaan']) }}" required placeholder="hrd@perusahaan.com" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama PIC / Kontak HRD <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_kontak" value="{{ old('nama_kontak', $defaultData['nama_kontak']) }}" required placeholder="Nama Lengkap Penanggung Jawab" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', $defaultData['no_telepon']) }}" required placeholder="08xxxxxxxxxx" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Kantor di Kota Padang <span class="text-red-500">*</span></label>
                            <textarea name="alamat_perusahaan" rows="2" required placeholder="Jl. Sudirman No. XX, Kota Padang" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('alamat_perusahaan', $defaultData['alamat_perusahaan']) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Dasar & Alasan PHK -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        Alasan & Dasar Pelaporan PHK
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Alasan PHK (Sesuai PP No. 35 Tahun 2021) <span class="text-red-500">*</span></label>
                            <select name="alasan_phk" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih Alasan PHK yang Telah Disepakati --</option>
                                @foreach($alasanList as $alasan)
                                    <option value="{{ $alasan }}" {{ old('alasan_phk') == $alasan ? 'selected' : '' }}>{{ $alasan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Efektif PHK <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_efektif_phk" value="{{ old('tanggal_efektif_phk', now()->toDateString()) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal Surat Pemberitahuan PHK</label>
                            <input type="date" name="tanggal_pemberitahuan" value="{{ old('tanggal_pemberitahuan') }}" class="w-full text-sm rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Rincian Pekerja yang Menerima PHK -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between border-b pb-3 mb-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                            Daftar Pekerja Ter-PHK & Rincian Kompensasi
                        </h3>
                        <button type="button" id="btnAddPekerja" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">
                            + Tambah Pekerja
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="pekerjaTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Nama Pekerja *</th>
                                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">NIK (KTP) *</th>
                                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">No BPJS (KPJ)</th>
                                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Jabatan *</th>
                                    <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Masa Kerja *</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">Pesangon (Rp)</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">UPMK (Rp)</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold text-gray-600">UPH (Rp)</th>
                                    <th class="px-3 py-2 text-center text-xs font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="pekerjaBody">
                                <!-- Row default 1 -->
                                <tr class="pekerja-row">
                                    <td class="p-2"><input type="text" name="pekerja[0][nama_pekerja]" required placeholder="Nama Lengkap" class="w-36 text-xs rounded border-gray-300"></td>
                                    <td class="p-2"><input type="text" name="pekerja[0][nik]" required placeholder="16 digit NIK" class="w-32 text-xs rounded border-gray-300"></td>
                                    <td class="p-2"><input type="text" name="pekerja[0][nomor_kpj]" placeholder="No. KPJ BPJS" class="w-28 text-xs rounded border-gray-300"></td>
                                    <td class="p-2"><input type="text" name="pekerja[0][jabatan]" required placeholder="Staff/Teknisi" class="w-28 text-xs rounded border-gray-300"></td>
                                    <td class="p-2"><input type="text" name="pekerja[0][masa_kerja]" required placeholder="3 Thn 2 Bln" class="w-24 text-xs rounded border-gray-300"></td>
                                    <td class="p-2"><input type="number" name="pekerja[0][uang_pesangon]" value="0" min="0" step="1000" class="uang-input w-28 text-xs rounded border-gray-300 text-right"></td>
                                    <td class="p-2"><input type="number" name="pekerja[0][uang_penghargaan]" value="0" min="0" step="1000" class="uang-input w-28 text-xs rounded border-gray-300 text-right"></td>
                                    <td class="p-2"><input type="number" name="pekerja[0][uang_penggantian_hak]" value="0" min="0" step="1000" class="uang-input w-28 text-xs rounded border-gray-300 text-right"></td>
                                    <td class="p-2 text-center">
                                        <button type="button" class="btn-remove-row text-red-500 hover:text-red-700 text-xs font-bold disabled:opacity-30" disabled>✕</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Rekap Section -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg flex flex-col sm:flex-row justify-between items-center text-sm font-semibold text-gray-700">
                        <div>
                            Total Pekerja: <span id="labelTotalPekerja" class="text-blue-600 font-bold">1</span> Orang
                        </div>
                        <div>
                            Total Nilai Kompensasi: <span id="labelTotalKompensasi" class="text-green-600 font-bold text-base">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Berkas & Dokumen Pendukung -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">4</span>
                        Upload Berkas Administratif (Disnakerin Padang)
                    </h3>

                    <div class="space-y-4 text-xs">
                        <!-- File 1: Surat Persetujuan Pekerja (Wajib) -->
                        <div class="p-4 border-2 border-dashed border-blue-300 rounded-lg bg-blue-50/40">
                            <label class="block font-bold text-gray-800 text-sm mb-1">
                                1. Surat Persetujuan / Pernyataan Menerima PHK dari Pekerja (Wajib) <span class="text-red-600">*</span>
                            </label>
                            <p class="text-gray-500 mb-2">
                                Dokumen bukti bahwa pekerja telah menyetujui keputusan PHK atau Perjanjian Bersama (PB) Bipartit yang ditandatangani pekerja & pengusaha. (Format: PDF / Foto JPG/PNG, maks 5MB)
                            </p>
                            <input type="file" name="file_persetujuan_pekerja" required accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        </div>

                        <!-- File 2: Surat Pemberitahuan PHK -->
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <label class="block font-semibold text-gray-800 text-sm mb-1">
                                2. Surat Pemberitahuan PHK dari Perusahaan (Opsional)
                            </label>
                            <p class="text-gray-500 mb-2">
                                Surat resmi dari perusahaan kepada pekerja mengenai maksud dan alasan PHK paling lambat 14 hari kerja sebelum PHK berlaku.
                            </p>
                            <input type="file" name="file_surat_pemberitahuan" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                        </div>

                        <!-- File 3: Bukti Pembayaran Kompensasi / Pesangon -->
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <label class="block font-semibold text-gray-800 text-sm mb-1">
                                3. Bukti Pembayaran / Slip Hak Pesangon (Opsional)
                            </label>
                            <p class="text-gray-500 mb-2">
                                Bukti transfer bank atau kuitansi tanda terima uang pesangon, penghargaan masa kerja, dan penggantian hak.
                            </p>
                            <input type="file" name="file_bukti_kompensasi" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('pelaporan-phk.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Kirim Laporan ke Disnakerin
                    </button>
                </div>
            </form>

        </div>
    </div>

    @push('scripts')
    <script>
        let rowIndex = 1;

        function hitungTotal() {
            let total = 0;
            const rows = document.querySelectorAll('.pekerja-row');
            rows.forEach(row => {
                const inputs = row.querySelectorAll('.uang-input');
                inputs.forEach(inp => {
                    const val = parseFloat(inp.value) || 0;
                    total += val;
                });
            });

            document.getElementById('labelTotalPekerja').innerText = rows.length;
            document.getElementById('labelTotalKompensasi').innerText = 'Rp ' + total.toLocaleString('id-ID');

            // Aktifkan tombol remove jika lebih dari 1 row
            rows.forEach(row => {
                const btn = row.querySelector('.btn-remove-row');
                if (btn) btn.disabled = (rows.length === 1);
            });
        }

        document.getElementById('btnAddPekerja').addEventListener('click', function() {
            const tbody = document.getElementById('pekerjaBody');
            const tr = document.createElement('tr');
            tr.className = 'pekerja-row';
            tr.innerHTML = `
                <td class="p-2"><input type="text" name="pekerja[${rowIndex}][nama_pekerja]" required placeholder="Nama Lengkap" class="w-36 text-xs rounded border-gray-300"></td>
                <td class="p-2"><input type="text" name="pekerja[${rowIndex}][nik]" required placeholder="16 digit NIK" class="w-32 text-xs rounded border-gray-300"></td>
                <td class="p-2"><input type="text" name="pekerja[${rowIndex}][nomor_kpj]" placeholder="No. KPJ BPJS" class="w-28 text-xs rounded border-gray-300"></td>
                <td class="p-2"><input type="text" name="pekerja[${rowIndex}][jabatan]" required placeholder="Staff/Teknisi" class="w-28 text-xs rounded border-gray-300"></td>
                <td class="p-2"><input type="text" name="pekerja[${rowIndex}][masa_kerja]" required placeholder="3 Thn 2 Bln" class="w-24 text-xs rounded border-gray-300"></td>
                <td class="p-2"><input type="number" name="pekerja[${rowIndex}][uang_pesangon]" value="0" min="0" step="1000" class="uang-input w-28 text-xs rounded border-gray-300 text-right"></td>
                <td class="p-2"><input type="number" name="pekerja[${rowIndex}][uang_penghargaan]" value="0" min="0" step="1000" class="uang-input w-28 text-xs rounded border-gray-300 text-right"></td>
                <td class="p-2"><input type="number" name="pekerja[${rowIndex}][uang_penggantian_hak]" value="0" min="0" step="1000" class="uang-input w-28 text-xs rounded border-gray-300 text-right"></td>
                <td class="p-2 text-center">
                    <button type="button" class="btn-remove-row text-red-500 hover:text-red-700 text-xs font-bold">✕</button>
                </td>
            `;
            tbody.appendChild(tr);
            rowIndex++;
            hitungTotal();
        });

        document.getElementById('pekerjaBody').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-remove-row')) {
                const rows = document.querySelectorAll('.pekerja-row');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                    hitungTotal();
                }
            }
        });

        document.getElementById('pekerjaBody').addEventListener('input', function(e) {
            if (e.target && e.target.classList.contains('uang-input')) {
                hitungTotal();
            }
        });

        // Hitung inisial
        hitungTotal();
    </script>
    @endpush
</x-app-layout>
