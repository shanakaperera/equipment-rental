<?php

namespace Modules\Core\View\Components\Form;

use Illuminate\View\Component;
use Modules\Core\Http\Livewire\WithDisabled;
use Modules\Core\Http\Livewire\WithHelp;
use Modules\Core\Http\Livewire\WithModel;
use Modules\Core\Http\Livewire\WithPrefix;
use Modules\Core\Http\Livewire\WithSwitch;

class CheckBox extends Component
{
    use WithPrefix, WithSwitch, WithHelp, WithModel, WithDisabled;

    public $props = [];
    public $attrs = [];

    public static function make($name, $label)
    {
        $component = new static;

        $component->props = [
            'name'   => $name,
            'label'  => $label,
            'prefix' => null,
            'switch' => false,
            'help'   => null,
            'model'  => '.defer',
        ];

        $component->attrs = [
            'type'     => 'checkbox',
            'disabled' => false,
            'inline'   => false,
        ];

        return $component;
    }

    public function inline($flag = true)
    {
        $this->attrs['inline'] = $flag;

        return $this;
    }

    public function render()
    {
        return view('core::components.form.checkbox');
    }
}
