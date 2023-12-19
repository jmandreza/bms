@props(['value', 'associate' => true])


@if($associate)
<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
@else
<p {{ $attributes->merge(['class' => 'block font-semibold text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</p>
@endif
