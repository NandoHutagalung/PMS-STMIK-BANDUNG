<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Capaian Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="/capaian/{{ $capaian->id }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label>Periode</label>
                <br>

                <select name="periode_id">

                    @foreach($periodes as $periode)

                        <option
                            value="{{ $periode->id }}"
                            {{ $capaian->periode_id == $periode->id ? 'selected' : '' }}>

                            {{ $periode->nama_periode }}

                        </option>

                    @endforeach

                </select>
            </div>

            <br>

            <div>
                <label>KPI</label>
                <br>

                <select name="kpi_id">

                    @foreach($kpis as $kpi)

                        <option
                            value="{{ $kpi->id }}"
                            {{ $capaian->kpi_id == $kpi->id ? 'selected' : '' }}>

                            {{ $kpi->nama_kpi }}

                        </option>

                    @endforeach

                </select>
            </div>

            <br>

            <div>
                <label>Nama Pegawai</label>
                <br>

                <input
                    type="text"
                    name="pegawai"
                    value="{{ $capaian->pegawai }}">
            </div>

            <br>

            <div>
                <label>Jabatan</label>
                <br>

                <input
                    type="text"
                    name="jabatan"
                    value="{{ $capaian->jabatan }}">
            </div>

            <br>

            <div>
                <label>Target</label>
                <br>

                <input
                    type="number"
                    name="target"
                    value="{{ $capaian->target }}">
            </div>

            <br>

            <div>
                <label>Realisasi</label>
                <br>

                <input
                    type="number"
                    name="realisasi"
                    value="{{ $capaian->realisasi }}">
            </div>

            <br>

            <div>
                <label>Keterangan</label>
                <br>

                <textarea
                    name="keterangan"
                    rows="4"
                    cols="40">{{ $capaian->keterangan }}</textarea>
            </div>

            <br>

            <button type="submit">
                Update
            </button>

            <a href="/capaian">
                Kembali
            </a>

        </form>

    </div>

</x-app-layout>