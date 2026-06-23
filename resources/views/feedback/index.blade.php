<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Data Feedback Kinerja</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola umpan balik kinerja pegawai.</p>
            </div>
            <a href="{{ route('feedback.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition">
                <x-icon name="plus" class="w-4 h-4" /> Tambah Feedback
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ q: '' }">

        <div class="relative mb-5 max-w-sm">
            <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
            <input type="text" x-model="q" placeholder="Cari pemberi atau penerima..."
                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left rounded-l-lg">No</th>
                        <th class="px-4 py-3 text-left">Pemberi</th>
                        <th class="px-4 py-3 text-left">Penerima</th>
                        <th class="px-4 py-3 text-left">Feedback</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse($feedbacks as $feedback)
                    <tr x-show="!q || $el.innerText.toLowerCase().includes(q.toLowerCase())" class="hover:bg-blue-50/40">
                        <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $feedback->pemberi_feedback }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $feedback->penerima_feedback }}</td>
                        <td class="px-4 py-3 text-slate-500 max-w-xs truncate">{{ $feedback->feedback }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusColor = match($feedback->status) {
                                    'Sangat Baik' => 'green',
                                    'Baik' => 'blue',
                                    'Perlu Perbaikan' => 'amber',
                                    default => 'gray',
                                };
                            @endphp
                            <x-badge :color="$statusColor">{{ $feedback->status }}</x-badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('feedback.edit', $feedback->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>
                                <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus feedback ini?');">
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
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada data feedback.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>