<?php

namespace Modules\Core\Http\Livewire;

trait WithPrefix
{
    public function prefix($prefix)
    {
        $this->props['prefix'] = $prefix . '.';

        return $this;
    }
}
