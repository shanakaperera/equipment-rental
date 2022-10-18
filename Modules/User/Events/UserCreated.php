<?php


namespace Modules\User\Events;

use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param  $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
