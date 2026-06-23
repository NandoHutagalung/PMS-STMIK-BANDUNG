<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Karyawan</h2>
        <p class="text-sm text-slate-500 mt-1">Tambahkan data karyawan baru.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('karyawan.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="nama" value="Nama" />
                    <x-text-input id="nama" name="nama" type="text" class="w-full" value="{{ old('nama') }}" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="nip" value="NIP" />
                    <x-text-input id="nip" name="nip" type="text" class="w-full" value="{{ old('nip') }}" />
                    <x-input-error :messages="$errors->get('nip')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="jabatan" value="Jabatan" />
                    <x-text-input id="jabatan" name="jabatan" type="text" class="w-full" value="{{ old('jabatan') }}" />
                    <x-input-error :messages="$errors->get('jabatan')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="departemen" value="Departemen" />
                    <x-text-input id="departemen" name="departemen" type="text" class="w-full" value="{{ old('departemen') }}" />
                    <x-input-error :messages="$errors->get('departemen')" class="mt-1.5" />
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('karyawan.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>