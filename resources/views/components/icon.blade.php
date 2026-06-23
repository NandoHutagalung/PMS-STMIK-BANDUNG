@props(['name', 'class' => 'w-5 h-5'])
@php
$paths = [
    'home' => '<path d="M3 11l9-7 9 7"/><path d="M5 10v9h14v-9"/><path d="M9 19v-5h6v5"/>',
    'target' => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="0.8" fill="currentColor"/>',
    'clipboard-check' => '<rect x="6" y="4" width="12" height="17" rx="2"/><path d="M9 4V3a1 1 0 011-1h4a1 1 0 011 1v1"/><polyline points="9 13 11 15 15 10"/>',
    'chat' => '<path d="M4 5h16v11H8l-4 4V5z"/>',
    'flag' => '<path d="M5 3v18"/><path d="M5 4h11l-2 4 2 4H5z"/>',
    'document-text' => '<path d="M7 3h7l4 4v13a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1z"/><path d="M14 3v4h4"/><line x1="9" y1="12.5" x2="15" y2="12.5"/><line x1="9" y1="16" x2="15" y2="16"/>',
    'presentation' => '<rect x="3" y="4" width="18" height="12" rx="1"/><path d="M8 20h8"/><path d="M12 16v4"/><polyline points="7 12 10 8 13 11 17 6"/>',
    'academic-cap' => '<path d="M12 3l9 5-9 5-9-5 9-5z"/><path d="M7 11v5c0 1.5 2.5 3 5 3s5-1.5 5-3v-5"/>',
    'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="3" y1="13" x2="21" y2="13"/>',
    'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="8" y1="3" x2="8" y2="7"/><line x1="16" y1="3" x2="16" y2="7"/>',
    'users' => '<circle cx="9" cy="8" r="3"/><path d="M3 19c0-3 2.5-5 6-5s6 2 6 5"/><circle cx="17" cy="9" r="2.3"/><path d="M15.5 14.2c2.4.2 4.2 1.9 4.2 4.8"/>',
    'user-circle' => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.5 18.5c1-2.5 3-3.5 5.5-3.5s4.5 1 5.5 3.5"/>',
    'logout' => '<path d="M9 4H6a2 2 0 00-2 2v12a2 2 0 002 2h3"/><polyline points="14 8 19 12 14 16"/><line x1="19" y1="12" x2="9" y2="12"/>',
    'bell' => '<path d="M6 9a6 6 0 1112 0v5l1.5 3h-15L6 14V9z"/><path d="M9.5 19a2.5 2.5 0 005 0"/>',
    'search' => '<circle cx="11" cy="11" r="6"/><line x1="20" y1="20" x2="15.5" y2="15.5"/>',
    'pencil' => '<path d="M4 17.5V20h2.5L19 7.5 16.5 5 4 17.5z"/><line x1="14.3" y1="7.2" x2="16.8" y2="9.7"/>',
    'trash' => '<path d="M5 7h14"/><path d="M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2"/><path d="M7 7l1 13a1 1 0 001 1h6a1 1 0 001-1l1-13"/>',
    'plus' => '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
    'chevron-down' => '<polyline points="6 9 12 15 18 9"/>',
    'menu' => '<line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>',
    'x' => '<line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/>',
    'check-circle' => '<circle cx="12" cy="12" r="9"/><polyline points="8 12.5 11 15.5 16 9"/>',
    'star' => '<path d="M12 3l2.4 5.3 5.8.6-4.4 3.9 1.3 5.7-5.1-3-5.1 3 1.3-5.7-4.4-3.9 5.8-.6L12 3z"/>',
    'arrow-down' => '<polyline points="6 10 12 16 18 10"/>',
    'arrow-up' => '<polyline points="6 14 12 8 18 14"/>',
    'refresh' => '<path d="M4 4v5h5"/><path d="M20 20v-5h-5"/><path d="M5.5 9A7 7 0 0119 11"/><path d="M18.5 15A7 7 0 015 13"/>',
    'building' => '<rect x="4" y="3" width="16" height="18" rx="1"/><line x1="9" y1="7" x2="9" y2="7.01"/><line x1="15" y1="7" x2="15" y2="7.01"/><line x1="9" y1="11" x2="9" y2="11.01"/><line x1="15" y1="11" x2="15" y2="11.01"/><line x1="9" y1="15" x2="9" y2="15.01"/><line x1="15" y1="15" x2="15" y2="15.01"/>',
];
$path = $paths[$name] ?? $paths['target'];
@endphp
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->merge(['class' => $class]) }}>{!! $path !!}</svg>