<div {{ $attributes->merge(['class' => $makeCardClass()]) }}>

    {{-- Profile header --}}
    <div class="{{ $makeHeaderClass() }}" style="{{ $makeHeaderStyle() }}">

        {{-- User image --}}
        <div class="widget-user-image">
            @if(isset($img))
                <img class="img-circle elevation-2" src="{{ $img }}" alt="User avatar: {{ $attributes->has('alt') ? $attributes['alt'] : $name }}"
                     @if($attributes->has('with-upload')) style="width: 130px" @endif>
            @elseif($layoutType === 'modern')
                <div class="img-circle elevation-2 d-flex bg-dark" style="width:90px;height:90px;">
                    <i class="fas fa-3x fa-user text-silver m-auto"></i>
                </div>
            @elseif($layoutType === 'classic')
                <div class="img-circle elevation-2 float-left d-flex bg-dark" style="width:65px;height:65px;">
                    <i class="fas fa-2x fa-user text-silver m-auto"></i>
                </div>
            @endisset
        </div>

        {{-- User name --}}
        @isset($name)
            <h3 class="widget-user-username mb-0">{{ $name }}</h3>
        @endisset

        {{-- User description --}}
        @isset($desc)
            <h5 class="widget-user-desc">{{ $desc }}</h5>
        @endisset

    </div>

    @if($attributes->has('with-upload'))

        <div
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
            <div style="height: 150px; position: relative;" class="row d-flex justify-content-center">
                <label for="file-upload" style="position: absolute; bottom: 10px;" class="btn btn-success ml-4">Upload New</label>
                <input wire:model="{{ $attributes['with-upload'] }}" type="file" id="file-upload" class="d-none">
            </div>

            @error('photo') <p class="text-red text-center">{{ $message }}</p> @enderror

            <div x-show="isUploading">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-success" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        </div>

    @endif

    {{-- Profile footer / Profile Items --}}
    @if(! $slot->isEmpty())
        <div class="{{ $makeFooterClass() }}">
            <div class="row">{{ $slot }}</div>
        </div>
    @endif
</div>
