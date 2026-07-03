<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Input Realisasi KPI</h2>
        <p class="text-sm text-slate-500 mt-1">
            Isi hasil pencapaian kerja kamu berdasarkan indikator KPI yang telah ditetapkan.
            Data ini akan diverifikasi oleh admin.
        </p>
    </x-slot>

    <div x-data="realisasiForm()" class="space-y-6">

        <form action="{{ route('kpi-saya.input.store') }}" method="POST" @submit="beforeSubmit">
            @csrf
            <input type="hidden" name="kpi_template_id" :value="templateId">

            <x-card title="Informasi Pegawai" subtitle="Data diambil otomatis dari akun kamu." icon="user-circle">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <x-input-label value="Nama" />
                        <p class="text-sm font-semibold text-slate-700 mt-1">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <x-input-label value="Jabatan" />
                        <p class="text-sm font-semibold text-slate-700 mt-1">{{ $entitas?->jabatan ?? '-' }}</p>
                    </div>
                    <div>
                        <x-input-label value="Departemen" />
                        <p class="text-sm font-semibold text-slate-700 mt-1">{{ $entitas?->program_studi ?? $entitas?->departemen ?? '-' }}</p>
                    </div>
                </div>

                @if(!$entitas)
                <div class="mt-4 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700">
                    Data {{ strtolower($kategori) }} untuk akun ini tidak ditemukan. Hubungi admin untuk mendaftarkannya dengan nama yang sama dengan akun login kamu.
                </div>
                @endif
            </x-card>

            <x-card title="Pilih Periode Penilaian" icon="calendar">
                <div class="max-w-sm">
                    <x-input-label for="periode_id" value="Tahun Akademik / Periode" />
                    <select id="periode_id" name="periode_id" x-model="periodeId" @change="loadTemplate()"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm mt-1">
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}">{{ $periode->nama_periode }} ({{ $periode->tahun }})</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('periode_id')" class="mt-1.5" />
                </div>

                <div x-show="alreadySubmitted" x-cloak
                     class="mt-4 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-sm text-amber-700">
                    <strong>Perhatian:</strong> Kamu sudah pernah mengisi realisasi untuk periode ini.
                    Jika disimpan lagi, data sebelumnya akan digantikan.
                    <span x-show="isVerified" class="text-red-600 font-semibold"> (Sudah diverifikasi admin — tidak bisa diubah)</span>
                </div>

                <div x-show="periodeId && !loading && items.length === 0" x-cloak
                     class="mt-4 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-600">
                    Belum ada template KPI untuk jabatan kamu (<strong>{{ $entitas?->jabatan }}</strong>) pada periode ini.
                    Silakan hubungi admin untuk membuat template KPI terlebih dahulu.
                </div>

                <div x-show="loading" x-cloak class="mt-4 text-sm text-slate-400 flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Memuat indikator KPI...
                </div>
            </x-card>

            <x-card class="mt-6" x-show="items.length > 0 && !isVerified" x-cloak>
                <div class="flex items-center gap-2 mb-5">
                    <x-icon name="flag" class="w-5 h-5 text-blue-600" />
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Form Input Realisasi</h3>
                        <p class="text-xs text-slate-400">Isi kolom <strong>Hasil</strong> sesuai pencapaian nyata kamu. Nilai % dihitung otomatis.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                                <th class="px-3 py-3 text-left rounded-l-lg w-10">No</th>
                                <th class="px-3 py-3 text-left">Indikator KPI</th>
                                <th class="px-3 py-3 text-left w-28">Target</th>
                                <th class="px-3 py-3 text-left w-36">Hasil Realisasi</th>
                                <th class="px-3 py-3 text-left w-24">Nilai (%)</th>
                                <th class="px-3 py-3 text-left rounded-r-lg">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td class="px-3 py-3 text-slate-500" x-text="index + 1"></td>
                                    <td class="px-3 py-3 font-medium text-slate-700">
                                        <span x-text="item.indikator"></span>
                                        <p class="text-xs text-slate-400 mt-0.5" x-text="item.deskripsi"></p>
                                        <input type="hidden" :name="'aspek[' + index + ']'" :value="item.aspek">
                                        <input type="hidden" :name="'indikator[' + index + ']'" :value="item.indikator">
                                        <input type="hidden" :name="'satuan[' + index + ']'" :value="item.satuan">
                                        <input type="hidden" :name="'target[' + index + ']'" :value="item.target">
                                        <input type="hidden" :name="'bobot[' + index + ']'" :value="item.bobot">
                                    </td>
                                    <td class="px-3 py-3 text-slate-600" x-text="item.target + ' ' + (item.satuan || '')"></td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-1.5">
                                            <input type="number" step="0.01" min="0"
                                                   :name="'hasil[' + index + ']'"
                                                   x-model.number="item.hasil"
                                                   class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                                                   placeholder="0">
                                            <span class="text-xs text-slate-400 whitespace-nowrap" x-text="item.satuan"></span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="inline-flex items-center justify-center font-semibold px-2 py-1 rounded-lg text-xs min-w-[56px]"
                                              :class="persenItem(item) >= 85 ? 'bg-green-100 text-green-700' : (persenItem(item) >= 70 ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700')"
                                              x-text="persenItem(item).toFixed(2) + '%'"></span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <input type="text"
                                               :name="'keterangan[' + index + ']'"
                                               x-model="item.keterangan"
                                               class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                                               placeholder="Bukti / keterangan (opsional)">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </x-card>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6" x-show="items.length > 0 && !isVerified" x-cloak>
                <div class="lg:col-span-2">
                    <x-input-label value="Catatan (Opsional)" />
                    <textarea name="catatan" rows="4"
                              class="w-full mt-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                              placeholder="Tambahkan penjelasan atau bukti pendukung jika diperlukan..."></textarea>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center text-center">
                    <p class="text-sm text-slate-500">Estimasi Nilai</p>
                    <p class="text-3xl font-extrabold mt-1"
                       :class="totalNilai >= 85 ? 'text-green-600' : (totalNilai >= 70 ? 'text-blue-600' : 'text-amber-600')"
                       x-text="totalNilai.toFixed(2) + '%'"></p>
                    <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                          :class="totalNilai >= 85 ? 'bg-green-100 text-green-700' : (totalNilai >= 70 ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700')"
                          x-text="predikat()"></span>
                    <p class="text-xs text-slate-400 mt-2">*Estimasi. Nilai final ditentukan oleh admin.</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-wrap items-center justify-end gap-3 mt-6"
                 x-show="items.length > 0 && !isVerified" x-cloak>
                <a href="{{ route('kpi-saya.index') }}">
                    <x-secondary-button type="button">Batal</x-secondary-button>
                </a>
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Kirim Realisasi
                </x-primary-button>
            </div>

        </form>
    </div>

    <script>
        function realisasiForm() {
            return {
                periodeId: '',
                templateId: null,
                items: [],
                loading: false,
                alreadySubmitted: false,
                isVerified: false,
                jabatan: '{{ $entitas?->jabatan ?? '' }}',

                async loadTemplate() {
                    this.items = [];
                    this.templateId = null;
                    this.alreadySubmitted = false;
                    this.isVerified = false;
                    if (!this.periodeId) return;
                    this.loading = true;

                    try {
                        const existRes = await fetch(`{{ route('kpi-saya.existing') }}?periode_id=${this.periodeId}`);
                        const existData = await existRes.json();

                        if (existData.exists) {
                            this.alreadySubmitted = true;
                            this.isVerified = existData.status === 'final';
                            if (this.isVerified) { this.loading = false; return; }

                            this.items = (existData.items || []).map(i => ({
                                id: i.id, aspek: i.aspek, indikator: i.indikator,
                                deskripsi: i.deskripsi || '', target: i.target,
                                satuan: i.satuan, bobot: i.bobot,
                                hasil: i.hasil ?? 0, keterangan: i.keterangan || '',
                            }));
                            this.loading = false;
                            return;
                        }
                        const tmplRes = await fetch(`{{ route('kpi-nilai.get-template-items') }}?periode_id=${this.periodeId}&kategori_pegawai={{ $kategori }}&jabatan=${encodeURIComponent(this.jabatan)}&pegawai_nama=${encodeURIComponent('{{ Auth::user()->name }}')}`);   
                        const tmplData = await tmplRes.json();

                        this.templateId = tmplData.template_id;
                        this.items = (tmplData.items || []).map(i => ({
                            id: i.id, aspek: i.aspek, indikator: i.indikator,
                            deskripsi: i.deskripsi || '', target: i.target,
                            satuan: i.satuan, bobot: i.bobot, hasil: 0, keterangan: '',
                        }));
                    } catch(e) { this.items = []; }

                    this.loading = false;
                },

                persenItem(item) {
                    const target = parseFloat(item.target) || 0;
                    const hasil = parseFloat(item.hasil) || 0;
                    if (target <= 0) return 0;
                    return Math.min(100, (hasil / target) * 100);
                },

                get totalNilai() {
                    if (this.items.length === 0) return 0;
                    return this.items.reduce((sum, item) => {
                        const bobot = parseFloat(item.bobot) || 0;
                        return sum + (this.persenItem(item) * bobot) / 100;
                    }, 0);
                },

                predikat() {
                    if (this.totalNilai >= 85) return 'Sangat Baik';
                    if (this.totalNilai >= 70) return 'Baik';
                    return 'Perlu Perbaikan';
                },

                beforeSubmit(e) {
                    if (!this.periodeId) { e.preventDefault(); alert('Pilih periode terlebih dahulu.'); return; }
                    if (this.items.length === 0) { e.preventDefault(); alert('Tidak ada indikator KPI. Hubungi admin.'); }
                }
            }
        }
    </script>

</x-app-layout>