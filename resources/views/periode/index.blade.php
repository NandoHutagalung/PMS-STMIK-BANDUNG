<x-app-layout>

    <x-slot name="header">
        <h2>Data Periode Penilaian</h2>
    </x-slot>

    <div class="p-6">

        <a href="/periode/create">
            Tambah Periode
        </a>

        <br><br>

        <table border="1" cellpadding="10">
            <tr>
                <th>No</th>
                <th>Nama Periode</th>
                <th>Tahun</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            @foreach($periodes as $periode)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $periode->nama_periode }}</td>
                <td>{{ $periode->tahun }}</td>
                <td>{{ $periode->status }}</td>

                <td>

                    <a href="/periode/{{ $periode->id }}/edit">
                        Edit
                    </a>

                    <form action="/periode/{{ $periode->id }}"
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