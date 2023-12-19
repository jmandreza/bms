@props([
    'type' => 'checkbox',
    'disabled' => false,
    'checked' => false,
])


@php
if($type === 'checkbox') {
    $classes = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded shadow-sm transition-all duration-200";
}

else {
    $classes = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all duration-200";
}

@endphp
<input type="{{$type}}" {!! $attributes->merge(['class' => $classes]) !!} {{ $disabled ? 'disabled' : '' }} {{ $checked ? 'checked' : '' }}>
