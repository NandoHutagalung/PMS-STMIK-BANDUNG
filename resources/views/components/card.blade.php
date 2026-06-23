@props(['title' => null, 'subtitle' => null, 'icon' => null])
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-100 shadow-sm p-6']) }}>
    @if($title)
        <div class="flex items-center gap-2 mb-5">
            @if($icon)
                <x-icon :name="$icon" class="w-5 h-5 text-blue-600" />
            @endif
            <div>
                <h3 class="text-base font-bold text-slate-800">{{ $title }}</h3>
                @if($subtitle)
                    <p class="text-xs text-slate-400">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    @endif
    {{ $slot }}
</div>