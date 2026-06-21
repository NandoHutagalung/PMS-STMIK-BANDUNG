<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Laporan Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="bg-white shadow rounded-lg p-6 mb-6">

            <h3 class="text-lg font-bold">
                Ringkasan Kinerja
            </h3>

            <div class="mt-4">

                <p>
                    Nilai Rata-rata Kinerja :
                    <strong>
                        {{ number_format($rataRata,2) }}
                    </strong>
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

    <div class="bg-blue-600 text-grey rounded-lg p-5">

        <h4>Total Evaluasi</h4>

        <h1 class="text-3xl font-bold">
            {{ $evaluasis->count() }}
        </h1>

    </div>

    <div class="bg-green-600 text-grey rounded-lg p-5">

        <h4>Nilai Tertinggi</h4>

        <h1 class="text-3xl font-bold">
            {{ $evaluasis->max('nilai') }}
        </h1>

    </div>

    <div class="bg-red-600 text-white rounded-lg p-5">

        <h4>Nilai Terendah</h4>

        <h1 class="text-3xl font-bold">
            {{ $evaluasis->min('nilai') }}
        </h1>

    </div>

</div>

            </div>

        </div>

        <div class="bg-white shadow rounded-lg p-6">

            <h3 class="text-lg font-bold mb-4">
                Rekap Evaluasi
            </h3>
            <form method="GET" class="mb-4 flex gap-3 items-center">

         <select
        name="periode_id"
        class="border rounded px-3 py-2">

        <option value="">
            Semua Periode
        </option>

        @foreach($periodes as $periode)

            <option
                value="{{ $periode->id }}"
                {{ request('periode_id') == $periode->id ? 'selected' : '' }}>

                {{ $periode->nama_periode }}

            </option>

        @endforeach

        </select>

        <button
        type="submit"
        class="bg-blue-600 text-grey px-4 py-2 rounded hover:bg-blue-700">

               Filter

             </button>

            </form>

            <table class="w-full border">


                <thead class="bg-gray-100">

                    <thead class="bg-gray-100">

    <tr>
        <th class="p-3 border">No</th>
        <th class="p-3 border">Periode</th>
        <th class="p-3 border">Pegawai</th>
        <th class="p-3 border">Nilai</th>
        <th class="p-3 border">Catatan</th>
    </tr>

</thead>

                </thead>

                <tbody>

    @foreach($evaluasis as $evaluasi)

    <tr>

        <td class="border p-3">
            {{ $loop->iteration }}
        </td>

        <td class="border p-3">
            {{ $evaluasi->periode->nama_periode ?? '-' }}
        </td>

        <td class="border p-3">
            {{ $evaluasi->nama_pegawai }}
        </td>

        <td class="border p-3">
            {{ $evaluasi->nilai }}
        </td>

        <td class="border p-3">
            {{ $evaluasi->catatan }}
        </td>

    </tr>

    @endforeach

</tbody>

            </table>

        </div>

    </div>
<div class="bg-white shadow rounded-lg p-6 mt-6">

    <h3 class="text-lg font-bold mb-4">
        Grafik Nilai Kinerja Pegawai
    </h3>

<div style="height:350px;">
    <canvas id="chartKinerja"></canvas>
</div>
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

            legend: {
                display: true
            }

        },

        scales: {

            y: {

                beginAtZero: true,

                max: 100

            }

        }

    }

});

</script>
</x-app-layout>