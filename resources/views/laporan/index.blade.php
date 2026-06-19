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

            </div>

        </div>

        <div class="bg-white shadow rounded-lg p-6">

            <h3 class="text-lg font-bold mb-4">
                Rekap Evaluasi
            </h3>

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="p-3 border">No</th>
                        <th class="p-3 border">Pegawai</th>
                        <th class="p-3 border">Nilai</th>
                        <th class="p-3 border">Catatan</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($evaluasis as $evaluasi)

                    <tr>

                        <td class="border p-3">
                            {{ $loop->iteration }}
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

</x-app-layout>