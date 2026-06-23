<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Laporan Kinerja</h2>
                <p class="text-sm text-slate-500 mt-1">Ringkasan dan rekap evaluasi kinerja pegawai.</p>
            </div>
            <a href="{{ route('laporan.pdf') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-red-700 transition">
                <x-icon name="document-text" class="w-4 h-4" /> Cetak PDF
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Ringkasan -->
        <x-card title="Ringkasan Kinerja" icon="presentation">
            <p class="text-sm text-slate-500 mb-5">
                Nilai Rata-rata Kinerja: <strong class="text-slate-800">{{ number_format($rataRata, 2) }}</strong>
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-stat-card label="Total Evaluasi" :value="$evaluasis->count()" icon="clipboard-check" color="blue" />
                <x-stat-card label="Nilai Tertinggi" :value="$evaluasis->max('nilai') ?? '-'" icon="arrow-up" color="green" />
                <x-stat-card label="Nilai Terendah" :value="$evaluasis->min('nilai') ?? '-'" icon="arrow-down" color="red" />
            </div>
        </x-card>

        <!-- Rekap -->
        <x-card title="Rekap Evaluasi" icon="document-text">

            <form method="GET" class="mb-5 flex flex-wrap gap-3 items-center">
                <select name="periode_id" onchange="this.form.submit()"
                        class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                    <option value="">Semua Periode</option>
                    @foreach($periodes as $periode)
                        <option value="{{ $periode->id }}" {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                            {{ $periode->nama_periode }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700">
                    <x-icon name="search" class="w-4 h-4" /> Filter
                </button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                            <th class="px-4 py-3 text-left">Periode</th>
                            <th class="px-4 py-3 text-left">Pegawai</th>
                            <th class="px-4 py-3 text-left">Nilai</th>
                            <th class="px-4 py-3 text-left rounded-r-lg">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($evaluasis as $evaluasi)
                        <tr class="hover:bg-blue-50/40">
                            <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $evaluasi->periode->nama_periode ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $evaluasi->nama_pegawai }}</td>
                            <td class="px-4 py-3 font-semibold {{ $evaluasi->nilai >= 85 ? 'text-green-600' : ($evaluasi->nilai >= 70 ? 'text-blue-600' : 'text-red-600') }}">
                                {{ $evaluasi->nilai }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $evaluasi->catatan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada data evaluasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <!-- Grafik -->
        <x-card title="Grafik Nilai Kinerja Pegawai" icon="presentation">
            <div style="height:350px;">
                <canvas id="chartKinerja"></canvas>
            </div>
        </x-card>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartKinerja');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($evaluasis as $evaluasi)
                        "{{ $evaluasi->nama_pegawai }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Nilai Kinerja',
                    data: [
                        @foreach($evaluasis as $evaluasi)
                            {{ $evaluasi->nilai }},
                        @endforeach
                    ],
                    backgroundColor: '#2563eb',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });
    </script>

</x-app-layout>