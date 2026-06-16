<x-app-layout>

    <x-slot name="header">
        <h2>Tambah Karyawan</h2>
    </x-slot>

    <div class="p-6">

        <form action="/karyawan" method="POST">

            @csrf

            <div>
                <label>Nama</label><br>
                <input type="text" name="nama">
            </div>

            <br>

            <div>
                <label>NIP</label><br>
                <input type="text" name="nip">
            </div>

            <br>

            <div>
                <label>Jabatan</label><br>
                <input type="text" name="jabatan">
            </div>

            <br>

            <div>
                <label>Departemen</label><br>
                <input type="text" name="departemen">
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

        </form>

    </div>

</x-app-layout>