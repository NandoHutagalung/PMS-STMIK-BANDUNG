<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Verifikasi Nilai KPI</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $nilai->pegawai_nama }} &mdash; {{ $nilai->periode->nama_periode ?? '-' }}</p>
            </div>
            <a href="{{ route('kpi-approval.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">&larr; Kembali</a>
        </div>
    </x-slot>

    <div x-data="{ showTolak: false }" class="space-y-6">

        <x-card title="Informasi Pegawai" icon="user-circle">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-sm">
                <div><p class="text-slate-400 mb-0.5">Nama</p><p class="font-semibold text-slate-700">{{ $nilai->pegawai_nama }}</p></div>
                <div><p class="text-slate-400 mb-0.5">Kategori</p><p class="font-semibold text-slate-700">{{ $nilai->kategori_pegawai }}</p></div>
                <div><p class="text-slate-400 mb-0.5">Jabatan</p><p class="font-semibold text-slate-700">{{ $nilai->jabatan ?? '-' }}</p></div>
                <div><p class="text-slate-400 mb-0.5">Departemen</p><p class="font-semibold text-slate-700">{{ $nilai->departemen ?? '-' }}</p></div>
            </div>
        </x-card>

        <x-card title="Rincian Nilai" icon="clipboard-check">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-3 py-3 text-left rounded-l-lg w-10">No</th>
                            <th class="px-3 py-3 text-left">Indikator</th>
                            <th class="px-3 py-3 text-left">Target</th>
                            <th class="px-3 py-3 text-left">Hasil</th>
                            <th class="px-3 py-3 text-left">Bobot</th>
                            <th class="px-3 py-3 text-left rounded-r-lg">Nilai (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($nilai->items as $item)
                        <tr>
                            <td class="px-3 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-3 py-3 font-medium text-slate-700">{{ $item->indikator }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->target }} {{ $item->satuan }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->hasil }} {{ $item->satuan }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->bobot }}%</td>
                            <td class="px-3 py-3">
                                <span class="font-semibold {{ $item->nilai_persen >= 85 ? 'text-green-600' : ($item->nilai_persen >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                                    {{ number_format($item->nilai_persen, 2) }}%
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($nilai->catatan)
            <div class="mt-4 bg-slate-50 border border-slate-100 rounded-xl px-4 py-3">
                <p class="text-xs text-slate-400 mb-1">Catatan dari Pegawai</p>
                <p class="text-sm text-slate-600">{{ $nilai->catatan }}</p>
            </div>
            @endif
        </x-card>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center text-center max-w-sm mx-auto">
            <p class="text-sm text-slate-500">Total Nilai</p>
            <p class="text-4xl font-extrabold mt-1 {{ $nilai->total_nilai >= 85 ? 'text-green-600' : ($nilai->total_nilai >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                {{ number_format($nilai->total_nilai, 2) }}%
            </p>
            <x-badge :color="$nilai->predikat == 'Sangat Baik' ? 'green' : ($nilai->predikat == 'Baik' ? 'blue' : 'amber')" class="mt-2">
                {{ $nilai->predikat }}
            </x-badge>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div x-show="!showTolak" class="flex flex-wrap items-center justify-end gap-3">
                <button type="button" @click="showTolak = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-red-300 rounded-lg font-semibold text-sm text-red-600 shadow-sm hover:bg-red-50">
                    <x-icon name="x" class="w-4 h-4" /> Tolak
                </button>
                <form action="{{ route('kpi-approval.approve-nilai', $nilai->id) }}" method="POST"
                      onsubmit="return confirm('Verifikasi nilai ini sebagai final?');">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-green-700">
                        <x-icon name="check-circle" class="w-4 h-4" /> Verifikasi
                    </button>
                </form>
            </div>

            <form x-show="showTolak" x-cloak action="{{ route('kpi-approval.reject-nilai', $nilai->id) }}" method="POST" class="space-y-3">
                @csrf
                <x-input-label for="catatan_approval" value="Alasan Penolakan" />
                <textarea id="catatan_approval" name="catatan_approval" rows="3" required
                          class="w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm text-sm"
                          placeholder="Jelaskan alasan penolakan supaya pegawai bisa merevisi..."></textarea>
                <x-input-error :messages="$errors->get('catatan_approval')" class="mt-1" />
                <div class="flex items-center justify-end gap-3 pt-1">
                    <button type="button" @click="showTolak = false" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-red-700">
                        <x-icon name="x" class="w-4 h-4" /> Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>

    </div>

</x-app-layout>