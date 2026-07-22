<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Pengembangan SDM</h2>
        <p class="text-sm text-slate-500 mt-1">Catat kegiatan Pelatihan, Sertifikasi, atau Penghargaan yang kamu peroleh.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('pengembangan-sdm.store') }}" method="POST" class="space-y-5">
            @csrf

<div>
                <x-input-label for="kategori" value="Kategori" />
                <select id="kategori" name="kategori"
                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                    <option value="Pelatihan" {{ $kategoriTerpilih == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                    <option value="Sertifikasi" {{ $kategoriTerpilih == 'Sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                    <option value="Penghargaan" {{ $kategoriTerpilih == 'Penghargaan' ? 'selected' : '' }}>Penghargaan</option>
                </select>
                <x-input-error :messages="$errors->get('kategori')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="judul" value="Judul Kegiatan / Sertifikat / Penghargaan" />
                <x-text-input id="judul" name="judul" type="text" class="w-full" value="{{ old('judul') }}"
                              placeholder="Contoh: Pelatihan Manajemen Data / Sertifikasi ISO 9001 / Karyawan Terbaik" />
                <x-input-error :messages="$errors->get('judul')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="penyelenggara" value="Penyelenggara / Pemberi (Opsional)" />
                <x-text-input id="penyelenggara" name="penyelenggara" type="text" class="w-full" value="{{ old('penyelenggara') }}" />
                <x-input-error :messages="$errors->get('penyelenggara')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="tanggal_mulai" value="Tanggal Mulai" />
                    <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="w-full" value="{{ old('tanggal_mulai') }}" />
                </div>
                <div>
                    <x-input-label for="tanggal_selesai" value="Tanggal Selesai (Opsional)" />
                    <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="w-full" value="{{ old('tanggal_selesai') }}" />
                </div>
            </div>

            <div>
                <x-input-label for="nomor_sertifikat" value="Nomor Sertifikat / SK (Opsional)" />
                <x-text-input id="nomor_sertifikat" name="nomor_sertifikat" type="text" class="w-full" value="{{ old('nomor_sertifikat') }}" />
            </div>

            <div>
                <x-input-label for="deskripsi" value="Deskripsi (Opsional)" />
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <x-input-label for="keterangan_bukti" value="Keterangan Bukti (Opsional)" />
                <x-text-input id="keterangan_bukti" name="keterangan_bukti" type="text" class="w-full" value="{{ old('keterangan_bukti') }}"
                              placeholder="Link dokumen atau catatan bukti pendukung" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('pengembangan-sdm.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>