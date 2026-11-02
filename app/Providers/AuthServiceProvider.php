<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\InventoryItem;
use App\Models\Suggestion;
use App\Models\Tipoactuacion;
use App\Models\User;
use App\Policies\AnnouncementPolicy;
use App\Policies\InventoryItemPolicy;
use App\Policies\SuggestionPolicy;
use App\Policies\TipoActuacionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

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
        Suggestion::class => SuggestionPolicy::class,
        InventoryItem::class => InventoryItemPolicy::class,
        Announcement::class => AnnouncementPolicy::class,

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

        Gate::define('admin_access', function ($user) {
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
            $emailResetUrl = tenant_url("/reset-password/{$token}?email=".urlencode($notifiable->getEmailForPasswordReset()));

            return (new MailMessage)
                ->subject('🔒 Restablecimiento de contraseña')
                ->markdown('mail.users.reset-password', [
                    'url' => $emailResetUrl,
                    'user' => $notifiable->name,
                ]);
        });
    }
}
