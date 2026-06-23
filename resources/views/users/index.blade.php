<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen User</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola akun pengguna sistem.</p>
            </div>
            <a href="/users/create"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition">
                <x-icon name="plus" class="w-4 h-4" /> Tambah User
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ q: '' }">

        <div class="relative mb-5 max-w-sm">
            <x-icon name="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
            <input type="text" x-model="q" placeholder="Cari nama atau email..."
                   class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 text-blue-900 text-xs uppercase tracking-wide">
                        <th class="px-4 py-3 text-left rounded-l-lg">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse($users as $user)
                    <tr x-show="!q || $el.innerText.toLowerCase().includes(q.toLowerCase())" class="hover:bg-blue-50/40">
                        <td class="px-4 py-3 flex items-center gap-2.5 font-medium text-slate-700">
                            <span class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            {{ $user->name }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @php
                                $roleColor = match($user->role) {
                                    'admin' => 'blue',
                                    'atasan' => 'purple',
                                    'dosen' => 'green',
                                    default => 'amber',
                                };
                            @endphp
                            <x-badge :color="$roleColor" class="capitalize">{{ $user->role }}</x-badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="/users/{{ $user->id }}/edit"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>
                                <form action="/users/{{ $user->id }}" method="POST"
                                      onsubmit="return confirm('Hapus user ini?');">
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
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada data user.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>