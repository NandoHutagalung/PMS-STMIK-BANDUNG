<x-app-layout>

    <x-slot name="header">
        <h2>Tambah KPI</h2>
    </x-slot>

    <div class="p-6">

        <form action="/kpi" method="POST">
            @csrf

            <div>
                <label>Kode KPI</label>
                <input type="text" name="kode_kpi">
            </div>

            <br>

            <div>
                <label>Nama KPI</label>
                <input type="text" name="nama_kpi">
            </div>

            <br>

            <div>
                <label>Bobot</label>
                <input type="number" name="bobot">
            </div>

            <br>

            <div>
                <label>Deskripsi</label>
                <textarea name="deskripsi"></textarea>
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

        </form>

    </div>

</x-app-layout>