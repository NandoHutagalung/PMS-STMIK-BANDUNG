<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Hasil Evaluasi Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="bg-white shadow rounded-lg p-6">

            <h3 class="text-lg font-bold mb-4">
                Riwayat Evaluasi
            </h3>

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border p-3">No</th>
                        <th class="border p-3">Pegawai</th>
                        <th class="border p-3">Nilai</th>
                        <th class="border p-3">Catatan</th>

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

                            @if($evaluasi->nilai >= 85)

                                <span class="text-green-600 font-bold">
                                    {{ $evaluasi->nilai }}
                                </span>

                            @elseif($evaluasi->nilai >= 70)

                                <span class="text-blue-600 font-bold">
                                    {{ $evaluasi->nilai }}
                                </span>

                            @else

                                <span class="text-red-600 font-bold">
                                    {{ $evaluasi->nilai }}
                                </span>

                            @endif

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