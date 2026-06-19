<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Feedback
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="{{ route('feedback.store') }}" method="POST">

            @csrf

            <div>
                <label>Nama Pegawai</label>
                <br>

                <input
                    type="text"
                    name="pegawai"
                    style="width:250px;">
            </div>

            <br>

            <div>
                <label>Jabatan</label>
                <br>

                <input
                    type="text"
                    name="jabatan"
                    style="width:250px;">
            </div>

            <br>

            <div>
                <label>Feedback</label>
                <br>

                <textarea
                    name="feedback"
                    rows="5"
                    style="width:350px;"></textarea>
            </div>

            <br>

            <div>
                <label>Status</label>
                <br>

                <select
                    name="status"
                    style="width:250px;">

                    <option value="Sangat Baik">
                        Sangat Baik
                    </option>

                    <option value="Baik">
                        Baik
                    </option>

                    <option value="Perlu Perbaikan">
                        Perlu Perbaikan
                    </option>

                </select>
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

            <a href="{{ route('feedback.index') }}">
                Kembali
            </a>

        </form>

    </div>

</x-app-layout>