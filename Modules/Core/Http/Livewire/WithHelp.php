<?php

namespace Modules\Core\Http\Livewire;

trait WithHelp
{
    public function help($help)
    {
        $this->props['help'] = $help;

        return $this;
    }
}
