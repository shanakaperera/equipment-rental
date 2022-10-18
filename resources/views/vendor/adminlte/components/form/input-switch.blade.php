@extends('adminlte::components.form.input-group-component')

@section('input_group_item')

    {{-- Input Switch --}}
    @if(!config('adminlte.alpine'))
        <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="true" {{ $attributes->merge(['class' => $makeItemClass()]) }}>
    @else
        <div
            x-data="{ value: @entangle($attributes->wire('model')) }"
            x-init="
                sw = $($refs.switch).bootstrapSwitch( @json($config) );
                sw.on('switchChange.bootstrapSwitch', function(event, state) { value = state; });
                $watch('value', (value) => { $($refs.switch).bootstrapSwitch('state', value); });
            "
            wire:ignore
        >
            <input x-ref="switch" type="checkbox" {{ $attributes->merge(['class' => $makeItemClass()]) }}>
        </div>
    @endif
@overwrite

{{-- Add plugin initialization and configuration code --}}

@push('js')
    @if(!config('adminlte.alpine'))
        <script>

            $(() => {
                $('#{{ $id }}').bootstrapSwitch( @json($config) );

                // Add support to auto select the previous submitted value in case of
                // validation errors.

                @if($errors->any() && $enableOldSupport)
                    let oldState = @json((bool)$getOldValue($errorKey));
                    $('#{{ $id }}').bootstrapSwitch('state', oldState);
                @endif
            })

        </script>
    @endif
@endpush

{{-- Setup the height/font of the plugin when using sm/lg sizes --}}
{{-- NOTE: this may change with newer plugin versions --}}

@once
@push('css')
<style type="text/css">

    {{-- MD (default) size setup --}}
    .input-group .bootstrap-switch-handle-on,
    .input-group .bootstrap-switch-handle-off {
        height: 2.25rem !important;
    }

    {{-- LG size setup --}}
    .input-group-lg .bootstrap-switch-handle-on,
    .input-group-lg .bootstrap-switch-handle-off {
        height: 2.875rem !important;
        font-size: 1.25rem !important;
    }

    {{-- SM size setup --}}
    .input-group-sm .bootstrap-switch-handle-on,
    .input-group-sm .bootstrap-switch-handle-off {
        height: 1.8125rem !important;
        font-size: .875rem !important;
    }

    {{-- Custom invalid style setup --}}

    .adminlte-invalid-iswgroup > .bootstrap-switch-wrapper,
    .adminlte-invalid-iswgroup > .input-group-prepend > *,
    .adminlte-invalid-iswgroup > .input-group-append > * {
        box-shadow: 0 .25rem 0.5rem rgba(255,0,0,.25);
    }

</style>
@endpush
@endonce
