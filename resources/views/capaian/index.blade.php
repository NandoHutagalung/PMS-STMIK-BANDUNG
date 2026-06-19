<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Capaian Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <a href="/capaian/create">
            Tambah Capaian
        </a>

        <br><br>

        <table border="1" cellpadding="10">

            <tr>
                <th>No</th>
                <th>Pegawai</th>
                <th>Jabatan</th>
                <th>Target</th>
                <th>Realisasi</th>
                <th>%</th>
                <th>Aksi</th>
            </tr>

            @foreach($capaians as $capaian)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $capaian->pegawai }}</td>

                <td>{{ $capaian->jabatan }}</td>

                <td>{{ $capaian->target }}</td>

                <td>{{ $capaian->realisasi }}</td>

                <td>{{ number_format($capaian->persentase,2) }}%</td>

                <td>

                    <a href="/capaian/{{ $capaian->id }}/edit">
                        Edit
                    </a>

                    <form
                        action="/capaian/{{ $capaian->id }}"
                        method="POST"
                        style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </table>

    </div>

</x-app-layout>