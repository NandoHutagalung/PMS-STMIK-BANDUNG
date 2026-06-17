<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Evaluasi Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="/evaluasi" method="POST">

            @csrf

            <div>
                <label>Periode Penilaian</label>

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
                <label>KPI</label>

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
                <label>Nama Pegawai</label>

                <input
                    type="text"
                    name="nama_pegawai">
            </div>

            <br>

            <div>
                <label>Nilai</label>

                <input
                    type="number"
                    name="nilai">
            </div>

            <br>

            <div>
                <label>Catatan</label>

                <textarea
                    name="catatan"
                    rows="4"></textarea>
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

            <a href="/evaluasi">
                Kembali
            </a>

        </form>

    </div>

</x-app-layout>