<?php

namespace Modules\Core\View\Components\Form;

use Illuminate\View\Component;

class View extends Component
{
    public $props = [];

    public static function make($name, $data = [])
    {
        $component = new static;

        $component->props = [
            'name' => $name,
            'data' => $data,
        ];

        return $component;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('core::components.form.view');
    }
}
