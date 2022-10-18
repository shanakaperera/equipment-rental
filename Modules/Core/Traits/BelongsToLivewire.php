<?php

namespace Modules\Core\Traits;

use Modules\Core\Contracts\WizardFormContract;

trait BelongsToLivewire
{
    protected WizardFormContract $livewire;

    public function setLivewire(WizardFormContract $livewire)
    {
        $this->livewire = $livewire;

        return $this;
    }

    public function getLivewire(): WizardFormContract
    {
        return $this->livewire;
    }
}
