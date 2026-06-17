<x-app-layout>

    <x-slot name="header">
        <h2>Edit KPI</h2>
    </x-slot>

    <div class="p-6">

        <form action="/kpi/{{ $kpi->id }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label>Kode KPI</label>
                <input type="text" name="kode_kpi" value="{{ $kpi->kode_kpi }}">
            </div>

            <br>

            <div>
                <label>Nama KPI</label>
                <input type="text" name="nama_kpi" value="{{ $kpi->nama_kpi }}">
            </div>

            <br>

            <div>
                <label>Bobot</label>
                <input type="number" name="bobot" value="{{ $kpi->bobot }}">
            </div>

            <br>

            <div>
                <label>Deskripsi</label>
                <textarea name="deskripsi">{{ $kpi->deskripsi }}</textarea>
            </div>

            <br>

            <button type="submit">
                Update
            </button>

        </form>

    </div>

</x-app-layout>