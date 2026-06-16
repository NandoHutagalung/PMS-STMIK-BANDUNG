<x-app-layout>

    <x-slot name="header">
        <h2>Edit Karyawan</h2>
    </x-slot>

    <div class="p-6">

        <form action="/karyawan/{{ $karyawan->id }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label>Nama</label><br>
                <input type="text"
                       name="nama"
                       value="{{ $karyawan->nama }}">
            </div>

            <br>

            <div>
                <label>NIP</label><br>
                <input type="text"
                       name="nip"
                       value="{{ $karyawan->nip }}">
            </div>

            <br>

            <div>
                <label>Jabatan</label><br>
                <input type="text"
                       name="jabatan"
                       value="{{ $karyawan->jabatan }}">
            </div>

            <br>

            <div>
                <label>Departemen</label><br>
                <input type="text"
                       name="departemen"
                       value="{{ $karyawan->departemen }}">
            </div>

            <br>

            <button type="submit">
                Update
            </button>

        </form>

    </div>

</x-app-layout>