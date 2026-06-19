<x-app-layout>

        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard PMS
        </h2>
    </x-slot>

    <div class="p-6">

        <!-- Header Dashboard -->
        <div class="bg-white shadow rounded-lg p-6 mb-6 border-l-4 border-blue-600">

            <h1 class="text-3xl font-bold text-gray-800">
                Selamat Datang, {{ Auth::user()->name }}
            </h1>

            <p class="text-gray-500 mt-2">
                Performance Management System (PMS)
            </p>

            <p class="text-gray-400 text-sm mt-1">
                Monitoring dan Evaluasi Kinerja Dosen serta Karyawan
            </p>

        </div>

        <div style="display:flex; gap:20px; flex-wrap:wrap;">

            <div style="border:1px solid #1512a3;padding:20px;width:200px;">
                <h4>Total Dosen</h4>
                <h1>{{ $totalDosen }}</h1>
            </div>

            <div style="border:1px solid #1512a3;padding:20px;width:200px;">
                <h4>Total Karyawan</h4>
                <h1>{{ $totalKaryawan }}</h1>
            </div>

            <div style="border:1px solid #1512a3;padding:20px;width:200px;">
                <h4>Total KPI</h4>
                <h1>{{ $totalKpi }}</h1>
            </div>

            <div style="border:1px solid #1512a3;padding:20px;width:200px;">
                <h4>Total Periode</h4>
                <h1>{{ $totalPeriode }}</h1>
            </div>

            <div style="border:1px solid #1512a3;padding:20px;width:200px;">
                <h4>Total Evaluasi</h4>
                <h1>{{ $totalEvaluasi }}</h1>
            </div>

            <div style="border:1px solid #1512a3;padding:20px;width:200px;">
                <h4>Total Capaian</h4>
                <h1>{{ $totalCapaian }}</h1>
                            
            </div>

        </div>

    </div>

</x-app-layout>