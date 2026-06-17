<x-app-layout>

    <x-slot name="header">
        <h2>Edit Evaluasi Kinerja</h2>
    </x-slot>

    <div class="p-6">

        <form action="/evaluasi/{{ $evaluasi->id }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label>Periode</label>

                <select name="periode_id">

                    @foreach($periodes as $periode)

                        <option
                            value="{{ $periode->id }}"
                            {{ $evaluasi->periode_id == $periode->id ? 'selected' : '' }}>

                            {{ $periode->nama_periode }}

                        </option>

                    @endforeach

                </select>
            </div>

            <br>

            <div>
                <label>KPI</label>

                <select name="kpi_id">

                    @foreach($kpis as $kpi)

                        <option
                            value="{{ $kpi->id }}"
                            {{ $evaluasi->kpi_id == $kpi->id ? 'selected' : '' }}>

                            {{ $kpi->nama_kpi }}

                        </option>

                    @endforeach

                </select>
            </div>

            <br>

            <div>
                <label>Nama Pegawai</label>

                <input
                    type="text"
                    name="nama_pegawai"
                    value="{{ $evaluasi->nama_pegawai }}">
            </div>

            <br>

            <div>
                <label>Nilai</label>

                <input
                    type="number"
                    name="nilai"
                    value="{{ $evaluasi->nilai }}">
            </div>

            <br>

            <div>
                <label>Catatan</label>

                <textarea
                    name="catatan"
                    rows="4">{{ $evaluasi->catatan }}</textarea>
            </div>

            <br>

            <button type="submit">
                Update
            </button>

        </form>

    </div>

</x-app-layout>