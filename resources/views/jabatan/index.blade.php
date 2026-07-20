<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Data Master Jabatan</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola daftar jabatan untuk Dosen dan Karyawan.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="flex justify-end mb-4">
            <a href="{{ route('jabatan.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                <x-icon name="plus" class="w-4 h-4" /> Tambah Jabatan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                        <th class="px-4 py-3 text-left">Nama Jabatan</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jabatans as $j)
                    <tr>
                        <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $j->nama_jabatan }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('jabatan.edit', $j->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold">
                                    <x-icon name="document-text" class="w-3.5 h-3.5" /> Edit
                                </a>
                                <form action="{{ route('jabatan.destroy', $j->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus jabatan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-xs font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-slate-400">Belum ada data jabatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>