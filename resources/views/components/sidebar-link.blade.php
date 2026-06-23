@props(['href', 'icon' => null, 'active' => false])
<a href="{{ $href }}"
   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors duration-150
   {{ $active ? 'bg-blue-600 text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/50 hover:text-white' }}">
    @if($icon)
        <x-icon :name="$icon" class="w-5 h-5 flex-shrink-0 {{ $active ? 'text-white' : 'text-blue-300' }}" />
    @endif
    <span class="truncate">{{ $slot }}</span>
</a>