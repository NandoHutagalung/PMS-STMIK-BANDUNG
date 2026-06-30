<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Penilaian KPI</h2>
                <p class="text-sm text-slate-500 mt-1">Daftar nilai pencapaian KPI dosen dan pegawai.</p>
            </div>
            <a href="{{ route('kpi-nilai.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition">
                <x-icon name="plus" class="w-4 h-4" /> Input Nilai
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ q: '' }">

        <div class="relative mb-5 max-w-sm">
            <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
            <input type="text" x-model="q" placeholder="Cari nama pegawai..."
                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Total Nilai</th>
                        <th class="px-4 py-3 text-left">Predikat</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse($nilais as $nilai)
                    <tr x-show="!q || $el.innerText.toLowerCase().includes(q.toLowerCase())" class="hover:bg-blue-50/40">
                        <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $nilai->periode->nama_periode ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $nilai->kategori_pegawai }}</td>
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $nilai->pegawai_nama }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $nilai->jabatan }}</td>
                        <td class="px-4 py-3">
                            <span class="font-semibold {{ $nilai->total_nilai >= 85 ? 'text-green-600' : ($nilai->total_nilai >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                                {{ $nilai->total_nilai !== null ? number_format($nilai->total_nilai, 2) . '%' : '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $predikatColor = match($nilai->predikat) {
                                    'Sangat Baik' => 'green',
                                    'Baik' => 'blue',
                                    'Perlu Perbaikan' => 'amber',
                                    default => 'gray',
                                };
                            @endphp
                            <x-badge :color="$predikatColor">{{ $nilai->predikat }}</x-badge>
                        </td>
                        <td class="px-4 py-3">
                            <x-badge :color="$nilai->status == 'final' ? 'green' : 'gray'" class="capitalize">
                                {{ $nilai->status }}
                            </x-badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('kpi-nilai.show', $nilai->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50">
                                    <x-icon name="document-text" class="w-4 h-4" />
                                </a>
                                <a href="{{ route('kpi-nilai.edit', $nilai->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>
                                <form action="{{ route('kpi-nilai.destroy', $nilai->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data nilai KPI ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-red-200 text-red-600 hover:bg-red-50">
                                        <x-icon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-slate-400">Belum ada data nilai KPI.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>