<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Detail Nilai KPI</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $nilai->pegawai_nama }} &mdash; {{ $nilai->periode->nama_periode ?? '-' }}</p>
            </div>
            <a href="{{ route('kpi-nilai.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

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
                    <p class="text-slate-400">Penilai</p>
                    <p class="font-semibold text-slate-700">{{ $nilai->penilai ?? '-' }}</p>
                </div>
            </div>
        </x-card>

        <x-card title="Rincian Nilai KPI" icon="document-text">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-3 py-3 text-left rounded-l-lg w-10">No</th>
                            <th class="px-3 py-3 text-left">KPI</th>
                            <th class="px-3 py-3 text-left">Target</th>
                            <th class="px-3 py-3 text-left">Hasil</th>
                            <th class="px-3 py-3 text-left">Bobot</th>
                            <th class="px-3 py-3 text-left">Nilai (%)</th>
                            <th class="px-3 py-3 text-left rounded-r-lg">Keterangan</th>
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
                            <td class="px-3 py-3 text-slate-500">{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($nilai->catatan)
            <div class="mt-5 bg-slate-50 border border-slate-100 rounded-xl px-4 py-3">
                <p class="text-xs text-slate-400 mb-1">Catatan Penilaian</p>
                <p class="text-sm text-slate-600">{{ $nilai->catatan }}</p>
            </div>
            @endif
        </x-card>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center text-center max-w-sm mx-auto">
            <p class="text-sm text-slate-500">Total Nilai Rata-rata</p>
            <p class="text-4xl font-extrabold mt-1 {{ $nilai->total_nilai >= 85 ? 'text-green-600' : ($nilai->total_nilai >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                {{ $nilai->total_nilai !== null ? number_format($nilai->total_nilai, 2) . '%' : '-' }}
            </p>
            <x-badge :color="match($nilai->predikat) { 'Sangat Baik' => 'green', 'Baik' => 'blue', 'Perlu Perbaikan' => 'amber', default => 'gray' }" class="mt-2">
                {{ $nilai->predikat }}
            </x-badge>
        </div>

    </div>

</x-app-layout>