<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Monitoring Kinerja</h2>
        <p class="text-sm text-slate-500 mt-1">Pantau ringkasan kinerja dosen dan karyawan.</p>
    </x-slot>

    <div class="space-y-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <x-stat-card label="Total Dosen" :value="$totalDosen" icon="academic-cap" color="blue" />
            <x-stat-card label="Total Karyawan" :value="$totalKaryawan" icon="briefcase" color="green" />
            <x-stat-card label="Total Evaluasi" :value="$totalEvaluasi" icon="clipboard-check" color="purple" />
            <x-stat-card label="Total Capaian" :value="$totalCapaian" icon="flag" color="amber" />
            <x-stat-card label="Total Feedback" :value="$totalFeedback" icon="chat" color="red" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <x-card title="5 Nilai Kinerja Terbaik" icon="arrow-up">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">Pegawai</th>
                            <th class="px-4 py-3 text-left rounded-r-lg">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($evaluasiTerbaik as $item)
                        <tr class="hover:bg-blue-50/40">
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $item->nama_pegawai }}</td>
                            <td class="px-4 py-3 font-semibold text-green-600">{{ $item->nilai }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="px-4 py-6 text-center text-slate-400">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </x-card>

            <x-card title="5 Nilai Kinerja Terendah" icon="arrow-down">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">Pegawai</th>
                            <th class="px-4 py-3 text-left rounded-r-lg">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($evaluasiTerendah as $item)
                        <tr class="hover:bg-blue-50/40">
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $item->nama_pegawai }}</td>
                            <td class="px-4 py-3 font-semibold text-red-600">{{ $item->nilai }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="px-4 py-6 text-center text-slate-400">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </x-card>

        </div>
    </div>

</x-app-layout>