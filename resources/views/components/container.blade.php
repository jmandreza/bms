@props([
    'bg' => 'bg-white',
])

<div {{$attributes->merge(['class' => "w-full px-4 sm:px-6 py-6 $bg shadow-sm sm:rounded-lg"])}} class="">
    {{$slot}}
</div>