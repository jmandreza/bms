@props([
    'type' => 'td'
])

@if($type === 'th')
<th {{$attributes->merge(['class' => 'p-2 border border-b-2'])}}>{{$slot}}</th>
@else
<td {{$attributes->merge(['class' => 'p-2 border'])}}>{{$slot}}</td>
@endif