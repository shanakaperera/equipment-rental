<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Plank\Mediable\Mediable;

class User extends Authenticatable
{
    use LaratrustUserTrait, Notifiable, Mediable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'first_name', 'last_name', 'email', 'password', 'status', 'last_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login'        => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function adminlte_profile_url()
    {
        return '/profile';
    }

    public function avatar()
    {
        return $this->hasMedia('avatar') ? route('media.image.display', $this->firstMedia('avatar')) :
            'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }

}
