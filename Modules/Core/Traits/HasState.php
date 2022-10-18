<?php

namespace Modules\Core\Traits;

trait HasState
{
    public array $state = [];

    public function getState(): array
    {
        return $this->state;
    }

    public function setState(array $state)
    {
        $this->state = $state;
        return $this;
    }

    public function mergeState(array $state)
    {
        $this->state = array_merge($this->state, $state);
        return $this;
    }

    public function putState($key, $value = null, $default = null)
    {
        data_set($this->state, $key, $value, $default);
        return $this;
    }
}
