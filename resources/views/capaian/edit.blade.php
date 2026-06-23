<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Capaian Kinerja</h2>
        <p class="text-sm text-slate-500 mt-1">Perbarui realisasi capaian kerja.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('capaian.update', $capaian->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="periode_id" value="Periode" />
                    <select id="periode_id" name="periode_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" {{ $capaian->periode_id == $periode->id ? 'selected' : '' }}>
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
                            <option value="{{ $kpi->id }}" {{ $capaian->kpi_id == $kpi->id ? 'selected' : '' }}>
                                {{ $kpi->nama_kpi }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kpi_id')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="pegawai" value="Nama Pegawai" />
                    <x-text-input id="pegawai" name="pegawai" type="text" class="w-full" value="{{ old('pegawai', $capaian->pegawai) }}" />
                    <x-input-error :messages="$errors->get('pegawai')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="jabatan" value="Jabatan" />
                    <x-text-input id="jabatan" name="jabatan" type="text" class="w-full" value="{{ old('jabatan', $capaian->jabatan) }}" />
                    <x-input-error :messages="$errors->get('jabatan')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="target" value="Target" />
                    <x-text-input id="target" name="target" type="number" class="w-full" value="{{ old('target', $capaian->target) }}" />
                    <x-input-error :messages="$errors->get('target')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="realisasi" value="Realisasi" />
                    <x-text-input id="realisasi" name="realisasi" type="number" class="w-full" value="{{ old('realisasi', $capaian->realisasi) }}" />
                    <x-input-error :messages="$errors->get('realisasi')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="keterangan" value="Keterangan" />
                <textarea id="keterangan" name="keterangan" rows="4"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('keterangan', $capaian->keterangan) }}</textarea>
                <x-input-error :messages="$errors->get('keterangan')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Update
                </x-primary-button>
                <a href="{{ route('capaian.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Kembali</a>
            </div>

        </form>
    </div>

</x-app-layout>