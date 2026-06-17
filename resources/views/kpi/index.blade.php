<x-app-layout>

    <x-slot name="header">
        <h2>Data KPI</h2>
    </x-slot>

    <div class="p-6">

        <a href="/kpi/create">
            Tambah KPI
        </a>

        <br><br>

        <table border="1" cellpadding="10">

            <tr>
                    <th>No</th>
                    <th>Kode KPI</th>
                    <th>Nama KPI</th>
                    <th>Bobot</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
            </tr>

            @foreach($kpis as $kpi)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kpi->kode_kpi }}</td>
                <td>{{ $kpi->nama_kpi }}</td>
                <td>{{ $kpi->bobot }}</td>
                <td>{{ $kpi->deskripsi }}</td>

                <td>

                    <a href="/kpi/{{ $kpi->id }}/edit">
                        Edit
                    </a>

                    <form action="/kpi/{{ $kpi->id }}" method="POST" style="display:inline;">
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