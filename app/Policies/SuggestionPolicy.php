<?php

namespace App\Policies;

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class SuggestionPolicy
{
    use HandlesAuthorization;

    /**
     * Before hook: allow admins to do everything.
     */
    public function before(User $user, $ability)
    {
        if (Gate::forUser($user)->allows('admin')) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        // Any authenticated user can access the index view,
        // but component will filter results (user vs admin).
        return (bool) $user;
    }

    public function view(User $user, Suggestion $suggestion)
    {
        return $user->id === $suggestion->iduser;
    }

    public function create(User $user)
    {
        return (bool) $user;
    }

    public function update(User $user, Suggestion $suggestion)
    {
        return $user->id === $suggestion->iduser;
    }

    public function delete(User $user, Suggestion $suggestion)
    {
        return $user->id === $suggestion->iduser;
    }
}
