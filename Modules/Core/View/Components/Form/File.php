<?php

namespace Modules\Core\View\Components\Form;

use Illuminate\View\Component;
use Modules\Core\Http\Livewire\WithDisabled;
use Modules\Core\Http\Livewire\WithHelp;
use Modules\Core\Http\Livewire\WithPrefix;

class File extends Component
{
    use WithPrefix, WithHelp, WithDisabled;

    public $props = [];
    public $attrs = [];

    public static function make($name, $label = null)
    {
        $component = new static;

        $component->props = [
            'name'   => $name,
            'label'  => $label,
            'prefix' => null,
            'disk'   => config('filesystems.default'),
            'help'   => null,
        ];

        $component->attrs = [
            'type'     => 'file',
            'multiple' => false,
            'disabled' => false,
        ];

        return $component;
    }

    public function disk($disk)
    {
        $this->props['disk'] = $disk;

        return $this;
    }

    public function multiple()
    {
        $this->attrs['multiple'] = true;

        return $this;
    }

    public function render()
    {
        return view('core::components.form.file');
    }
}
