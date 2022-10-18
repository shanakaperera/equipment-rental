<?php

namespace Modules\Core\Http\Livewire;

trait WithSwitch
{
    public function switch()
    {
        $this->props['switch'] = true;

        return $this;
    }
}
