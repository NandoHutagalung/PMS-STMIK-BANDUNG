<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
        <p class="text-sm text-slate-500 mt-1">Ringkasan data Performance Management System — STMIK Bandung</p>
    </x-slot>

    <div class="space-y-6">

        <div class="bg-gradient-to-r from-blue-700 to-blue-600 rounded-2xl p-6 sm:p-8 text-white shadow-sm relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-white/10"></div>
            <div class="absolute right-16 bottom-0 w-24 h-24 rounded-full bg-white/10"></div>
            <div class="relative">
                <h1 class="text-2xl sm:text-3xl font-extrabold">
                    Selamat Datang, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-blue-100 mt-2">Performance Management System (PMS)</p>
                <p class="text-blue-200 text-sm mt-1">
                    Monitoring dan Evaluasi Kinerja Dosen serta Karyawan &mdash; STMIK Bandung
                </p>
            </div>
        </div>

        @if(Auth::user()->role == 'admin')

            <!-- ===== 1. RINGKASAN KPI ===== -->
            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-3">Ringkasan KPI</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    <x-stat-card label="Total Dosen" :value="$totalDosen" icon="academic-cap" color="blue" />
                    <x-stat-card label="Total Karyawan" :value="$totalKaryawan" icon="briefcase" color="teal" />
                    <x-stat-card label="Total Periode" :value="$totalPeriode" icon="calendar" color="amber" />
                    <x-stat-card label="Template KPI" :value="$totalTemplate" icon="clipboard-check" color="purple" />
                    <x-stat-card label="Penilaian Final" :value="$totalPenilaianFinal" icon="check-circle" color="green" />
                    <x-stat-card label="Menunggu Verifikasi" :value="$totalMenungguVerifikasi" icon="bell" color="red" />
                    <x-stat-card
                        label="Rata-rata Nilai"
                        :value="$rataRataNilai ? number_format($rataRataNilai, 2) . '%' : '-'"
                        icon="star"
                        color="purple"
                    />
                </div>
            </div>

            <!-- ===== 2. GRAFIK KINERJA ===== -->
            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-3">Grafik Kinerja</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <x-card title="Distribusi Predikat Kinerja" icon="presentation">
                        @if(array_sum($distribusiPredikat) > 0)
                        <div style="height:260px;">
                            <canvas id="chartPredikat"></canvas>
                        </div>
                        @else
                        <p class="text-sm text-slate-400 text-center py-10">Belum ada penilaian final untuk ditampilkan.</p>
                        @endif
                    </x-card>

                    <x-card title="Rata-rata Nilai: Dosen vs Pegawai" icon="target">
                        @if($rataRataDosen || $rataRataPegawai)
                        <div style="height:260px;">
                            <canvas id="chartKategori"></canvas>
                        </div>
                        @else
                        <p class="text-sm text-slate-400 text-center py-10">Belum ada penilaian final untuk ditampilkan.</p>
                        @endif
                    </x-card>

                </div>
            </div>

            <!-- ===== 3. NOTIFIKASI ===== -->
            <div>
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-3">Notifikasi</h3>

                @if($templateMenunggu->isEmpty() && $nilaiMenunggu->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center text-sm text-slate-400">
                    Tidak ada notifikasi. Semua sudah diverifikasi.
                </div>
                @else
                <div class="bg-white rounded-2xl border border-amber-100 shadow-sm divide-y divide-gray-100">

                    @foreach($templateMenunggu as $t)
                    <a href="{{ route('kpi-approval.show', $t->id) }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-amber-50/50 transition">
                        <div class="bg-amber-50 text-amber-600 rounded-xl p-2.5 flex-shrink-0">
                            <x-icon name="clipboard-check" class="w-5 h-5" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-slate-700">
                                Template KPI "{{ $t->jabatan }}" menunggu persetujuan
                            </p>
                            <p class="text-xs text-slate-400">{{ $t->kategori_pegawai }} &middot; {{ $t->periode->nama_periode ?? '-' }}</p>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 text-slate-300 -rotate-90 flex-shrink-0" />
                    </a>
                    @endforeach

                    @foreach($nilaiMenunggu as $n)
                    <a href="{{ route('kpi-approval.show-nilai', $n->id) }}"
                       class="flex items-center gap-4 px-5 py-4 hover:bg-amber-50/50 transition">
                        <div class="bg-blue-50 text-blue-600 rounded-xl p-2.5 flex-shrink-0">
                            <x-icon name="star" class="w-5 h-5" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-slate-700">
                                Nilai KPI {{ $n->pegawai_nama }} menunggu verifikasi
                            </p>
                            <p class="text-xs text-slate-400">{{ $n->kategori_pegawai }} &middot; {{ $n->periode->nama_periode ?? '-' }}</p>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 text-slate-300 -rotate-90 flex-shrink-0" />
                    </a>
                    @endforeach

                </div>

                <div class="text-right mt-3">
                    <a href="{{ route('kpi-approval.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">
                        Lihat semua di Approval KPI &rarr;
                    </a>
                </div>
                @endif
            </div>

        @endif

        @if(Auth::user()->role == 'dosen' || Auth::user()->role == 'karyawan')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('kpi-saya.index') }}"
               class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6 flex items-center gap-4 hover:border-blue-300 transition">
                <div class="bg-blue-50 text-blue-600 rounded-xl p-3">
                    <x-icon name="target" class="w-6 h-6" />
                </div>
                <div>
                    <p class="font-bold text-slate-800">KPI Saya</p>
                    <p class="text-sm text-slate-500">Lihat riwayat penilaian kinerja kamu</p>
                </div>
            </a>

            @if(Auth::user()->role == 'karyawan')
            <a href="{{ route('kpi-saya.input') }}"
               class="bg-white rounded-2xl border border-green-100 shadow-sm p-6 flex items-center gap-4 hover:border-green-300 transition">
                <div class="bg-green-50 text-green-600 rounded-xl p-3">
                    <x-icon name="flag" class="w-6 h-6" />
                </div>
                <div>
                    <p class="font-bold text-slate-800">Input Realisasi</p>
                    <p class="text-sm text-slate-500">Isi pencapaian kerja periode ini</p>
                </div>
            </a>
            @endif
        </div>
        @endif

        @if(Auth::user()->role == 'atasan')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('monitoring.index') }}"
               class="bg-white rounded-2xl border border-blue-100 shadow-sm p-6 flex items-center gap-4 hover:border-blue-300 transition">
                <div class="bg-blue-50 text-blue-600 rounded-xl p-3">
                    <x-icon name="presentation" class="w-6 h-6" />
                </div>
                <div>
                    <p class="font-bold text-slate-800">Monitoring Kinerja</p>
                    <p class="text-sm text-slate-500">Pantau ringkasan kinerja dosen dan karyawan</p>
                </div>
            </a>
        </div>
        @endif

    </div>

    @if(Auth::user()->role == 'admin' && (array_sum($distribusiPredikat) > 0 || $rataRataDosen || $rataRataPegawai))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if(array_sum($distribusiPredikat) > 0)
        new Chart(document.getElementById('chartPredikat'), {
            type: 'doughnut',
            data: {
                labels: ['Sangat Baik', 'Baik', 'Perlu Perbaikan'],
                datasets: [{
                    data: [
                        {{ $distribusiPredikat['Sangat Baik'] }},
                        {{ $distribusiPredikat['Baik'] }},
                        {{ $distribusiPredikat['Perlu Perbaikan'] }}
                    ],
                    backgroundColor: ['#16a34a', '#2563eb', '#d97706'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
            }
        });
        @endif

        @if($rataRataDosen || $rataRataPegawai)
        new Chart(document.getElementById('chartKategori'), {
            type: 'bar',
            data: {
                labels: ['Dosen', 'Pegawai'],
                datasets: [{
                    label: 'Rata-rata Nilai (%)',
                    data: [{{ $rataRataDosen ?? 0 }}, {{ $rataRataPegawai ?? 0 }}],
                    backgroundColor: ['#2563eb', '#0d9488'],
                    borderRadius: 8,
                    maxBarThickness: 60,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
        @endif
    </script>
    @endif

</x-app-layout>