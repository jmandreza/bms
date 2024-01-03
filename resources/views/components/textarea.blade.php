@props([])

<textarea {{ $attributes->merge(['name' => '', 'id' => '', 'class' => 'w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm resize-none', 'cols' => '20', 'rows' => '5']) }} name="" id="" cols="30" rows="10">{{$slot}}</textarea>