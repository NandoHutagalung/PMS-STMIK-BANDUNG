<x-app-layout>

<x-slot name="header">
    <h2>Data Karyawan</h2>
</x-slot>

<div class="p-6">

    <a href="/karyawan/create">
        + Tambah Karyawan
    </a>

    <br><br>

    <table border="1" cellpadding="10">

        <tr>
            <th>Nama</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Departemen</th>
            <th>Aksi</th>
        </tr>

        @foreach($karyawans as $karyawan)

        <tr>
            <td>{{ $karyawan->nama }}</td>
            <td>{{ $karyawan->nip }}</td>
            <td>{{ $karyawan->jabatan }}</td>
            <td>{{ $karyawan->departemen }}</td>

            <td>

                <a href="/karyawan/{{ $karyawan->id }}/edit">
                    Edit
                </a>

                <form action="/karyawan/{{ $karyawan->id }}"
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