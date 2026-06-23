<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Dosen</h2>
        <p class="text-sm text-slate-500 mt-1">Tambahkan data dosen baru.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('dosen.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="nama" value="Nama" />
                    <x-text-input id="nama" name="nama" type="text" class="w-full" value="{{ old('nama') }}" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="nidn" value="NIDN" />
                    <x-text-input id="nidn" name="nidn" type="text" class="w-full" value="{{ old('nidn') }}" />
                    <x-input-error :messages="$errors->get('nidn')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="jabatan" value="Jabatan" />
                    <x-text-input id="jabatan" name="jabatan" type="text" class="w-full" value="{{ old('jabatan') }}" />
                    <x-input-error :messages="$errors->get('jabatan')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="program_studi" value="Program Studi" />
                    <x-text-input id="program_studi" name="program_studi" type="text" class="w-full" value="{{ old('program_studi') }}" />
                    <x-input-error :messages="$errors->get('program_studi')" class="mt-1.5" />
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('dosen.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>