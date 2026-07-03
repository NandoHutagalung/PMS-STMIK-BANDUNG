<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit KPI Dosen / Pegawai</h2>
        <p class="text-sm text-slate-500 mt-1">Perbarui data KPI dan target yang diharapkan.</p>
    </x-slot>

    <div x-data="kpiTemplateForm()" x-init="if (rows.length === 0) addRow()" class="space-y-6">

        <form action="{{ route('kpi-template.update', $template->id) }}" method="POST" @submit="beforeSubmit">
            @csrf
            @method('PUT')

            <!-- Info Umum -->
            <x-card title="Form Input KPI" subtitle="Tentukan kategori, unit kerja, jabatan, dan periode." icon="presentation">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                    <x-input-label value="Kategori" />
                    <div class="w-full border border-gray-200 bg-gray-50 rounded-lg shadow-sm text-sm px-3 py-2.5 font-semibold text-slate-600">
                        {{ $template->kategori_pegawai }}
                    </div>
                    <input type="hidden" name="kategori_pegawai" value="{{ $template->kategori_pegawai }}">
                </div>

                <div>
                    <x-input-label for="pegawai_nama" value="Nama yang Akan Dinilai" />
                    <select id="pegawai_nama" name="pegawai_nama"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        <option value="">-- Semua {{ $template->kategori_pegawai }} dengan Jabatan ini --</option>
                        @foreach($daftarNama as $nama)
                            <option value="{{ $nama }}" {{ old('pegawai_nama', $template->pegawai_nama) == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400 mt-1">Kosongkan jika KPI ini berlaku untuk semua dengan jabatan yang sama.</p>
                </div>

                    <div>
                        <x-input-label for="unit_kerja" value="Unit Kerja" />
                        <x-text-input id="unit_kerja" name="unit_kerja" type="text" class="w-full" value="{{ old('unit_kerja', $template->unit_kerja) }}" />
                        <x-input-error :messages="$errors->get('unit_kerja')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="jabatan" value="Jabatan" />
                        <x-text-input id="jabatan" name="jabatan" type="text" class="w-full" value="{{ old('jabatan', $template->jabatan) }}" />
                        <x-input-error :messages="$errors->get('jabatan')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="semester" value="Semester" />
                        <select id="semester" name="semester"
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                            <option value="Ganjil" {{ $template->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ $template->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="periode_id" value="Tahun Akademik / Periode" />
                        <select id="periode_id" name="periode_id"
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->id }}" {{ $template->periode_id == $periode->id ? 'selected' : '' }}>
                                    {{ $periode->nama_periode }} ({{ $periode->tahun }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('periode_id')" class="mt-1.5" />
                    </div>
                </div>
            </x-card>

            <!-- Daftar KPI -->
            <x-card class="mt-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <x-icon name="check-circle" class="w-5 h-5 text-blue-600" />
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Daftar KPI</h3>
                            <p class="text-xs text-slate-400">Tambahkan KPI yang relevan dengan tugas dan tanggung jawab.</p>
                        </div>
                    </div>
                    <button type="button" @click="addRow()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700">
                        <x-icon name="plus" class="w-4 h-4" /> Tambah KPI
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                                <th class="px-3 py-3 text-left rounded-l-lg w-10">No</th>
                                <th class="px-3 py-3 text-left">Aspek KPI</th>
                                <th class="px-3 py-3 text-left">Indikator KPI</th>
                                <th class="px-3 py-3 text-left">Deskripsi</th>
                                <th class="px-3 py-3 text-left w-24">Target</th>
                                <th class="px-3 py-3 text-left w-28">Satuan</th>
                                <th class="px-3 py-3 text-left w-24">Bobot (%)</th>
                                <th class="px-3 py-3 text-right rounded-r-lg w-12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="(row, index) in rows" :key="row.key">
                                <tr>
                                    <td class="px-3 py-2 text-slate-500" x-text="index + 1"></td>
                                    <td class="px-3 py-2">
                                      <input type="text" :name="'aspek[' + index + ']'" x-model="row.aspek" list="daftarAspek"
       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
       placeholder="Kinerja Utama">
                                    </td>
                                    <td class="px-3 py-2">
                                       <input type="text" :name="'indikator[' + index + ']'" x-model="row.indikator" list="daftarIndikator"
       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
       placeholder="Melaporkan data semesteran">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="text" :name="'deskripsi[' + index + ']'" x-model="row.deskripsi"
                                               class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="number" step="0.01" :name="'target[' + index + ']'" x-model.number="row.target"
                                               class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="text" :name="'satuan[' + index + ']'" x-model="row.satuan"
                                               class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                    </td>
                                    <td class="px-3 py-2">
                                       <input type="number" step="0.01" :name="'bobot[' + index + ']'" x-model.number="row.bobot" list="daftarBobot"
       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        <button type="button" @click="removeRow(index)"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-red-200 text-red-600 hover:bg-red-50">
                                            <x-icon name="trash" class="w-4 h-4" />
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="mt-5 flex items-center justify-between bg-blue-50 rounded-xl px-5 py-4 border border-blue-100">
                    <div class="flex items-center gap-2">
                        <x-icon name="target" class="w-5 h-5 text-blue-600" />
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Total Bobot KPI</p>
                            <p class="text-xs text-slate-400">Jumlah bobot seluruh KPI sebaiknya 100%.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-500">Total Bobot</span>
                        <span class="text-lg font-bold" :class="totalBobot == 100 ? 'text-green-600' : 'text-amber-600'" x-text="totalBobot + ' / 100'"></span>
                    </div>
                </div>
            </x-card>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-wrap items-center justify-between gap-3">
                <p class="text-xs text-slate-400">Perubahan akan menggantikan seluruh daftar indikator KPI sebelumnya.</p>
                <div class="flex items-center gap-3">
                    <a href="{{ route('kpi-template.index') }}">
                        <x-secondary-button type="button">Batal</x-secondary-button>
                    </a>
                    <button type="submit" name="status" value="draft"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-blue-300 rounded-lg font-semibold text-sm text-blue-700 shadow-sm hover:bg-blue-50">
                        Simpan sebagai Draft
                    </button>
                    <button type="submit" name="status" value="diajukan"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-blue-700">
                        <x-icon name="check-circle" class="w-4 h-4" /> Update
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script>
        function kpiTemplateForm() {
            return {
                rows: @json($template->items->map(function ($i) {
                    return [
                        'key' => $i->id,
                        'aspek' => $i->aspek,
                        'indikator' => $i->indikator,
                        'deskripsi' => $i->deskripsi,
                        'target' => $i->target,
                        'satuan' => $i->satuan,
                        'bobot' => $i->bobot,
                    ];
                })),
                addRow() {
                    this.rows.push({ key: Date.now() + Math.random(), aspek: '', indikator: '', deskripsi: '', target: 0, satuan: '', bobot: 0 });
                },
                removeRow(index) {
                    if (this.rows.length === 1) return;
                    this.rows.splice(index, 1);
                },
                get totalBobot() {
                    return this.rows.reduce((sum, r) => sum + (parseFloat(r.bobot) || 0), 0);
                },
                beforeSubmit(e) {
                    if (this.rows.length === 0) {
                        e.preventDefault();
                        alert('Tambahkan minimal 1 KPI.');
                    }
                }
            }
        }
    </script>

<datalist id="daftarAspek">
        @foreach($daftarAspek as $a)
        <option value="{{ $a }}">
        @endforeach
    </datalist>
    <datalist id="daftarIndikator">
        @foreach($daftarIndikator as $i)
        <option value="{{ $i }}">
        @endforeach
    </datalist>
    <datalist id="daftarBobot">
        @foreach($daftarBobot as $b)
        <option value="{{ $b }}">
        @endforeach
    </datalist>

</x-app-layout>

</x-app-layout>