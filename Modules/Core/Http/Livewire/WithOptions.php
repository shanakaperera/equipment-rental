<?php

namespace Modules\Core\Http\Livewire;

use Illuminate\Support\Arr;

trait WithOptions
{
    public function options($options)
    {
        if (Arr::isAssoc($options)) {
            $this->props['options'] = $options;
        } else {
            $this->props['options'] = array_combine($options, $options);
        }

        return $this;
    }
}
