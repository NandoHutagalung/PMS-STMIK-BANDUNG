<x-app-layout>

<x-slot name="header">
    <h2>Edit Dosen</h2>
</x-slot>

<div class="p-6">

<form action="/dosen/{{ $dosen->id }}" method="POST">

    @csrf
    @method('PUT')

    <div>
        <label>Nama</label><br>
        <input type="text" name="nama" value="{{ $dosen->nama }}">
    </div>

    <br>

    <div>
        <label>NIDN</label><br>
        <input type="text" name="nidn" value="{{ $dosen->nidn }}">
    </div>

    <br>

    <div>
        <label>Jabatan</label><br>
        <input type="text" name="jabatan" value="{{ $dosen->jabatan }}">
    </div>

    <br>

    <div>
        <label>Program Studi</label><br>
        <input type="text" name="program_studi" value="{{ $dosen->program_studi }}">
    </div>

    <br>

    <button type="submit">
        Update
    </button>

</form>

</div>

</x-app-layout>