<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Capaian Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="/capaian" method="POST">

            @csrf

            <div>
                <label>Periode</label><br>

                <select name="periode_id">

                    @foreach($periodes as $periode)

                    <option value="{{ $periode->id }}">
                        {{ $periode->nama_periode }}
                    </option>

                    @endforeach

                </select>
            </div>

            <br>

            <div>
                <label>KPI</label><br>

                <select name="kpi_id">

                    @foreach($kpis as $kpi)

                    <option value="{{ $kpi->id }}">
                        {{ $kpi->nama_kpi }}
                    </option>

                    @endforeach

                </select>
            </div>

            <br>

            <div>
                <label>Nama Pegawai</label><br>
                <input type="text" name="pegawai">
            </div>

            <br>

            <div>
                <label>Jabatan</label><br>
                <input type="text" name="jabatan">
            </div>

            <br>

            <div>
                <label>Target</label><br>
                <input type="number" name="target">
            </div>

            <br>

            <div>
                <label>Realisasi</label><br>
                <input type="number" name="realisasi">
            </div>

            <br>

            <div>
                <label>Keterangan</label><br>

                <textarea
                    name="keterangan"
                    rows="4"
                    cols="40"></textarea>
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

            <a href="/capaian">
                Kembali
            </a>

        </form>

    </div>

</x-app-layout>