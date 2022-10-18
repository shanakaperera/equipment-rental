@php
    $name = $props['prefix'] . $props['name'];
    $attributes = $attributes->class([
        'form-select',
        'form-select-sm' => $props['small'],
        'form-select-lg' => $props['large'],
        'is-invalid' => $errors->has($name),
    ])->merge(array_merge($attrs, ['id' => $name]));
@endphp

<div class="{{ !$props['prefix'] ? 'mb-3' : '' }} {{ $attrs['inline'] ? ' form-group row' : ''}}">
    @isset($props['label'])
        <label for="{{ $name }}" class="form-label {{ $attrs['inline'] ? ' col-sm-2 mt-1' : ''}}">
            {{ __($props['label']) }}
        </label>
    @endisset

    <div class="input-group {{ $attrs['inline'] ? ' col-sm-10' : ''}}">
        <select {{ $attributes }} wire:model{{ $props['model'] ?? '' }}="data.{{ $name }}">

            @isset($props['placeholder'])
                <option value="">
                    {{ $props['placeholder'] ? __($props['placeholder']) : '' }}
                </option>
            @endif

            @foreach($props['options'] as $value => $label)
                <option value="{{ $value }}">
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @isset($props['help'])
        <div class="form-text">{{ __($props['help']) }}</div>
    @endisset
</div>
