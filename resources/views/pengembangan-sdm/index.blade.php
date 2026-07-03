<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Pengembangan SDM</h2>
                <p class="text-sm text-slate-500 mt-1">Catat kegiatan Pelatihan, Sertifikasi, dan Penghargaan yang kamu peroleh.</p>
            </div>
            <a href="{{ route('pengembangan-sdm.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition">
                <x-icon name="plus" class="w-4 h-4" /> Tambah Kegiatan
            </a>
        </div>
    </x-slot>

    <div x-data="{ tab: 'Semua', q: '' }" class="space-y-6">

        <div class="grid grid-cols-3 gap-4">
            <x-stat-card label="Pelatihan" :value="$rekap['Pelatihan']" icon="clipboard-check" color="blue" />
            <x-stat-card label="Sertifikasi" :value="$rekap['Sertifikasi']" icon="check-circle" color="green" />
            <x-stat-card label="Penghargaan" :value="$rekap['Penghargaan']" icon="star" color="amber" />
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

            <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
                <div class="flex flex-wrap gap-2">
                    <template x-for="kategori in ['Semua', 'Pelatihan', 'Sertifikasi', 'Penghargaan']" :key="kategori">
                        <button type="button" @click="tab = kategori"
                                :class="tab === kategori ? 'bg-blue-600 text-white' : 'bg-gray-100 text-slate-600 hover:bg-gray-200'"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition"
                                x-text="kategori"></button>
                    </template>
                </div>

                <div class="relative max-w-xs w-full">
                    <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                    <input type="text" x-model="q" placeholder="Cari judul..."
                           class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                            <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Penyelenggara</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">No. Sertifikat</th>
                            <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse($kegiatans as $kegiatan)
                        <tr x-show="(tab === 'Semua' || tab === '{{ $kegiatan->kategori }}') && (!q || $el.innerText.toLowerCase().includes(q.toLowerCase()))"
                            class="hover:bg-blue-50/40">
                            <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $kategoriColor = match($kegiatan->kategori) {
                                        'Pelatihan' => 'blue',
                                        'Sertifikasi' => 'green',
                                        'Penghargaan' => 'amber',
                                        default => 'gray',
                                    };
                                @endphp
                                <x-badge :color="$kategoriColor">{{ $kegiatan->kategori }}</x-badge>
                            </td>
                            <td class="px-4 py-3 font-medium text-slate-700 max-w-xs truncate">{{ $kegiatan->judul }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $kegiatan->penyelenggara ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $kegiatan->tanggal_mulai ? \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') : '-' }}
                                @if($kegiatan->tanggal_selesai)
                                    &ndash; {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $kegiatan->nomor_sertifikat ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('pengembangan-sdm.edit', $kegiatan->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                        <x-icon name="pencil" class="w-4 h-4" />
                                    </a>
                                    <form action="{{ route('pengembangan-sdm.destroy', $kegiatan->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-red-200 text-red-600 hover:bg-red-50">
                                            <x-icon name="trash" class="w-4 h-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400">Belum ada data Pengembangan SDM yang dicatat.</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>