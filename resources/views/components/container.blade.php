@props([
    'bg' => 'bg-white',
    'padding' => 'px-2 sm:px-4 md:px-6 lg:px-8 py-6'
])

@php
    if($bg !== 'bg-transparent') {
        $bg .= ' shadow-md';
    }
@endphp



<div {{$attributes->merge(['class' => "w-full $padding $bg sm:rounded-lg"])}}>
    {{$slot}}
</div>