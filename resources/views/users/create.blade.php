<x-app-layout>

    <x-slot name="header">
        <h2>Tambah User</h2>
    </x-slot>

    <div class="p-6">

        <form action="/users" method="POST">
            @csrf

            <div>
                <label>Nama</label><br>
                <input type="text" name="name">
            </div>

            <br>

            <div>
                <label>Email</label><br>
                <input type="email" name="email">
            </div>

            <br>

            <div>
                <label>Password</label><br>
                <input type="password" name="password">
            </div>

            <br>

            <div>
                <label>Role</label><br>

                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="dosen">Dosen</option>
                    <option value="karyawan">Karyawan</option>
                    <option value="atasan">Atasan</option>
                </select>
            </div>

            <br>

            <button type="submit">
                Simpan
            </button>

        </form>

    </div>

</x-app-layout>