<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Evaluasi Kinerja</h2>
        <p class="text-sm text-slate-500 mt-1">Perbarui hasil evaluasi kinerja.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('evaluasi.update', $evaluasi->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="periode_id" value="Periode" />
                    <select id="periode_id" name="periode_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" {{ $evaluasi->periode_id == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('periode_id')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="kpi_id" value="KPI" />
                    <select id="kpi_id" name="kpi_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        @foreach($kpis as $kpi)
                            <option value="{{ $kpi->id }}" {{ $evaluasi->kpi_id == $kpi->id ? 'selected' : '' }}>
                                {{ $kpi->nama_kpi }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kpi_id')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="nama_pegawai" value="Nama Pegawai" />
                    <x-text-input id="nama_pegawai" name="nama_pegawai" type="text" class="w-full" value="{{ old('nama_pegawai', $evaluasi->nama_pegawai) }}" />
                    <x-input-error :messages="$errors->get('nama_pegawai')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="nilai" value="Nilai" />
                    <x-text-input id="nilai" name="nilai" type="number" class="w-full" value="{{ old('nilai', $evaluasi->nilai) }}" />
                    <x-input-error :messages="$errors->get('nilai')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="catatan" value="Catatan" />
                <textarea id="catatan" name="catatan" rows="4"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('catatan', $evaluasi->catatan) }}</textarea>
                <x-input-error :messages="$errors->get('catatan')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Update
                </x-primary-button>
                <a href="{{ route('evaluasi.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Kembali</a>
            </div>

        </form>
    </div>

</x-app-layout>