<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Evaluasi Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <a href="/evaluasi/create">
            Tambah Evaluasi
        </a>

        <br><br>

        <table border="1" cellpadding="10" cellspacing="0">

            <tr>
                <th>No</th>
                <th>Periode</th>
                <th>KPI</th>
                <th>Nama Pegawai</th>
                <th>Nilai</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>

            @foreach($evaluasis as $evaluasi)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $evaluasi->periode->nama_periode }}</td>

                <td>{{ $evaluasi->kpi->nama_kpi }}</td>

                <td>{{ $evaluasi->nama_pegawai }}</td>

                <td>{{ $evaluasi->nilai }}</td>

                <td>{{ $evaluasi->catatan }}</td>

                <td>

                    <a href="/evaluasi/{{ $evaluasi->id }}/edit">
                        Edit
                    </a>

                    <form
                        action="/evaluasi/{{ $evaluasi->id }}"
                        method="POST"
                        style="display:inline;">

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