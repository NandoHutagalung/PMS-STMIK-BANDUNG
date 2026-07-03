<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Approval Tri Dharma</h2>
        <p class="text-sm text-slate-500 mt-1">Tinjau dan setujui kegiatan Tri Dharma yang diajukan dosen.</p>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 mb-4">
            Menunggu Persetujuan
            <span class="text-xs font-normal text-slate-400">({{ $kegiatans->count() }} pengajuan)</span>
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-slate-400 border-b border-gray-100">
                        <th class="py-2 pr-3">Dosen</th>
                        <th class="py-2 pr-3">Kategori</th>
                        <th class="py-2 pr-3">Judul Kegiatan</th>
                        <th class="py-2 pr-3">Peran</th>
                        <th class="py-2 pr-3">SKS/Jam</th>
                        <th class="py-2 pr-3">Tanggal</th>
                        <th class="py-2 pr-3">Periode</th>
                        <th class="py-2 pr-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $k)
                    <tr class="border-b border-gray-50">
                        <td class="py-3 pr-3 font-medium text-slate-700">{{ $k->dosen_nama }}</td>
                        <td class="py-3 pr-3">
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-blue-50 text-blue-600">{{ $k->kategori }}</span>
                        </td>
                        <td class="py-3 pr-3">{{ $k->judul_kegiatan }}</td>
                        <td class="py-3 pr-3">{{ $k->peran ?? '-' }}</td>
                        <td class="py-3 pr-3">{{ $k->sks_jam ?? '-' }}</td>
                        <td class="py-3 pr-3">{{ $k->tanggal_kegiatan ? \Carbon\Carbon::parse($k->tanggal_kegiatan)->format('d M Y') : '-' }}</td>
                        <td class="py-3 pr-3">{{ $k->periode?->nama_periode }} {{ $k->periode?->tahun }}</td>
                        <td class="py-3 pr-3 text-right whitespace-nowrap">
                            <form action="{{ route('tri-dharma.approve', $k->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-700">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('tri-dharma.reject', $k->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100"
                                        onclick="return confirm('Tolak kegiatan ini?')">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-6 text-center text-slate-400">Tidak ada pengajuan yang menunggu persetujuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-6">
        <h3 class="font-semibold text-slate-800 mb-4">Riwayat Terverifikasi</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-slate-400 border-b border-gray-100">
                        <th class="py-2 pr-3">Dosen</th>
                        <th class="py-2 pr-3">Kategori</th>
                        <th class="py-2 pr-3">Judul Kegiatan</th>
                        <th class="py-2 pr-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr class="border-b border-gray-50">
                        <td class="py-3 pr-3 font-medium text-slate-700">{{ $r->dosen_nama }}</td>
                        <td class="py-3 pr-3">{{ $r->kategori }}</td>
                        <td class="py-3 pr-3">{{ $r->judul_kegiatan }}</td>
                        <td class="py-3 pr-3">
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs {{ $r->status == 'Disetujui' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ $r->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-slate-400">Belum ada riwayat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>