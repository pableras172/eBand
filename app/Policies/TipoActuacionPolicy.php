<?php

namespace App\Policies;

use App\Models\User;

class TipoActuacionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function admin_access(User $user)
    {
        return $user->hasRole('Admin') || $user->hasRole('SuperAdmin');
    }
}
