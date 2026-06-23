<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Periode</h2>
        <p class="text-sm text-slate-500 mt-1">Tambahkan periode penilaian baru.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-2xl">
        <form action="{{ route('periode.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="nama_periode" value="Nama Periode" />
                <x-text-input id="nama_periode" name="nama_periode" type="text" class="w-full" value="{{ old('nama_periode') }}" placeholder="Contoh: Semester Ganjil 2026" />
                <x-input-error :messages="$errors->get('nama_periode')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="tahun" value="Tahun" />
                    <x-text-input id="tahun" name="tahun" type="number" class="w-full" value="{{ old('tahun') }}" />
                    <x-input-error :messages="$errors->get('tahun')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-1.5" />
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('periode.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>