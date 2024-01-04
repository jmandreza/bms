@props([
    'align' => 'right',
])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'ltr:origin-top-left rtl:origin-top-right start-0';
        break;
    case 'right':
    default:
        $alignmentClasses = 'ltr:origin-top-right rtl:origin-top-left end-0';
        break;
}
@endphp

<div x-data="{filterOpen : false}" class="relative">
    <div x-data x-on:click="filterOpen = !filterOpen">
        {{$trigger}}
    </div>
        
    <div class="absolute z-10 mt-2 w-64 {{$alignmentClasses}}">
        <div x-cloak x-show="filterOpen"
            x-on:click.outside="filterOpen = false"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4" 
            class="w-full py-1 space-y-1 bg-white rounded-md ring-1 ring-black ring-opacity-5 shadow-lg overflow-y-hidden z-20 transition-all duration-150">
            {{$content ?? $slot}}
        </div>
    </div>
</div> 