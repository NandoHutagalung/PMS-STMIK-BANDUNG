<x-app-layout>

    <x-slot name="header">
        <h2>Tambah Karyawan</h2>
    </x-slot>

    <div class="p-6">

        <form>

            <div>
                <label>Nama</label>
                <input type="text">
            </div>

            <br>

            <div>
                <label>NIP</label>
                <input type="text">
            </div>

            <br>

            <div>
                <label>Jabatan</label>
                <input type="text">
            </div>

            <br>

            <div>
                <label>Departemen</label>
                <input type="text">
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

        </form>

    </div>

</x-app-layout>