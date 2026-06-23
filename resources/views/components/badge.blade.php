@props(['color' => 'gray'])
@php
$map = [
    'green' => 'bg-green-100 text-green-700',
    'red'   => 'bg-red-100 text-red-700',
    'blue'  => 'bg-blue-100 text-blue-700',
    'amber' => 'bg-amber-100 text-amber-700',
    'gray'  => 'bg-gray-100 text-gray-600',
];
$cls = $map[$color] ?? $map['gray'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold whitespace-nowrap $cls"]) }}>
    {{ $slot }}
</span>