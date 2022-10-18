@php
    $attributes = $attributes->class([
        'btn btn-' . $props['style'],
        'w-100' => $props['block'],
    ])->merge($attrs);
@endphp

<a {{ $attributes }}>
    @if($props['icon'])
        <i class="{{ $props['icon'] }}"></i>
    @endif

      {{ __($props['label']) }}
</a>
