<?php

namespace Modules\User\Traits;

trait UserSequenceManager
{
    /**
     * Generate next user code
     *
     * @return string
     */
    public function getNextUserCode()
    {
        $prefix = setting('user.code_prefix', 'U-');
        $next = setting('user.code_next', '1');
        $digit = setting('user.code_digit', '5');

        $code = $prefix . str_pad($next, $digit, '0', STR_PAD_LEFT);

        return $code;
    }

    /**
     * Increase the next user code
     */
    public function increaseNextUserCode()
    {
        $next = setting('user.code_next', 1) + 1;

        setting(['user.code_next' => $next])->save();
    }

    /**
     * Get user logged in
     *
     * @return object
     */
    public function getCurrentUser()
    {
        return user();
    }
}
