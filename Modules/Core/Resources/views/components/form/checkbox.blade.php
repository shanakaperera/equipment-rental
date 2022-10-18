@php
    $name = $props['prefix'] . $props['name'];
    $attributes = $attributes->class([
        'form-check-input',
        'is-invalid' => $errors->has($name),
    ])->merge(array_merge($attrs, ['id' => $name]));
@endphp

<div class="{{ $props['switch'] ? 'form-switch' : '' }} {{ !$props['prefix'] ? 'mb-3' : '' }} {{ $attrs['inline'] ? ' form-group row' : 'form-check'}}">

    @if($attrs['inline'])
        <label for="{{ $name }}" class="{{ $attrs['inline'] ? 'form-label col-sm-2 mt-1' : 'form-check-label'}}">
            {{ __($props['label']) }}
        </label>
    @endif

    <div class="input-group {{ $attrs['inline'] ? ' col-sm-10' : ''}}">
        <input {{ $attributes }} wire:model{{ $props['model'] ?? '' }}="data.{{ $name }}">
    </div>

    @if(!$attrs['inline'])
        <label for="{{ $name }}" class="form-check-label">
            {{ __($props['label']) }}
        </label>
    @endif

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @isset($props['help'])
        <div class="form-text">{{ __($props['help']) }}</div>
    @endisset
</div>
