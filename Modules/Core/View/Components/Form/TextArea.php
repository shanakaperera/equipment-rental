<?php

namespace Modules\Core\View\Components\Form;

use Illuminate\View\Component;
use Modules\Core\Http\Livewire\WithDisabled;
use Modules\Core\Http\Livewire\WithHelp;
use Modules\Core\Http\Livewire\WithModel;
use Modules\Core\Http\Livewire\WithPlaceholder;
use Modules\Core\Http\Livewire\WithPrefix;
use Modules\Core\Http\Livewire\WithReadonly;
use Modules\Core\Http\Livewire\WithSizing;

class TextArea extends Component
{
    use WithPrefix, WithSizing, WithHelp, WithModel, WithDisabled, WithReadonly, WithPlaceholder;

    public $props = [];
    public $attrs = [];

    public static function make($name, $label = null)
    {
        $component = new static;

        $component->props = [
            'name'   => $name,
            'label'  => $label,
            'prefix' => null,
            'small'  => false,
            'large'  => false,
            'help'   => null,
            'model'  => '.defer',
        ];

        $component->attrs = [
            'rows'     => 3,
            'disabled' => false,
            'readonly' => false,
        ];

        return $component;
    }

    public function rows($rows = 3)
    {
        $this->attrs['rows'] = $rows;

        return $this;
    }

    public function render()
    {
        return view('core::components.form.textarea');
    }
}
