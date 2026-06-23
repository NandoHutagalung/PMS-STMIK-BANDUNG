<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
        <p class="text-sm text-slate-500 mt-1">Ringkasan data Performance Management System</p>
    </x-slot>

    <div class="space-y-6">

        <!-- Welcome banner -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-600 rounded-2xl p-6 sm:p-8 text-white shadow-sm relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-white/10"></div>
            <div class="absolute right-16 bottom-0 w-24 h-24 rounded-full bg-white/10"></div>
            <div class="relative">
                <h1 class="text-2xl sm:text-3xl font-extrabold">
                    Selamat Datang, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-blue-100 mt-2">
                    Performance Management System (PMS)
                </p>
                <p class="text-blue-200 text-sm mt-1">
                    Monitoring dan Evaluasi Kinerja Dosen serta Karyawan &mdash; STMIK Bandung
                </p>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

            <x-stat-card label="Total Dosen" :value="$totalDosen" icon="academic-cap" color="blue" />
            <x-stat-card label="Total Karyawan" :value="$totalKaryawan" icon="briefcase" color="teal" />
            <x-stat-card label="Total KPI" :value="$totalKpi" icon="target" color="purple" />
            <x-stat-card label="Total Periode" :value="$totalPeriode" icon="calendar" color="amber" />
            <x-stat-card label="Total Evaluasi" :value="$totalEvaluasi" icon="clipboard-check" color="green" />
            <x-stat-card label="Total Feedback" :value="$totalFeedback" icon="chat" color="red" />
            <x-stat-card label="Total Capaian" :value="$totalCapaian" icon="flag" color="blue" />

        </div>

    </div>

</x-app-layout>