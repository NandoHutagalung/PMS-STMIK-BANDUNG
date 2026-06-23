@props(['label', 'value', 'icon' => 'target', 'color' => 'blue'])
@php
$map = [
    'blue'   => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'ring' => 'border-blue-100'],
    'green'  => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'ring' => 'border-green-100'],
    'amber'  => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'ring' => 'border-amber-100'],
    'red'    => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'ring' => 'border-red-100'],
    'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'ring' => 'border-purple-100'],
    'teal'   => ['bg' => 'bg-teal-50', 'text' => 'text-teal-600', 'ring' => 'border-teal-100'],
];
$c = $map[$color] ?? $map['blue'];
@endphp
<div class="bg-white rounded-2xl border {{ $c['ring'] }} shadow-sm p-5 flex items-center gap-4">
    <div class="{{ $c['bg'] }} {{ $c['text'] }} rounded-xl p-3 flex-shrink-0">
        <x-icon :name="$icon" class="w-6 h-6" />
    </div>
    <div class="min-w-0">
        <p class="text-sm text-slate-500 truncate">{{ $label }}</p>
        <p class="text-2xl font-bold text-slate-800">{{ $value }}</p>
    </div>
</div>