<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Edit Feedback</h2>
        <p class="text-sm text-slate-500 mt-1">Perbarui umpan balik kinerja.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="pegawai" value="Nama Pegawai" />
                    <x-text-input id="pegawai" name="pegawai" type="text" class="w-full" value="{{ old('pegawai', $feedback->pegawai) }}" />
                    <x-input-error :messages="$errors->get('pegawai')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="jabatan" value="Jabatan" />
                    <x-text-input id="jabatan" name="jabatan" type="text" class="w-full" value="{{ old('jabatan', $feedback->jabatan) }}" />
                    <x-input-error :messages="$errors->get('jabatan')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="feedback" value="Feedback" />
                <textarea id="feedback" name="feedback" rows="5"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('feedback', $feedback->feedback) }}</textarea>
                <x-input-error :messages="$errors->get('feedback')" class="mt-1.5" />
            </div>

            <div class="max-w-xs">
                <x-input-label for="status" value="Status" />
                <select id="status" name="status"
                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                    <option value="Sangat Baik" {{ $feedback->status == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                    <option value="Baik" {{ $feedback->status == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Perlu Perbaikan" {{ $feedback->status == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Update
                </x-primary-button>
                <a href="{{ route('feedback.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Kembali</a>
            </div>

        </form>
    </div>

</x-app-layout>