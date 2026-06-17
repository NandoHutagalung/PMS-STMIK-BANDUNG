<x-app-layout>

    <x-slot name="header">
        <h2>Edit Periode</h2>
    </x-slot>

    <div class="p-6">

        <form action="/periode/{{ $periode->id }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label>Nama Periode</label>
                <input type="text"
                       name="nama_periode"
                       value="{{ $periode->nama_periode }}">
            </div>

            <br>

            <div>
                <label>Tahun</label>
                <input type="number"
                       name="tahun"
                       value="{{ $periode->tahun }}">
            </div>

            <br>

            <div>
                <label>Status</label>

                <select name="status">

                    <option value="Aktif"
                    {{ $periode->status == 'Aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="Nonaktif"
                    {{ $periode->status == 'Nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>

                </select>
            </div>

            <br>

            <button type="submit">
                Update
            </button>

        </form>

    </div>

</x-app-layout>