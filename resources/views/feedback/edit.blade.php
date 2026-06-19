<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue">
            Edit Feedback
        </h2>
    </x-slot>

    <div class="p-6">

        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label>Nama Pegawai</label>
                <br>

                <input
                    type="text"
                    name="pegawai"
                    value="{{ $feedback->pegawai }}"
                    style="width:250px;">
            </div>

            <br>

            <div>
                <label>Jabatan</label>
                <br>

                <input
                    type="text"
                    name="jabatan"
                    value="{{ $feedback->jabatan }}"
                    style="width:250px;">
            </div>

            <br>

            <div>
                <label>Feedback</label>
                <br>

                <textarea
                    name="feedback"
                    rows="5"
                    style="width:350px;">{{ $feedback->feedback }}</textarea>
            </div>

            <br>

            <div>
                <label>Status</label>
                <br>

                <select name="status">

                    <option value="Sangat Baik"
                        {{ $feedback->status == 'Sangat Baik' ? 'selected' : '' }}>
                        Sangat Baik
                    </option>

                    <option value="Baik"
                        {{ $feedback->status == 'Baik' ? 'selected' : '' }}>
                        Baik
                    </option>

                    <option value="Perlu Perbaikan"
                        {{ $feedback->status == 'Perlu Perbaikan' ? 'selected' : '' }}>
                        Perlu Perbaikan
                    </option>

                </select>
            </div>

            <br>

            <button type="submit">
                Update
            </button>

            <a href="{{ route('feedback.index') }}">
                Kembali
            </a>

        </form>

    </div>

</x-app-layout>