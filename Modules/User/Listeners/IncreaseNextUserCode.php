<?php

namespace Modules\User\Listeners;

use Modules\User\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\User\Traits\UserSequenceManager;

class IncreaseNextUserCode
{
    use UserSequenceManager;

    /**
     * Handle the event.
     *
     * @param UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        // Update next user code
        $this->increaseNextUserCode();
    }
}
