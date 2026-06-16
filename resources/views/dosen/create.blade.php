<x-app-layout>

<x-slot name="header">
    <h2>Tambah Dosen</h2>
</x-slot>

<div class="p-6">

<form action="/dosen" method="POST">

    @csrf

    <div>
        <label>Nama</label><br>
        <input type="text" name="nama">
    </div>

    <br>

    <div>
        <label>NIDN</label><br>
        <input type="text" name="nidn">
    </div>

    <br>

    <div>
        <label>Jabatan</label><br>
        <input type="text" name="jabatan">
    </div>

    <br>

    <div>
        <label>Program Studi</label><br>
        <input type="text" name="program_studi">
    </div>

    <br>

    <button type="submit">
        Simpan
    </button>

</form>

</div>

</x-app-layout>