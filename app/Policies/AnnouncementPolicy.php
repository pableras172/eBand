<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AnnouncementPolicy
{
    public function before(User $user, $ability)
    {
        if (Gate::forUser($user)->allows('admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Announcement $announcement): bool
    {
        if (! $announcement->is_active) {
            return false;
        }

        if ($announcement->starts_at->isFuture()) {
            return false;
        }

        if ($announcement->ends_at && $announcement->ends_at->isPast()) {
            return false;
        }

        if ($announcement->applies_to_all) {
            return true;
        }

        return $announcement->instruments()->where('instruments.id', $user->instrument_id ?? 0)->exists();
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Announcement $announcement): bool
    {
        return false;
    }

    public function delete(User $user, Announcement $announcement): bool
    {
        return false;
    }

    public function restore(User $user, Announcement $announcement): bool
    {
        return false;
    }

    public function forceDelete(User $user, Announcement $announcement): bool
    {
        return false;
    }
}
