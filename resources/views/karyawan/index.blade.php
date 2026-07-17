<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Data Karyawan</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola data karyawan STMIK Bandung.</p>
            </div>

        </div>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ q: '' }">

        <div class="relative mb-5 max-w-sm">
            <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
            <input type="text" x-model="q" placeholder="Cari nama atau NIP..."
                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left rounded-l-lg">Nama</th>
                        <th class="px-4 py-3 text-left">NIP</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Departemen</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse($karyawans as $karyawan)
                    <tr x-show="!q || $el.innerText.toLowerCase().includes(q.toLowerCase())" class="hover:bg-blue-50/40">
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $karyawan->nama }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $karyawan->nip }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $karyawan->jabatan }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $karyawan->departemen }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>
                                <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data karyawan ini?');">
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
                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada data karyawan.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>