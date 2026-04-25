@props(['active' => false, 'icon' => null])

@php
    $classes = $active
        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100 flex items-center gap-3 px-5 py-4 rounded-2xl font-black transition-all duration-300'
        : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50 flex items-center gap-3 px-5 py-4 rounded-2xl font-bold transition-all duration-300';

    $iconClasses = $active ? 'text-white' : 'text-slate-400 group-hover:text-indigo-600';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' group']) }}>
    @if ($icon)
        <i class="bi {{ $icon }} {{ $iconClasses }} text-lg transition-colors"></i>
    @endif
    <span class="text-sm">{{ $slot }}</span>
</a>
