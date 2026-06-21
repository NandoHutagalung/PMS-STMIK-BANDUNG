<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
        Monitoring Kinerja
    </h2>
</x-slot>

<div class="p-6">

<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

    <div class="bg-blue-600 text-grey p-5 rounded-lg shadow">
        <h4>Total Dosen</h4>
        <h1 class="text-3xl font-bold">
            {{ $totalDosen }}
        </h1>
    </div>

    <div class="bg-green-600 text-grey p-5 rounded-lg shadow">
        <h4>Total Karyawan</h4>
        <h1 class="text-3xl font-bold">
            {{ $totalKaryawan }}
        </h1>
    </div>

    <div class="bg-indigo-600 text-grey p-5 rounded-lg shadow">
        <h4>Total Evaluasi</h4>
        <h1 class="text-3xl font-bold">
            {{ $totalEvaluasi }}
        </h1>
    </div>

    <div class="bg-orange-600 text-grey p-5 rounded-lg shadow">
        <h4>Total Capaian</h4>
        <h1 class="text-3xl font-bold">
            {{ $totalCapaian }}
        </h1>
    </div>

    <div class="bg-red-600 text-white p-5 rounded-lg shadow">
        <h4>Total Feedback</h4>
        <h1 class="text-3xl font-bold">
            {{ $totalFeedback }}
        </h1>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

<div class="bg-white shadow rounded-lg p-6">

<h3 class="text-lg font-bold mb-4">
5 Nilai Kinerja Terbaik
</h3>

<table class="w-full border">

<tr class="bg-gray-100">
<th class="border p-2">Pegawai</th>
<th class="border p-2">Nilai</th>
</tr>

@foreach($evaluasiTerbaik as $item)

<tr>
<td class="border p-2">
{{ $item->nama_pegawai }}
</td>

<td class="border p-2 text-green-600 font-bold">
{{ $item->nilai }}
</td>
</tr>

@endforeach

</table>

</div>

<div class="bg-white shadow rounded-lg p-6">

<h3 class="text-lg font-bold mb-4">
5 Nilai Kinerja Terendah
</h3>

<table class="w-full border">

<tr class="bg-gray-100">
<th class="border p-2">Pegawai</th>
<th class="border p-2">Nilai</th>
</tr>

@foreach($evaluasiTerendah as $item)

<tr>
<td class="border p-2">
{{ $item->nama_pegawai }}
</td>

<td class="border p-2 text-red-600 font-bold">
{{ $item->nilai }}
</td>
</tr>

@endforeach

</table>

</div>

</div>

</div>

</x-app-layout>