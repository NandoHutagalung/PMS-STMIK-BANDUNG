<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Detail KPI Saya</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $nilai->periode->nama_periode ?? '-' }}</p>
            </div>
            <a href="{{ route('kpi-saya.index') }}"
               class="text-sm font-semibold text-slate-500 hover:text-slate-700">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <x-card title="Informasi Penilaian" icon="user-circle">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-sm">
                <div>
                    <p class="text-slate-400 mb-0.5">Nama</p>
                    <p class="font-semibold text-slate-700">{{ $nilai->pegawai_nama }}</p>
                </div>
                <div>
                    <p class="text-slate-400 mb-0.5">Jabatan</p>
                    <p class="font-semibold text-slate-700">{{ $nilai->jabatan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-400 mb-0.5">Departemen</p>
                    <p class="font-semibold text-slate-700">{{ $nilai->departemen ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-400 mb-0.5">Penilai / Verifikator</p>
                    <p class="font-semibold text-slate-700">{{ $nilai->penilai ?? 'Belum diverifikasi' }}</p>
                </div>
            </div>

            <div class="mt-4 flex items-center gap-3">
                @php
                    $statusColor = match($nilai->status) {
                        'final' => 'green',
                        'Menunggu Verifikasi' => 'amber',
                        default => 'gray',
                    };
                @endphp
                <span class="text-sm text-slate-500">Status:</span>
                <x-badge :color="$statusColor">{{ $nilai->status }}</x-badge>
                @if($nilai->status === 'Menunggu Verifikasi')
                    <span class="text-xs text-amber-600">Data sudah diterima sistem, menunggu verifikasi dari admin.</span>
                @endif
            </div>
        </x-card>

        <x-card title="Rincian Nilai Per Indikator KPI" icon="clipboard-check">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-3 py-3 text-left rounded-l-lg w-10">No</th>
                            <th class="px-3 py-3 text-left">Aspek</th>
                            <th class="px-3 py-3 text-left">Indikator KPI</th>
                            <th class="px-3 py-3 text-left w-28">Target</th>
                            <th class="px-3 py-3 text-left w-28">Realisasi</th>
                            <th class="px-3 py-3 text-left w-20">Bobot</th>
                            <th class="px-3 py-3 text-left w-24">Nilai (%)</th>
                            <th class="px-3 py-3 text-left rounded-r-lg">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($nilai->items as $item)
                        <tr class="hover:bg-blue-50/30">
                            <td class="px-3 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-3 py-3 text-slate-500">{{ $item->aspek ?? '-' }}</td>
                            <td class="px-3 py-3 font-medium text-slate-700">{{ $item->indikator }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->target }} {{ $item->satuan }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->hasil }} {{ $item->satuan }}</td>
                            <td class="px-3 py-3 text-slate-600">{{ $item->bobot }}%</td>
                            <td class="px-3 py-3">
                                <span class="font-bold {{ $item->nilai_persen >= 85 ? 'text-green-600' : ($item->nilai_persen >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
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
                <p class="text-xs text-slate-400 mb-1">Catatan</p>
                <p class="text-sm text-slate-600">{{ $nilai->catatan }}</p>
            </div>
            @endif
        </x-card>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center text-center max-w-sm mx-auto">
            <p class="text-sm text-slate-500">Total Nilai Akhir</p>
            <p class="text-4xl font-extrabold mt-2 {{ $nilai->total_nilai >= 85 ? 'text-green-600' : ($nilai->total_nilai >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                {{ $nilai->total_nilai !== null ? number_format($nilai->total_nilai, 2) . '%' : '-' }}
            </p>
            <x-badge :color="match($nilai->predikat) { 'Sangat Baik' => 'green', 'Baik' => 'blue', 'Perlu Perbaikan' => 'amber', default => 'gray' }" class="mt-3">
                {{ $nilai->predikat }}
            </x-badge>
        </div>

    </div>

</x-app-layout>