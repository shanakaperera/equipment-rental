<?php

namespace Modules\Core\View\Components\Form;

use Illuminate\View\Component;
use Modules\Core\Http\Livewire\WithDisabled;
use Modules\Core\Http\Livewire\WithHelp;
use Modules\Core\Http\Livewire\WithModel;
use Modules\Core\Http\Livewire\WithOptions;
use Modules\Core\Http\Livewire\WithPrefix;
use Modules\Core\Http\Livewire\WithSizing;

class Select extends Component
{
    use WithPrefix, WithOptions, WithSizing, WithHelp, WithModel, WithDisabled;

    public $props = [];
    public $attrs = [];

    public static function make($name, $label = null)
    {
        $component = new static;

        $component->props = [
            'name'        => $name,
            'label'       => $label,
            'prefix'      => null,
            'placeholder' => null,
            'options'     => [],
            'small'       => false,
            'large'       => false,
            'help'        => null,
            'model'       => '.defer',
        ];

        $component->attrs = [
            'disabled' => false,
            'inline'   => false,
        ];

        return $component;
    }

    public function placeholder($placeholder)
    {
        $this->props['placeholder'] = $placeholder;

        return $this;
    }

    public function inline($flag = true)
    {
        $this->attrs['inline'] = $flag;

        return $this;
    }

    public function render()
    {
        return view('core::components.form.select');
    }
}
