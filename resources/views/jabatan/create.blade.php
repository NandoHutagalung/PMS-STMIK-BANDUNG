<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Jabatan</h2>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-xl">
        <form action="{{ route('jabatan.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <x-input-label for="nama_jabatan" value="Nama Jabatan" />
                <x-text-input id="nama_jabatan" name="nama_jabatan" type="text" class="w-full" value="{{ old('nama_jabatan') }}" />
                <x-input-error :messages="$errors->get('nama_jabatan')" class="mt-1.5" />
            </div>
            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('jabatan.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>
        </form>
    </div>

</x-app-layout>