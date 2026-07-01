<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">KPI Saya</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Riwayat penilaian KPI atas nama <strong>{{ Auth::user()->name }}</strong>.
                </p>
            </div>
            @if(Auth::user()->role == 'karyawan')
            <a href="{{ route('kpi-saya.input') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition">
                <x-icon name="plus" class="w-4 h-4" /> Input Realisasi
            </a>
            @endif
        </div>
    </x-slot>

    <div class="space-y-6">

        @if($nilais->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-stat-card label="Total Penilaian" :value="$nilais->count()" icon="clipboard-check" color="blue" />
            <x-stat-card label="Nilai Tertinggi" :value="number_format($nilais->max('total_nilai'), 2) . '%'" icon="arrow-up" color="green" />
            <x-stat-card label="Rata-rata Nilai" :value="number_format($nilais->avg('total_nilai'), 2) . '%'" icon="star" color="purple" />
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ q: '' }">

            <div class="relative mb-5 max-w-sm">
                <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                <input type="text" x-model="q" placeholder="Cari periode..."
                       class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                            <th class="px-4 py-3 text-left">Periode</th>
                            <th class="px-4 py-3 text-left">Jabatan</th>
                            <th class="px-4 py-3 text-left">Total Nilai</th>
                            <th class="px-4 py-3 text-left">Predikat</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right rounded-r-lg">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse($nilais as $nilai)
                        <tr x-show="!q || $el.innerText.toLowerCase().includes(q.toLowerCase())" class="hover:bg-blue-50/40">
                            <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $nilai->periode->nama_periode ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $nilai->jabatan ?? '-' }}</td>
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
                                @php
                                    $statusColor = match($nilai->status) {
                                        'final' => 'green',
                                        'Menunggu Verifikasi' => 'amber',
                                        default => 'gray',
                                    };
                                @endphp
                                <x-badge :color="$statusColor">{{ $nilai->status }}</x-badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('kpi-saya.show', $nilai->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50">
                                    <x-icon name="document-text" class="w-4 h-4" />
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon name="clipboard-check" class="w-10 h-10 text-slate-300" />
                                    <p class="text-slate-400 text-sm">
                                        @if(Auth::user()->role == 'karyawan')
                                            Belum ada penilaian KPI. Klik <strong>Input Realisasi</strong> untuk mulai mengisi.
                                        @else
                                            Belum ada penilaian KPI untuk nama Anda. Hubungi admin untuk info lebih lanjut.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-app-layout>