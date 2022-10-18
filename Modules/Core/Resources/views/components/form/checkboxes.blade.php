@php
    $name = $props['prefix'] . $props['name'];
    $attributes = $attributes->class([
        'form-check-input',
        'is-invalid' => $errors->has($name),
    ]);
@endphp

<div class="{{ !$props['prefix'] ? 'mb-3' : '' }} {{ $attrs['inline'] ? 'row' : ''}}">
    @isset($props['label'])
        <label class="form-label col-2">
            {{ __($props['label']) }}
        </label>
    @endisset

    @if($attrs['select-all'])
        <div class="checkbox {{ $attrs['inline'] ? 'col-2' : ''}}">
            <label for="select_all_{{$name}}"><input id="select_all_{{$name}}" type="checkbox" autocomplete="off"> Select All</label>
        </div>
    @endif

    @if($attrs['inline'])
        <div id="chk_list_{{$name}}" class="col-8">
    @endif

        @foreach($props['options'] as $value => $label)
            <div class="form-check {{ $props['switch'] ? 'form-switch' : '' }}">
                <input {{ $attributes->merge([
                          'id' => $name . '.' . $loop->index,
                          'type' => $attrs['type'],
                          'disabled' => $attrs['disabled'],
                          'value' => $value,
                      ]) }} wire:model{{ $props['model'] ?? '' }}="data.{{ $name }}.{{ $value }}" class="item-select-input">

                <label for="{{ $name . '.' . $loop->index }}" class="form-check-label">
                    {{ __($label) }}
                </label>

                @if($loop->last)
                    @error($name)
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @isset($props['help'])
                        <div class="form-text">{{ __($props['help']) }}</div>
                    @endisset
                @endif
            </div>
        @endforeach

    @if($attrs['inline'])
        </div>
    @endif
</div>

@if($attrs['hr'])
    <hr>
@endif

@if($attrs['select-all'])

    @push('js')
        <script type="text/javascript">

            document.addEventListener('livewire:load', function() {

                document.getElementById('select_all_{{$name}}').onclick = function (evt) {

                    let existing = @this.get('data');

                    if (evt.target.checked) {

                        let perms = JSON.parse('{!! json_encode(array_keys($props['options'])) !!}');
                        let jPerms = {};

                        $.each(perms, function (k, v) {
                            jPerms[v] = v;
                        });

                        if (!jQuery.isEmptyObject(existing)) {

                            existing = JSON.parse(JSON.stringify(@this.get('data')));

                            existing['{{$name}}'] = jPerms;

                            @this.set('data', existing);

                        } else {

                            @this.set('data', {'{{$name}}': jPerms});
                        }

                    } else {

                        existing = JSON.parse(JSON.stringify(@this.get('data')));

                        delete existing['{{$name}}'];

                        @this.set('data', existing);
                    }

                }

                $("#chk_list_{{$name}}").find('input[type="checkbox"]').on('click', function () {

                    let existing = @this.get('data');

                    // uncheck select all checkbox if even one child checkbox is unchecked
                    if (!this.checked) {
                        document.getElementById('select_all_{{$name}}').checked = false;

                        existing = JSON.parse(JSON.stringify(@this.get('data')));

                        delete existing['{{$name}}'][this.value];

                        @this.set('data', existing);

                    } else {

                        // check select all checkbox if all the child checkboxes are selected
                        if ($("#chk_list_{{$name}}").find('input[type="checkbox"]').not(':checked').length == 0) {
                            document.getElementById('select_all_{{$name}}').checked = true;
                        }

                        existing = JSON.parse(JSON.stringify(@this.get('data')));

                        if (jQuery.isEmptyObject(existing)) {
                            let val = this.value;
                            if (jQuery.type(existing['{{$name}}']) === "undefined") {
                                existing = {'{{$name}}': {[val] : val}};
                            } else {
                                existing['{{$name}}'][val] = val;
                            }
                        } else {
                            let val = this.value;
                            if (jQuery.type(existing['{{$name}}']) === "undefined") {
                                existing['{{$name}}'] = {[val]: val};
                            } else {
                                existing['{{$name}}'][this.value] = this.value;
                            }
                        }

                        @this.set('data', existing);

                    }

                });

            });

        </script>
    @endpush

@endif
