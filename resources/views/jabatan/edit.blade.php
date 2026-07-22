<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Jabatan</h2>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-xl">
        <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="jenis" value="Jenis Jabatan" />
                <select id="jenis" name="jenis"
                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                    <option value="karyawan" {{ old('jenis', $jabatan->jenis) == 'karyawan' ? 'selected' : '' }}>Jabatan Karyawan</option>
                    <option value="dosen" {{ old('jenis', $jabatan->jenis) == 'dosen' ? 'selected' : '' }}>Golongan/Jafung Dosen</option>
                </select>
                <x-input-error :messages="$errors->get('jenis')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="nama_jabatan" value="Nama Jabatan" />
                <x-text-input id="nama_jabatan" name="nama_jabatan" type="text" class="w-full" value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}" />
                <x-input-error :messages="$errors->get('nama_jabatan')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Update
                </x-primary-button>
                <a href="{{ route('jabatan.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>
        </form>
    </div>

</x-app-layout>