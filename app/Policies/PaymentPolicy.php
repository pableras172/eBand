<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Payment;

class PaymentPolicy
{
    public function viewAny(User $user, User $owner = null): bool
    {
        return $user->hasRole('Admin') || $user->id === $owner->id;
    }

    public function view(User $user, Payment $payment): bool
    {
        return $user->hasRole('Admin') || $user->id === $payment->users_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    public function update(User $user, Payment $payment): bool
    {
        return $user->hasRole('Admin') || $user->id === $payment->users_id;
    }

    public function delete(User $user, Payment $payment): bool
    {
        return $user->hasRole('Admin');
    }

    public function restore(User $user, Payment $payment): bool
    {
        return $user->hasRole('Admin');
    }

    public function forceDelete(User $user, Payment $payment): bool
    {
        return $user->hasRole('Admin');
    }
}
