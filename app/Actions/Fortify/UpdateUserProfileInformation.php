<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
{
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        'instrument_id' => ['nullable', 'exists:instruments,id'],
        'telefono' => ['nullable', 'string', 'max:10'],
        'porcentaje' => ['nullable', 'integer'],
        'forastero' => ['nullable', 'boolean'],
        'observaciones' => ['nullable', 'string'],
        'fechaAlta' => ['nullable', 'date'],
        'activo' => ['nullable', 'boolean'],
    ])->validateWithBag('updateProfileInformation');

    if (isset($input['photo'])) {
        $user->updateProfilePhoto($input['photo']);
    }

    if (isset($input['instrument_id'])) {
        $user->forceFill([
            'instrument_id' => $input['instrument_id'],
        ])->save();
    }

    $user->forceFill([
        'name' => $input['name'],
        'email' => $input['email'],
        'telefono' => $input['telefono'] ?? null,
        'porcentaje' => $input['porcentaje'] ?? null,
        'forastero' => $input['forastero'] ?? false,
        'observaciones' => $input['observaciones'] ?? null,
        'fechaAlta' => $input['fechaAlta'] ?? null,
        'activo' => $input['activo'] ?? true,
    ])->save();
}


    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
