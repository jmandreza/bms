@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'error text-sm text-red-600']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@else
    <div {{ $attributes->merge(['class' => 'error hidden text-sm text-red-600']) }}>
        {{$slot}}
    </div>
@endif
