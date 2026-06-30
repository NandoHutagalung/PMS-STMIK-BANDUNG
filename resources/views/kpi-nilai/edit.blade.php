<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Nilai KPI</h2>
        <p class="text-sm text-slate-500 mt-1">{{ $nilai->pegawai_nama }} &mdash; Perbarui hasil pencapaian KPI.</p>
    </x-slot>

    <div x-data="kpiNilaiEditForm()" class="space-y-6">

        <form action="{{ route('kpi-nilai.update', $nilai->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-card title="Informasi Pegawai" icon="user-circle">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-sm">
                    <div>
                        <p class="text-slate-400">Nama</p>
                        <p class="font-semibold text-slate-700">{{ $nilai->pegawai_nama }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Kategori</p>
                        <p class="font-semibold text-slate-700">{{ $nilai->kategori_pegawai }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Jabatan / Departemen</p>
                        <p class="font-semibold text-slate-700">{{ $nilai->jabatan }} @if($nilai->departemen) &mdash; {{ $nilai->departemen }} @endif</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Periode</p>
                        <p class="font-semibold text-slate-700">{{ $nilai->periode->nama_periode ?? '-' }}</p>
                    </div>
                </div>
            </x-card>

            <x-card class="mt-6" title="Rincian Nilai KPI" icon="document-text">
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
                                    <td class="px-3 py-3 font-medium text-slate-700" x-text="item.indikator"></td>
                                    <td class="px-3 py-3 text-slate-600" x-text="item.target + ' ' + (item.satuan || '')"></td>
                                    <td class="px-3 py-3">
                                        <input type="number" step="0.01" :name="'hasil[' + index + ']'" x-model.number="item.hasil"
                                               class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="font-semibold px-2 py-1 rounded-lg text-xs"
                                              :class="persenItem(item) >= 85 ? 'bg-green-100 text-green-700' : (persenItem(item) >= 70 ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700')"
                                              x-text="persenItem(item).toFixed(2) + ' %'"></span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <input type="text" :name="'keterangan[' + index + ']'" x-model="item.keterangan"
                                               class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </x-card>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <div class="lg:col-span-2">
                    <x-input-label value="Catatan Penilaian (Opsional)" />
                    <textarea name="catatan" rows="5"
                              class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ $nilai->catatan }}</textarea>
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

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-wrap items-center justify-end gap-3 mt-6">
                <a href="{{ route('kpi-nilai.index') }}">
                    <x-secondary-button type="button">
                        <x-icon name="x" class="w-4 h-4" /> Batal
                    </x-secondary-button>
                </a>
                <button type="submit" name="status" value="draft"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-blue-300 rounded-lg font-semibold text-sm text-blue-700 shadow-sm hover:bg-blue-50">
                    Simpan sebagai Draft
                </button>
                <button type="submit" name="status" value="final"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-blue-700">
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan & Tutup
                </button>
            </div>

        </form>
    </div>

    <script>
        function kpiNilaiEditForm() {
            return {
                items: @json($nilai->items->map(function ($i) {
                    return [
                        'id' => $i->id,
                        'indikator' => $i->indikator,
                        'target' => $i->target,
                        'satuan' => $i->satuan,
                        'bobot' => $i->bobot,
                        'hasil' => $i->hasil,
                        'keterangan' => $i->keterangan,
                    ];
                })),

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
            }
        }
    </script>

</x-app-layout>