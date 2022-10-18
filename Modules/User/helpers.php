<?php

use Modules\User\Entities\Role;
use Modules\User\Entities\User;

if (!function_exists('user')) {
    /**
     * Get the authenticated user.
     *
     * @return User
     */
    function user()
    {
        // Get user from api/web
        if (request()->is('api/*')) {
            $user = app('Dingo\Api\Auth\Auth')->user();
        } else {
            $user = auth()->user();
        }

        return $user;
    }
}

if (!function_exists('roles')) {
    /**
     * Get all roles for dropdown select.
     *
     * @param bool $flip
     * @param bool $no_dev
     * @return array
     */
    function roles($flip = false, $no_dev = true)
    {
        $query = Role::query();

        $query->when($no_dev, function ($q) {
            return $q->whereNotIn('name', ['developer']);
        });

        $array = $query->get()->pluck('display_name', 'id')->toArray();

        return $flip ? array_flip($array) : $array;
    }
}

if (!function_exists('csr_users')) {
    /**
     * Customer service representatives dropdown select.
     *
     * @param bool $flip
     * @param string $csr_role
     * @return array
     */
    function csr_users($flip = false, $csr_role = 'marketing')
    {
        $array = User::whereHas('roles', function ($query) use ($csr_role) {
            $query->where('name', $csr_role);
        })->where('status', 1)->get()->pluck('full_name', 'id')->toArray();

        return $flip ? array_flip($array) : $array;
    }
}
