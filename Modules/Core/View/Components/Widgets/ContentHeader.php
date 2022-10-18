<?php

namespace Modules\Core\View\Components\Widgets;

use Illuminate\View\Component;

class ContentHeader extends Component
{
    public $title;
    public $breadcrumbs;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param array $breadcrumbs
     */
    public function __construct($title, $breadcrumbs = [])
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('core::components.widgets.content-header');
    }
}
