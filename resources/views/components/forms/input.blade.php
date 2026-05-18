@props(['label', 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'value' => old($name),
        'class' => 'rounded-2xl bg-white/50 backdrop-blur-sm border border-slate-200 px-5 py-4 w-full focus:border-sky-500 focus:ring-4 focus:ring-sky-50/50 transition-all outline-none',
    ];
@endphp

<x-forms.field :$label :$name>
    <input {{ $attributes($defaults) }}>
</x-forms.field>
