<x-app-layout>

    <x-slot name="header">
        <h2>Tambah Periode</h2>
    </x-slot>

    <div class="p-6">

        <form action="/periode" method="POST">

            @csrf

            <div>
                <label>Nama Periode</label>
                <input type="text" name="nama_periode">
            </div>

            <br>

            <div>
                <label>Tahun</label>
                <input type="number" name="tahun">
            </div>

            <br>

            <div>
                <label>Status</label>

                <select name="status">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

        </form>

    </div>

</x-app-layout>