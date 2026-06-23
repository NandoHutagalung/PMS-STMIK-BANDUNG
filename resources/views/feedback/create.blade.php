<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">Tambah Feedback</h2>
        <p class="text-sm text-slate-500 mt-1">Berikan umpan balik kinerja pegawai.</p>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('feedback.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="pemberi_feedback" value="Pemberi Feedback" />
                    <x-text-input id="pemberi_feedback" name="pemberi_feedback" type="text" class="w-full" value="{{ old('pemberi_feedback') }}" />
                    <x-input-error :messages="$errors->get('pemberi_feedback')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="penerima_feedback" value="Penerima Feedback" />
                    <x-text-input id="penerima_feedback" name="penerima_feedback" type="text" class="w-full" value="{{ old('penerima_feedback') }}" />
                    <x-input-error :messages="$errors->get('penerima_feedback')" class="mt-1.5" />
                </div>
            </div>

            <div>
                <x-input-label for="feedback" value="Feedback" />
                <textarea id="feedback" name="feedback" rows="5"
                          class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">{{ old('feedback') }}</textarea>
                <x-input-error :messages="$errors->get('feedback')" class="mt-1.5" />
            </div>

            <div class="max-w-xs">
                <x-input-label for="status" value="Status" />
                <select id="status" name="status"
                        class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                    <option value="Sangat Baik">Sangat Baik</option>
                    <option value="Baik">Baik</option>
                    <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-1.5" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>
                    <x-icon name="check-circle" class="w-4 h-4" /> Simpan
                </x-primary-button>
                <a href="{{ route('feedback.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Kembali</a>
            </div>

        </form>
    </div>

</x-app-layout>