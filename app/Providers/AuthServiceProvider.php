<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definir Gate para el rol de administrador
        Gate::define('admin', function ($user) {
            return $user->hasRole('Admin');
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
