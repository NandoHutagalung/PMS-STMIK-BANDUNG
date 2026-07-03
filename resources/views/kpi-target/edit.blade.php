<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Target KPI {{ $level }}</h2>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-2xl">
        <form action="{{ route('kpi-target.update', [$slug, $target->id]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="periode_id" value="Periode" />
                    <select id="periode_id" name="periode_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" {{ old('periode_id', $target->periode_id) == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama_periode }} ({{ $periode->tahun }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('periode_id')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="sasaran_strategis_id" value="Sasaran Strategis (Opsional)" />
                    <select id="sasaran_strategis_id" name="sasaran_strategis_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        <option value="">-- Tidak terkait --</option>
                        @foreach($sasaranList as $sasaran)
                            <option value="{{ $sasaran->id }}" {{ old('sasaran_strategis_id', $target->sasaran_strategis_id) == $sasaran->id ? 'selected' : '' }}>{{ $sasaran->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($level == 'Individu')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="kategori_pegawai" value="Kategori" />
                    <select id="kategori_pegawai" name="kategori_pegawai"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        <option value="Dosen" {{ old('kategori_pegawai', $target->kategori_pegawai) == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="Pegawai" {{ old('kategori_pegawai', $target->kategori_pegawai) == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="nama_entitas" value="Nama" />
                    <input list="daftarNama" id="nama_entitas" name="nama_entitas" type="text"
                           class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                           value="{{ old('nama_entitas', $target->nama_entitas) }}">
                    <datalist id="daftarNama">
                        @foreach($daftarNama as $nama)
                            <option value="{{ $nama }}">
                        @endforeach
                    </datalist>
                </div>
            </div>
            @elseif($level == 'Departemen')
            <div>
                <x-input-label for="nama_entitas" value="Nama Departemen" />
                <input list="daftarDepartemen" id="nama_entitas" name="nama_entitas" type="text"
                       class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                       value="{{ old('nama_entitas', $target->nama_entitas) }}">
                <datalist id="daftarDepartemen">
                    @foreach($daftarDepartemen as $dep)
                        <option value="{{ $dep }}">
                    @endforeach
                </datalist>
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="nama_target" value="Nama Target" />
                    <x-text-input id="nama_target" name="nama_target" type="text" class="w-full" value="{{ old('nama_target', $target->nama_target) }}" />
                    <x-input-error :messages="$errors->get('nama_target')" class="mt-1.5" />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="target_nilai" value="Target" />
                        <x-text-input id="target_nilai" name="target_nilai" type="number" step="0.01" class="w-full" value="{{ old('target_nilai', $target->target_nilai) }}" />
                        <x-input-error :messages="$errors->get('target_nilai')" class="mt-1.5" />
                    </div>
                    <div>
                        <x-input-label for="satuan" value="Satuan" />
                        <x-text-input id="satuan" name="satuan" type="text" class="w-full" value="{{ old('satuan', $target->satuan) }}" />
                    </div>
                </div>
            </div>

            <div>
                <x-input-label for="keterangan" value="Keterangan (Opsional)" />
                <textarea id="keterangan" name="keterangan" rows="3"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('keterangan', $target->keterangan) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Update
                </x-primary-button>
                <a href="{{ route('kpi-target.index', $slug) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>