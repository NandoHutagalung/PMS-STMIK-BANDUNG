<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah {{ $judul }}</h2>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-2xl">
        <form action="{{ route('kpi-master.store', $slug) }}" method="POST" class="space-y-5">
            @csrf

            @if($slug == 'bobot')
                <div>
                    <x-input-label for="nilai" value="Nilai Bobot (%)" />
                    <x-text-input id="nilai" name="nilai" type="number" step="0.01" min="0" max="100" class="w-full" value="{{ old('nilai') }}" placeholder="Contoh: 20" />
                    <x-input-error :messages="$errors->get('nilai')" class="mt-1.5" />
                </div>
            @else
                <div>
                    <x-input-label for="nama" value="Nama {{ $judul }}" />
                    <x-text-input id="nama" name="nama" type="text" class="w-full" value="{{ old('nama') }}" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
                </div>
            @endif

            @if($slug == 'indikator')
                <div>
                    <x-input-label for="parent_id" value="Kategori KPI" />
                    <select id="parent_id" name="parent_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        <option value="">-- Pilih Kategori (Opsional) --</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('parent_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @if($kategoriList->isEmpty())
                    <p class="text-xs text-amber-600 mt-1">Belum ada data Kategori KPI. Buat dulu di menu Kategori KPI supaya bisa dipilih di sini.</p>
                    @endif
                </div>

                <div>
                    <x-input-label for="satuan_default" value="Satuan Default (Opsional)" />
                    <x-text-input id="satuan_default" name="satuan_default" type="text" class="w-full" value="{{ old('satuan_default') }}" placeholder="Contoh: %, hari, kegiatan" />
                </div>
            @endif

            <div>
                <x-input-label for="deskripsi" value="Deskripsi (Opsional)" />
                <textarea id="deskripsi" name="deskripsi" rows="3"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('kpi-master.index', $slug) }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>