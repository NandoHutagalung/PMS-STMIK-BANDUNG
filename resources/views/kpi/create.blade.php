<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah KPI</h2>
        <p class="text-sm text-slate-500 mt-1">Tambahkan indikator kinerja baru.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('kpi.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="kode_kpi" value="Kode KPI" />
                    <x-text-input id="kode_kpi" name="kode_kpi" type="text" class="w-full" value="{{ old('kode_kpi') }}" placeholder="Contoh: KPI-001" />
                    <x-input-error :messages="$errors->get('kode_kpi')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="bobot" value="Bobot (%)" />
                    <x-text-input id="bobot" name="bobot" type="number" class="w-full" value="{{ old('bobot') }}" placeholder="0 - 100" />
                    <x-input-error :messages="$errors->get('bobot')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="nama_kpi" value="Nama KPI" />
                <x-text-input id="nama_kpi" name="nama_kpi" type="text" class="w-full" value="{{ old('nama_kpi') }}" placeholder="Nama indikator kinerja" />
                <x-input-error :messages="$errors->get('nama_kpi')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="deskripsi" value="Deskripsi" />
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                          placeholder="Jelaskan indikator ini...">{{ old('deskripsi') }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('kpi.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>