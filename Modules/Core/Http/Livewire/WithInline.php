<?php

namespace Modules\Core\Http\Livewire;

trait WithInline
{
    public function inline($flag)
    {
        $this->attrs['inline'] = $flag;

        return $this;
    }
}
