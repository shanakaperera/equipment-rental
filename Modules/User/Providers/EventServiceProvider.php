<?php

namespace Modules\User\Providers;

use Modules\User\Events\UserCreated;
use Modules\User\Listeners\IncreaseNextUserCode;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreated::class => [
            IncreaseNextUserCode::class,
        ],
    ];
}
