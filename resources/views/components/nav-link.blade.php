@props(['active' => false, 'icon' => null, 'subnav' => false])

@php
    $classes = $active
        ? 'bg-sky-600 text-white shadow-lg shadow-sky-100 flex items-center gap-3 px-5 py-4 rounded-2xl font-black transition-all duration-300'
        : ($subnav
            ? 'text-slate-500 hover:text-sky-600 hover:bg-slate-50 flex items-center gap-3 px-5 py-3 rounded-xl font-bold transition-all duration-200'
            : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50 flex items-center gap-3 px-5 py-4 rounded-2xl font-bold transition-all duration-300');

    $iconClasses = $active ? 'text-white' : 'text-slate-400 group-hover:text-sky-600';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' group']) }}>
    @if ($icon)
        <i class="bi {{ $icon }} {{ $iconClasses }} {{ $subnav ? 'text-sm' : 'text-lg' }} transition-colors"></i>
    @endif
    <span class="{{ $subnav ? 'text-xs' : 'text-sm' }}">{{ $slot }}</span>
</a>
