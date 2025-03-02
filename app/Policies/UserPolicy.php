<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function admin_access(User $user)
    {
        return $user->hasRole('Admin') || $user->hasRole('SuperAdmin');
    }
}
