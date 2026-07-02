<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Kegiatan Tri Dharma</h2>
        <p class="text-sm text-slate-500 mt-1">Catat kegiatan Pengajaran, Penelitian, Pengabdian, atau Penunjang.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('tri-dharma.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <x-input-label value="Kategori" />
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-1">
                    @foreach(['Pengajaran' => 'academic-cap', 'Penelitian' => 'document-text', 'Pengabdian' => 'users', 'Penunjang' => 'briefcase'] as $kat => $icon)
                    <label class="cursor-pointer">
                        <input type="radio" name="kategori" value="{{ $kat }}" class="peer sr-only"
                               {{ $kategoriTerpilih == $kat ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-1.5 rounded-xl border-2 border-gray-200 px-3 py-3 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                            <x-icon :name="$icon" class="w-5 h-5 text-blue-600" />
                            <span class="text-xs font-semibold text-slate-700">{{ $kat }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('kategori')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="periode_id" value="Periode" />
                    <select id="periode_id" name="periode_id"
                            class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->id }}">{{ $periode->nama_periode }} ({{ $periode->tahun }})</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('periode_id')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="tanggal_kegiatan" value="Tanggal Kegiatan" />
                    <x-text-input id="tanggal_kegiatan" name="tanggal_kegiatan" type="date" class="w-full" value="{{ old('tanggal_kegiatan') }}" />
                    <x-input-error :messages="$errors->get('tanggal_kegiatan')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="judul_kegiatan" value="Judul / Nama Kegiatan" />
                <x-text-input id="judul_kegiatan" name="judul_kegiatan" type="text" class="w-full" value="{{ old('judul_kegiatan') }}"
                              placeholder="Contoh: Pemrograman Web / Analisis Sistem Informasi Akademik / dst" />
                <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="peran" value="Peran" />
                    <x-text-input id="peran" name="peran" type="text" class="w-full" value="{{ old('peran') }}"
                                  placeholder="Dosen Pengampu / Ketua Peneliti / Anggota / Panitia" />
                    <x-input-error :messages="$errors->get('peran')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="sks_jam" value="SKS / Jam" />
                    <x-text-input id="sks_jam" name="sks_jam" type="number" step="0.01" class="w-full" value="{{ old('sks_jam') }}" />
                    <x-input-error :messages="$errors->get('sks_jam')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="deskripsi" value="Deskripsi (Opsional)" />
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"
                          placeholder="Penjelasan singkat kegiatan...">{{ old('deskripsi') }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="keterangan_bukti" value="Keterangan Bukti (Opsional)" />
                <x-text-input id="keterangan_bukti" name="keterangan_bukti" type="text" class="w-full" value="{{ old('keterangan_bukti') }}"
                              placeholder="Nomor SK, link dokumen, atau catatan bukti pendukung" />
                <x-input-error :messages="$errors->get('keterangan_bukti')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('tri-dharma.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>