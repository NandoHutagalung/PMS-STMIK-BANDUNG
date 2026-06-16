<x-app-layout>

<x-slot name="header">
    <h2>Edit User</h2>
</x-slot>

<div class="p-6">

<form action="/users/{{ $user->id }}" method="POST">

    @csrf
    @method('PUT')

    <div>
        <label>Nama</label><br>
        <input type="text"
               name="name"
               value="{{ $user->name }}">
    </div>

    <br>

    <div>
        <label>Email</label><br>
        <input type="email"
               name="email"
               value="{{ $user->email }}">
    </div>

    <br>

    <div>
        <label>Role</label><br>

        <select name="role">

            <option value="admin"
                {{ $user->role == 'admin' ? 'selected' : '' }}>
                Admin
            </option>

            <option value="dosen"
                {{ $user->role == 'dosen' ? 'selected' : '' }}>
                Dosen
            </option>

            <option value="karyawan"
                {{ $user->role == 'karyawan' ? 'selected' : '' }}>
                Karyawan
            </option>

            <option value="atasan"
                {{ $user->role == 'atasan' ? 'selected' : '' }}>
                Atasan
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