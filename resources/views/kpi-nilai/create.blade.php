<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Input Nilai KPI</h2>
        <p class="text-sm text-slate-500 mt-1">Isi nilai pencapaian KPI pegawai sesuai target yang telah ditetapkan.</p>
    </x-slot>

    <div x-data="kpiNilaiForm()" class="space-y-6">

        <form action="{{ route('kpi-nilai.store') }}" method="POST" @submit="beforeSubmit">
            @csrf
            <input type="hidden" name="kpi_template_id" :value="templateId">

            <!-- Info Umum -->
            <x-card title="Form Input Nilai KPI" subtitle="Pilih semester, periode, dan nama pegawai yang dinilai." icon="document-text">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                    <div>
                        <x-input-label value="Semester" />
                        <select x-model="semester" @change="loadItems()"
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label value="Tahun Akademik" />
                        <select name="periode_id" x-model="periodeId" @change="loadItems()"
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                            <option value="">-- Pilih --</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}">{{ $periode->nama_periode }} ({{ $periode->tahun }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('periode_id')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label value="Kategori Pegawai" />
                        <select name="kategori_pegawai" x-model="kategori" @change="onKategoriChange()"
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                            <option value="Dosen">Dosen</option>
                            <option value="Pegawai">Pegawai</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label value="Nama Pegawai" />
                        <select x-model="pegawaiId" @change="onPegawaiChange()"
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                            <option value="">-- Pilih --</option>
                            <template x-for="p in pegawaiList" :key="p.id">
                                <option :value="p.id" x-text="p.nama"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('pegawai_id')" class="mt-1.5" />
                        <input type="hidden" name="pegawai_id" :value="pegawaiId">
                        <input type="hidden" name="pegawai_nama" :value="pegawaiNama">
                    </div>

                    <div>
                        <x-input-label value="Jabatan / Departemen" />
                        <input type="text" :value="jabatan" disabled
                               class="w-full border-gray-200 bg-gray-50 text-slate-500 rounded-lg shadow-sm text-sm">
                        <input type="hidden" name="jabatan" :value="jabatan">
                        <input type="hidden" name="departemen" :value="departemen">
                    </div>
                </div>

                <p x-show="periodeId && kategori && jabatan && items.length === 0" x-cloak
                   class="mt-4 text-sm text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-4 py-2.5">
                    Belum ada template KPI untuk jabatan "<span x-text="jabatan"></span>" pada periode ini. Silakan buat dulu di menu <strong>Input KPI</strong>.
                </p>
            </x-card>

            <!-- Tabel Nilai -->
            <x-card class="mt-6" x-show="items.length > 0" x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                                <th class="px-3 py-3 text-left rounded-l-lg w-10">No</th>
                                <th class="px-3 py-3 text-left">KPI</th>
                                <th class="px-3 py-3 text-left w-28">Target</th>
                                <th class="px-3 py-3 text-left w-32">Hasil</th>
                                <th class="px-3 py-3 text-left w-24">Nilai (%)</th>
                                <th class="px-3 py-3 text-left rounded-r-lg">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="(item, index) in items" :key="item.id">
                                <tr>
                                    <td class="px-3 py-3 text-slate-500" x-text="index + 1"></td>
                                    <td class="px-3 py-3 font-medium text-slate-700">
                                        <span x-text="item.indikator"></span>
                                        <input type="hidden" :name="'aspek[' + index + ']'" :value="item.aspek">
                                        <input type="hidden" :name="'indikator[' + index + ']'" :value="item.indikator">
                                        <input type="hidden" :name="'satuan[' + index + ']'" :value="item.satuan">
                                        <input type="hidden" :name="'target[' + index + ']'" :value="item.target">
                                        <input type="hidden" :name="'bobot[' + index + ']'" :value="item.bobot">
                                    </td>
                                    <td class="px-3 py-3 text-slate-600" x-text="item.target + ' ' + (item.satuan || '')"></td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-1.5">
                                            <input type="number" step="0.01" :name="'hasil[' + index + ']'" x-model.number="item.hasil"
                                                   class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                            <span class="text-xs text-slate-400" x-text="item.satuan"></span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="font-semibold px-2 py-1 rounded-lg text-xs"
                                              :class="persenItem(item) >= 85 ? 'bg-green-100 text-green-700' : (persenItem(item) >= 70 ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700')"
                                              x-text="persenItem(item).toFixed(2) + ' %'"></span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <input type="text" :name="'keterangan[' + index + ']'" x-model="item.keterangan"
                                               class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                                               placeholder="Catatan (opsional)">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Catatan & Total -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6" x-show="items.length > 0" x-cloak>
                <div class="lg:col-span-2">
                    <x-input-label value="Catatan Penilaian (Opsional)" />
                    <textarea name="catatan" rows="5"
                              class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                              placeholder="Tulis catatan atau komentar penilaian secara keseluruhan..."></textarea>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center text-center">
                    <p class="text-sm text-slate-500">Total Nilai Rata-rata</p>
                    <p class="text-3xl font-extrabold mt-1"
                       :class="totalNilai >= 85 ? 'text-green-600' : (totalNilai >= 70 ? 'text-blue-600' : 'text-amber-600')"
                       x-text="totalNilai.toFixed(2) + ' %'"></p>
                    <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                          :class="totalNilai >= 85 ? 'bg-green-100 text-green-700' : (totalNilai >= 70 ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700')"
                          x-text="predikat()"></span>
                </div>
            </div>

            <!-- Aksi -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-wrap items-center justify-end gap-3 mt-6">
                <a href="{{ route('kpi-nilai.index') }}">
                    <x-secondary-button type="button">
                        <x-icon name="x" class="w-4 h-4" /> Batal
                    </x-secondary-button>
                </a>
                <button type="submit" name="status" value="draft" :disabled="items.length === 0"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-blue-300 rounded-lg font-semibold text-sm text-blue-700 shadow-sm hover:bg-blue-50 disabled:opacity-40 disabled:cursor-not-allowed">
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </button>
                <button type="submit" name="status" value="final" :disabled="items.length === 0"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-blue-700 disabled:opacity-40 disabled:cursor-not-allowed">
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan & Tutup
                </button>
            </div>

        </form>
    </div>

    <script>
        function kpiNilaiForm() {
            return {
                semester: 'Genap',
                periodeId: '',
                kategori: 'Dosen',
                pegawaiId: '',
                pegawaiNama: '',
                jabatan: '',
                departemen: '',
                templateId: null,
                items: [],
                dosens: @json($dosens),
                karyawans: @json($karyawans),

                get pegawaiList() {
                    return this.kategori === 'Dosen' ? this.dosens : this.karyawans;
                },

                onKategoriChange() {
                    this.pegawaiId = '';
                    this.pegawaiNama = '';
                    this.jabatan = '';
                    this.departemen = '';
                    this.items = [];
                },

                onPegawaiChange() {
                    const list = this.pegawaiList;
                    const found = list.find(p => p.id == this.pegawaiId);
                    if (found) {
                        this.pegawaiNama = found.nama;
                        this.jabatan = found.jabatan;
                        this.departemen = this.kategori === 'Dosen' ? found.program_studi : found.departemen;
                    } else {
                        this.pegawaiNama = '';
                        this.jabatan = '';
                        this.departemen = '';
                    }
                    this.loadItems();
                },

                async loadItems() {
                    this.items = [];
                    this.templateId = null;

                    if (!this.periodeId || !this.kategori || !this.jabatan) {
                        return;
                    }

                    try {
                        const res = await fetch(`{{ route('kpi-nilai.get-template-items') }}?periode_id=${this.periodeId}&kategori_pegawai=${encodeURIComponent(this.kategori)}&jabatan=${encodeURIComponent(this.jabatan)}`);
                        const data = await res.json();
                        this.templateId = data.template_id;
                        this.items = (data.items || []).map(i => ({
                            id: i.id,
                            aspek: i.aspek,
                            indikator: i.indikator,
                            target: i.target,
                            satuan: i.satuan,
                            bobot: i.bobot,
                            hasil: 0,
                            keterangan: '',
                        }));
                    } catch (e) {
                        this.items = [];
                    }
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
                    if (!this.pegawaiId) {
                        e.preventDefault();
                        alert('Pilih nama pegawai terlebih dahulu.');
                        return;
                    }
                    if (this.items.length === 0) {
                        e.preventDefault();
                        alert('Tidak ada indikator KPI untuk dinilai.');
                    }
                }
            }
        }
    </script>

</x-app-layout>