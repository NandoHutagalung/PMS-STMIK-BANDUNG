<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tinjau Template KPI</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $template->jabatan }} &mdash; {{ $template->periode->nama_periode ?? '-' }}</p>
            </div>
            <a href="{{ route('kpi-approval.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div x-data="{ showTolak: false }" class="space-y-6">

        <x-card title="Informasi Template" icon="presentation">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-sm">
                <div>
                    <p class="text-slate-400 mb-0.5">Kategori</p>
                    <p class="font-semibold text-slate-700">{{ $template->kategori_pegawai }}</p>
                </div>
                <div>
                    <p class="text-slate-400 mb-0.5">Unit Kerja</p>
                    <p class="font-semibold text-slate-700">{{ $template->unit_kerja }}</p>
                </div>
                <div>
                    <p class="text-slate-400 mb-0.5">Jabatan</p>
                    <p class="font-semibold text-slate-700">{{ $template->jabatan }}</p>
                </div>
                <div>
                    <p class="text-slate-400 mb-0.5">Semester</p>
                    <p class="font-semibold text-slate-700">{{ $template->semester ?? '-' }}</p>
                </div>
            </div>
        </x-card>

        <x-card title="Daftar Indikator KPI" icon="clipboard-check">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-3 py-3 text-left rounded-l-lg w-10">No</th>
                            <th class="px-3 py-3 text-left">Aspek</th>
                            <th class="px-3 py-3 text-left">Indikator</th>
                            <th class="px-3 py-3 text-left">Target</th>
                            <th class="px-3 py-3 text-left">Satuan</th>
                            <th class="px-3 py-3 text-left rounded-r-lg">Bobot</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($template->items as $item)
                        <tr>
                            <td class="px-3 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->aspek }}</td>
                            <td class="px-3 py-3 font-medium text-slate-700">{{ $item->indikator }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->target }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->satuan }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->bobot }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @php $totalBobot = $template->items->sum('bobot'); @endphp
            <div class="mt-5 flex items-center justify-between bg-blue-50 rounded-xl px-5 py-4 border border-blue-100">
                <p class="text-sm font-semibold text-slate-700">Total Bobot</p>
                <span class="text-lg font-bold {{ $totalBobot == 100 ? 'text-green-600' : 'text-amber-600' }}">
                    {{ $totalBobot }} / 100
                </span>
            </div>

            @if($totalBobot != 100)
            <div class="mt-3 bg-amber-50 border border-amber-200 rounded-lg px-4 py-2.5 text-sm text-amber-700">
                Perhatian: total bobot bukan 100%. Sebaiknya jangan disetujui sebelum diperbaiki oleh pengaju.
            </div>
            @endif
        </x-card>

        <!-- Aksi -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div x-show="!showTolak" class="flex flex-wrap items-center justify-end gap-3">
                <button type="button" @click="showTolak = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-red-300 rounded-lg font-semibold text-sm text-red-600 shadow-sm hover:bg-red-50">
                    <x-icon name="x" class="w-4 h-4" /> Tolak
                </button>

                <form action="{{ route('kpi-approval.approve', $template->id) }}" method="POST"
                      onsubmit="return confirm('Setujui template KPI ini? Setelah disetujui, status akan menjadi Aktif.');">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-green-700">
                        <x-icon name="check-circle" class="w-4 h-4" /> Setujui
                    </button>
                </form>
            </div>

            <form x-show="showTolak" x-cloak action="{{ route('kpi-approval.reject', $template->id) }}" method="POST" class="space-y-3">
                @csrf
                <x-input-label for="catatan_approval" value="Alasan Penolakan" />
                <textarea id="catatan_approval" name="catatan_approval" rows="3" required
                          class="w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm text-sm"
                          placeholder="Jelaskan alasan penolakan supaya pengaju bisa memperbaiki...">{{ old('catatan_approval') }}</textarea>
                <x-input-error :messages="$errors->get('catatan_approval')" class="mt-1" />

                <div class="flex items-center justify-end gap-3 pt-1">
                    <button type="button" @click="showTolak = false" class="text-sm font-semibold text-slate-500 hover:text-slate-700">
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-red-700">
                        <x-icon name="x" class="w-4 h-4" /> Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>

    </div>

</x-app-layout>