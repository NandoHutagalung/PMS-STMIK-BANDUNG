<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen User
        </h2>
    </x-slot>

    <div class="p-6">

        <a href="/users/create">
            + Tambah User
        </a>

        <br><br>

        <table border="1" cellpadding="10">

            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>

            @foreach($users as $user)

            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>

                <td>

                    <a href="/users/{{ $user->id }}/edit">
                        Edit
                    </a>

                    <form action="/users/{{ $user->id }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Hapus
                        </button>

                    </form>

                </td>
            </tr>

            @endforeach

        </table>

    </div>

</x-app-layout>