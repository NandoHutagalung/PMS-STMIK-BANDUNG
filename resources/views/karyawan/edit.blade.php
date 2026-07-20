<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Karyawan</h2>
        <p class="text-sm text-slate-500 mt-1">Perbarui data karyawan.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="nama" value="Nama" />
                    <x-text-input id="nama" name="nama" type="text" class="w-full" value="{{ old('nama', $karyawan->nama) }}" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="nip" value="NIP" />
                    <x-text-input id="nip" name="nip" type="text" class="w-full" value="{{ old('nip', $karyawan->nip) }}" />
                    <x-input-error :messages="$errors->get('nip')" class="mt-1.5" />
                </div>

<div>
    <x-input-label for="jabatan" value="Jabatan" />
    <select id="jabatan" name="jabatan"
            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
        <option value="">-- Pilih Jabatan --</option>
        @foreach($jabatans as $j)
            <option value="{{ $j->nama_jabatan }}" {{ old('jabatan', $karyawan->jabatan) == $j->nama_jabatan ? 'selected' : '' }}>
                {{ $j->nama_jabatan }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('jabatan')" class="mt-1.5" />
</div>

                <div>
                    <x-input-label for="departemen" value="Departemen" />
                    <x-text-input id="departemen" name="departemen" type="text" class="w-full" value="{{ old('departemen', $karyawan->departemen) }}" />
                    <x-input-error :messages="$errors->get('departemen')" class="mt-1.5" />
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Update
                </x-primary-button>
                <a href="{{ route('karyawan.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>