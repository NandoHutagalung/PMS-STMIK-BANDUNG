<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Feedback Kinerja
        </h2>
    </x-slot>

    <div class="p-6">

        <a href="/feedback/create"
           class="bg-blue-600 text-gray-100 px-4 py-2 rounded">
            Tambah Feedback
        </a>

        <br><br>

        <table class="min-w-full bg-white border">

            <thead class="bg-gray-100">

                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Pegawai</th>
                    <th class="border px-4 py-2">Jabatan</th>
                    <th class="border px-4 py-2">Feedback</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @foreach($feedbacks as $feedback)

                <tr>

                    <td class="border px-4 py-2">
                        {{ $loop->iteration }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $feedback->pegawai }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $feedback->jabatan }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $feedback->feedback }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $feedback->status }}
                    </td>

                    <td class="border px-4 py-2">

                        <a href="/feedback/{{ $feedback->id }}/edit"
                           class="bg-yellow-500 text-black px-3 py-1 rounded">
                            Edit
                        </a>

                        <form
                            action="/feedback/{{ $feedback->id }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>