<?php

namespace Modules\Core\View\Components\Form;

use Illuminate\View\Component;
use Modules\Core\Http\Livewire\WithDisabled;
use Modules\Core\Http\Livewire\WithHelp;
use Modules\Core\Http\Livewire\WithModel;
use Modules\Core\Http\Livewire\WithOptions;
use Modules\Core\Http\Livewire\WithPrefix;
use Modules\Core\Http\Livewire\WithSwitch;

class Radio extends Component
{
    use WithPrefix, WithOptions, WithSwitch, WithHelp, WithModel, WithDisabled;

    public $props = [];
    public $attrs = [];

    public static function make($name, $label = null)
    {
        $component = new static;

        $component->props = [
            'name'    => $name,
            'label'   => $label,
            'prefix'  => null,
            'options' => [],
            'switch'  => false,
            'help'    => null,
            'model'   => '.defer',
        ];

        $component->attrs = [
            'type'     => 'radio',
            'disabled' => false,
        ];

        return $component;
    }

    public function render()
    {
        return view('core::components.form.radio');
    }
}
