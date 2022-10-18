@section('title', __($title))

<form class="@if($horizontalForm) form-horizontal @endif">
    @if($formCol)
    <div class="row">

            <div class="{{ $formCol }} mb-2">
    @endif
            @foreach($this->fields() as $field)
                {{ $field->render()->with($field->data()) }}
            @endforeach

            <div class="d-flex justify-content-end gap-2">
                @foreach($this->buttons() as $button)
                    {{ $button->render()->with($button->data()) }}
                @endforeach
            </div>

    @if($formCol)

            </div>
    </div>

    @endif
</form>
