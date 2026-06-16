<x-app-layout>

    <x-slot name="header">
        <h2>Data Dosen</h2>
    </x-slot>

    <div class="p-6">

        <a href="/dosen/create">
            + Tambah Dosen
        </a>

        <br><br>

        <table border="1" cellpadding="10">

            <tr>
                <th>Nama</th>
                <th>NIDN</th>
                <th>Jabatan</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>

            @foreach($dosens as $dosen)

            <tr>
                <td>{{ $dosen->nama }}</td>
                <td>{{ $dosen->nidn }}</td>
                <td>{{ $dosen->jabatan }}</td>
                <td>{{ $dosen->program_studi }}</td>

                <td>
                    <a href="/dosen/{{ $dosen->id }}/edit">
                        Edit
                    </a>

                    <form action="/dosen/{{ $dosen->id }}"
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