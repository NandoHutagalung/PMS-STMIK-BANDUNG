<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Input KPI Dosen / Pegawai</h2>
                <p class="text-sm text-slate-500 mt-1">Daftar template KPI berdasarkan jabatan dan periode.</p>
            </div>
            <a href="{{ route('kpi-template.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition">
                <x-icon name="plus" class="w-4 h-4" /> Tambah KPI
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ q: '' }">

        <div class="relative mb-5 max-w-sm">
            <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
            <input type="text" x-model="q" placeholder="Cari jabatan atau unit kerja..."
                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Unit Kerja</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Jumlah Indikator</th>
                        <th class="px-4 py-3 text-left">Total Bobot</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse($templates as $template)
                    <tr x-show="!q || $el.innerText.toLowerCase().includes(q.toLowerCase())" class="hover:bg-blue-50/40">
                        <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $template->periode->nama_periode ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $template->kategori_pegawai }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $template->unit_kerja }}</td>
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $template->jabatan }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $template->items->count() }}</td>
                        <td class="px-4 py-3">
                            @php $totalBobot = $template->items->sum('bobot'); @endphp
                            <span class="font-semibold {{ $totalBobot == 100 ? 'text-green-600' : 'text-amber-600' }}">
                                {{ $totalBobot }}%
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <x-badge :color="$template->status == 'diajukan' ? 'green' : 'gray'" class="capitalize">
                                {{ $template->status }}
                            </x-badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('kpi-template.edit', $template->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>
                                <form action="{{ route('kpi-template.destroy', $template->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus template KPI ini?');">
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
                        <td colspan="9" class="px-4 py-8 text-center text-slate-400">Belum ada template KPI.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>