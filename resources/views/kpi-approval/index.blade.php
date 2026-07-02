<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Approval KPI</h2>
        <p class="text-sm text-slate-500 mt-1">Satu tempat untuk menyetujui Template KPI dan memverifikasi Nilai KPI (realisasi).</p>
    </x-slot>

    <div class="space-y-6">

        <!-- Template KPI Menunggu -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-5">
                <x-icon name="clipboard-check" class="w-5 h-5 text-amber-600" />
                <div>
                    <h3 class="text-base font-bold text-slate-800">Template KPI Menunggu Persetujuan</h3>
                    <p class="text-xs text-slate-400">Daftar indikator KPI baru yang diajukan.</p>
                </div>
                <span class="ml-auto inline-flex items-center justify-center min-w-[24px] h-6 px-2 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                    {{ $templateMenunggu->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-amber-50 text-amber-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                            <th class="px-4 py-3 text-left">Periode</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-left">Jabatan</th>
                            <th class="px-4 py-3 text-left">Total Bobot</th>
                            <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($templateMenunggu as $t)
                        <tr class="hover:bg-amber-50/40">
                            <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $t->periode->nama_periode ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $t->kategori_pegawai }}</td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $t->jabatan }}</td>
                            <td class="px-4 py-3">
                                @php $tb = $t->items->sum('bobot'); @endphp
                                <span class="font-semibold {{ $tb == 100 ? 'text-green-600' : 'text-amber-600' }}">{{ $tb }}%</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('kpi-approval.show', $t->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold">
                                    <x-icon name="document-text" class="w-3.5 h-3.5" /> Tinjau
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-slate-400">Tidak ada template menunggu persetujuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Nilai KPI Menunggu -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-5">
                <x-icon name="star" class="w-5 h-5 text-amber-600" />
                <div>
                    <h3 class="text-base font-bold text-slate-800">Nilai KPI Menunggu Verifikasi</h3>
                    <p class="text-xs text-slate-400">Realisasi yang diisi dosen/pegawai, menunggu diverifikasi.</p>
                </div>
                <span class="ml-auto inline-flex items-center justify-center min-w-[24px] h-6 px-2 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                    {{ $nilaiMenunggu->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-amber-50 text-amber-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                            <th class="px-4 py-3 text-left">Periode</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Total Nilai</th>
                            <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($nilaiMenunggu as $n)
                        <tr class="hover:bg-amber-50/40">
                            <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $n->periode->nama_periode ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $n->kategori_pegawai }}</td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $n->pegawai_nama }}</td>
                            <td class="px-4 py-3">
                                <span class="font-semibold {{ $n->total_nilai >= 85 ? 'text-green-600' : ($n->total_nilai >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                                    {{ number_format($n->total_nilai, 2) }}%
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('kpi-approval.show-nilai', $n->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold">
                                    <x-icon name="document-text" class="w-3.5 h-3.5" /> Tinjau
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-slate-400">Tidak ada nilai yang menunggu verifikasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ tab: 'template' }">
            <div class="flex items-center gap-2 mb-5">
                <x-icon name="document-text" class="w-5 h-5 text-blue-600" />
                <h3 class="text-base font-bold text-slate-800">Riwayat Approval Terbaru</h3>
                <div class="ml-auto flex gap-2">
                    <button type="button" @click="tab = 'template'"
                            :class="tab === 'template' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-slate-600'"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold">Template KPI</button>
                    <button type="button" @click="tab = 'nilai'"
                            :class="tab === 'nilai' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-slate-600'"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold">Nilai KPI</button>
                </div>
            </div>

            <div x-show="tab === 'template'" class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">Jabatan</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Oleh</th>
                            <th class="px-4 py-3 text-left rounded-r-lg">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($riwayatTemplate as $r)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $r->jabatan }}</td>
                            <td class="px-4 py-3"><x-badge :color="$r->status == 'aktif' ? 'green' : 'red'" class="capitalize">{{ $r->status }}</x-badge></td>
                            <td class="px-4 py-3 text-slate-600">{{ $r->disetujui_oleh ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $r->disetujui_at ? \Carbon\Carbon::parse($r->disetujui_at)->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada riwayat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'nilai'" x-cloak class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">Nama</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Oleh</th>
                            <th class="px-4 py-3 text-left rounded-r-lg">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($riwayatNilai as $r)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $r->pegawai_nama }}</td>
                            <td class="px-4 py-3"><x-badge :color="$r->status == 'final' ? 'green' : 'red'">{{ $r->status }}</x-badge></td>
                            <td class="px-4 py-3 text-slate-600">{{ $r->penilai ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $r->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada riwayat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-app-layout>