<?php

namespace App\Policies;

use App\Models\InventoryItem;
use App\Models\User;

class InventoryItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver el listado
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InventoryItem $inventoryItem): bool
    {
        if ($user->hasRole('SuperAdmin') || $user->hasRole('Admin')) {
            return true;
        }

        return $inventoryItem->responsables()->where('users.id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('SuperAdmin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasRole('SuperAdmin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasRole('SuperAdmin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasRole('SuperAdmin') || $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InventoryItem $inventoryItem): bool
    {
        return $user->hasRole('SuperAdmin') || $user->hasRole('Admin');
    }
}
