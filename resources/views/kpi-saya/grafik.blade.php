<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Grafik Kinerja</h2>
        <p class="text-sm text-slate-500 mt-1">Tren nilai KPI kamu dari waktu ke waktu (hanya penilaian yang sudah final).</p>
    </x-slot>

    <div class="space-y-6">

        @if($riwayat->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">
            <x-icon name="presentation" class="w-10 h-10 text-slate-300 mx-auto mb-3" />
            <p class="text-slate-400 text-sm">Belum ada penilaian KPI final untuk ditampilkan grafiknya.</p>
        </div>
        @else

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-stat-card label="Rata-rata Nilai" :value="number_format($rataRata, 2) . '%'" icon="star" color="blue" />
            <x-stat-card label="Nilai Tertinggi" :value="number_format($tertinggi, 2) . '%'" icon="arrow-up" color="green" />
            <x-stat-card label="Nilai Terendah" :value="number_format($terendah, 2) . '%'" icon="arrow-down" color="amber" />
        </div>

        <x-card title="Tren Nilai Per Periode" icon="presentation">
            <div style="height:300px;">
                <canvas id="chartTren"></canvas>
            </div>
        </x-card>

        @if($rataPerIndikator->isNotEmpty())
        <x-card title="Rata-rata Nilai Per Indikator" subtitle="Menunjukkan indikator mana yang paling kuat/lemah secara rata-rata." icon="target">
            <div style="height:{{ max(250, $rataPerIndikator->count() * 45) }}px;">
                <canvas id="chartIndikator"></canvas>
            </div>
        </x-card>
        @endif

        @endif

    </div>

    @if($riwayat->isNotEmpty())
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: @json($labelPeriode),
                datasets: [{
                    label: 'Total Nilai (%)',
                    data: @json($nilaiPeriode),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#2563eb',
                    pointRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });

        @if($rataPerIndikator->isNotEmpty())
        new Chart(document.getElementById('chartIndikator'), {
            type: 'bar',
            data: {
                labels: @json($rataPerIndikator->keys()),
                datasets: [{
                    label: 'Rata-rata Nilai (%)',
                    data: @json($rataPerIndikator->values()),
                    backgroundColor: '#0d9488',
                    borderRadius: 6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, max: 100 } }
            }
        });
        @endif
    </script>
    @endif

</x-app-layout>