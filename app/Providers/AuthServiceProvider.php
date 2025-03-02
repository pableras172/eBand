<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Policies\UserPolicy;
use App\Policies\TipoActuacionPolicy;
use App\Models\User;
use App\Models\Tipoactuacion;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Tipoactuacion::class => TipoActuacionPolicy::class,

    ];
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();      

        Gate::define('admin', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('SuperAdmin');
        });

        Gate::define('SuperAdmin', function ($user) {
            return $user->hasRole('SuperAdmin');
        });     

        // 🔍 Sobrescribir el email de verificación
        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
            return (new MailMessage)
                ->subject('🔑 Verificación de correo electrónico')
                ->markdown('mail.users.verify-email', [
                    'url' => $verificationUrl,
                    'user' => $notifiable->name,
                ]);
        });

        // 🔐 Sobrescribir el email de restablecimiento de contraseña
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            // Generar la URL correcta
            $emailResetUrl = url("/reset-password/{$token}?email=" . urlencode($notifiable->getEmailForPasswordReset()));

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('🔒 Restablecimiento de contraseña')
                ->markdown('mail.users.reset-password', [
                    'url' => $emailResetUrl,
                    'user' => $notifiable->name,
                ]);
        });
    }
}
