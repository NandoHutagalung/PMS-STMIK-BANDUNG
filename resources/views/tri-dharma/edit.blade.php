<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Kegiatan Tri Dharma</h2>
        <p class="text-sm text-slate-500 mt-1">Perbarui detail kegiatan.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('tri-dharma.update', $kegiatan->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="kategori" value="Kategori" />
                <select id="kategori" name="kategori"
                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                    <option value="Pengajaran" {{ $kegiatan->kategori == 'Pengajaran' ? 'selected' : '' }}>Pengajaran</option>
                    <option value="Penelitian" {{ $kegiatan->kategori == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                    <option value="Pengabdian" {{ $kegiatan->kategori == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                    <option value="Penunjang" {{ $kegiatan->kategori == 'Penunjang' ? 'selected' : '' }}>Penunjang</option>
                </select>
                <x-input-error :messages="$errors->get('kategori')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="periode_id" value="Periode" />
                    <select id="periode_id" name="periode_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}" {{ $kegiatan->periode_id == $periode->id ? 'selected' : '' }}>
                                {{ $periode->nama_periode }} ({{ $periode->tahun }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('periode_id')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="tanggal_kegiatan" value="Tanggal Kegiatan" />
                    <x-text-input id="tanggal_kegiatan" name="tanggal_kegiatan" type="date" class="w-full" value="{{ old('tanggal_kegiatan', $kegiatan->tanggal_kegiatan) }}" />
                    <x-input-error :messages="$errors->get('tanggal_kegiatan')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="judul_kegiatan" value="Judul / Nama Kegiatan" />
                <x-text-input id="judul_kegiatan" name="judul_kegiatan" type="text" class="w-full" value="{{ old('judul_kegiatan', $kegiatan->judul_kegiatan) }}" />
                <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="peran" value="Peran" />
                    <x-text-input id="peran" name="peran" type="text" class="w-full" value="{{ old('peran', $kegiatan->peran) }}" />
                    <x-input-error :messages="$errors->get('peran')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="sks_jam" value="SKS / Jam" />
                    <x-text-input id="sks_jam" name="sks_jam" type="number" step="0.01" class="w-full" value="{{ old('sks_jam', $kegiatan->sks_jam) }}" />
                    <x-input-error :messages="$errors->get('sks_jam')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="deskripsi" value="Deskripsi (Opsional)" />
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="keterangan_bukti" value="Keterangan Bukti (Opsional)" />
                <x-text-input id="keterangan_bukti" name="keterangan_bukti" type="text" class="w-full" value="{{ old('keterangan_bukti', $kegiatan->keterangan_bukti) }}" />
                <x-input-error :messages="$errors->get('keterangan_bukti')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Update
                </x-primary-button>
                <a href="{{ route('tri-dharma.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>