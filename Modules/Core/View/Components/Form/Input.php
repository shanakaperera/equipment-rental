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

class Input extends Component
{
    use WithPrefix, WithSizing, WithHelp, WithModel, WithDisabled, WithReadonly, WithPlaceholder;

    public $props = [];
    public $attrs = [];

    public static function make($name, $label = null)
    {
        $component = new static;

        $component->props = [
            'name'      => $name,
            'label'     => $label,
            'prefix'    => null,
            'append'    => null,
            'prepend'   => null,
            'plaintext' => false,
            'small'     => false,
            'large'     => false,
            'help'      => null,
            'model'     => '.defer',
        ];

        $component->attrs = [
            'type'      => 'text',
            'inputmode' => 'text',
            'disabled'  => false,
            'readonly'  => false,
            'inline'    => false,
        ];

        return $component;
    }

    public function type($type)
    {
        $this->attrs['type'] = $type;

        if ($type == 'text') {
            $this->attrs['inputmode'] = 'text';
        } else if ($type == 'number') {
            $this->attrs['inputmode'] = 'numeric';
        } else if ($type == 'tel') {
            $this->attrs['inputmode'] = 'tel';
        } else if ($type == 'search') {
            $this->attrs['inputmode'] = 'search';
        } else if ($type == 'email') {
            $this->attrs['inputmode'] = 'email';
        } else if ($type == 'url') {
            $this->attrs['inputmode'] = 'url';
        }

        return $this;
    }

    public function append($append)
    {
        $this->props['append'] = $append;

        return $this;
    }

    public function prepend($prepend)
    {
        $this->props['prepend'] = $prepend;

        return $this;
    }

    public function plaintext($plaintext = true)
    {
        $this->props['plaintext'] = $plaintext;
        $this->attrs['readonly'] = $plaintext;

        return $this;
    }

    public function inline($flag = true)
    {
        $this->attrs['inline'] = $flag;

        return $this;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('core::components.form.input');
    }
}
