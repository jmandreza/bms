@props([
    'size' => 50,
    'key'    
])

<div>
    {!! QrCode::backgroundColor(255, 255, 255, 0)->errorCorrection('H')->errorCorrection('H')->size($size)->generate($key) !!}
</div>