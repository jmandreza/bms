@props([
    'thead',
    'tbody',
])

<table {{$attributes->merge(['class' => 'w-full table-auto'])}}>
    @if(isset($thead))
        <tr>
            {{$thead}}
        </tr>
    @endif

    @if(isset($tbody))
        {{$tbody}}
    @endif
</table>
