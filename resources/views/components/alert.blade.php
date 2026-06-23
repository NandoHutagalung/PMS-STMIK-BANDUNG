@if (session('success'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        <x-icon name="check-circle" class="w-5 h-5 flex-shrink-0 text-green-600 mt-0.5" />
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <x-icon name="x" class="w-5 h-5 flex-shrink-0 text-red-600 mt-0.5" />
        <span>{{ session('error') }}</span>
    </div>
@endif