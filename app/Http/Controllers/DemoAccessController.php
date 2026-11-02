<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\DemoInterestAdminNotification;
use App\Mail\DemoInterestThankYou;
use App\Models\DemoAccessLead;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DemoAccessController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if (! config('demo.enabled')) {
            return redirect()->route('login')->withErrors([
                'email' => 'El modo demo no esta disponible en este momento.',
            ], 'demoAccess');
        }

        $rules = [
            'nombre' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ];

        if (! app()->environment('testing')) {
            $rules['g-recaptcha-response'] = ['required', 'captcha'];
        }

        $validated = $request->validateWithBag('demoAccess', $rules);

        $lead = DemoAccessLead::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        try {
            Mail::to($validated['email'])->send(new DemoInterestThankYou($validated['nombre']));

            $adminEmail = config('mail.mail_admin');
            if (is_string($adminEmail) && filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($adminEmail)->send(new DemoInterestAdminNotification(
                    nombreCompleto: $validated['nombre'].' '.$validated['apellidos'],
                    email: $validated['email'],
                    leadId: $lead->id,
                    ipAddress: $lead->ip_address,
                ));
            }
        } catch (\Throwable) {
            // Ignorar errores de envío de correo en la navegación del usuario
        }

        // Asumimos que el tenant demo siempre va a existir
        $tenant = Tenant::query()->where('id', 'demo')->orWhere('code', 'demo')->first();

        if ($tenant) {
            $tenant->run(function () use ($validated) {
                $user = User::query()->firstOrCreate(
                    ['email' => $validated['email']],
                    [
                        'name' => trim($validated['nombre'].' '.$validated['apellidos']),
                        'password' => Hash::make(Str::random(40)),
                        'email_verified_at' => now(),
                        'activo' => true,
                        'fechaAlta' => now()->toDateString(),
                        'uuid' => (string) Str::uuid(),
                    ]
                );

                if (! $user->activo) {
                    $user->update(['activo' => true]);
                }

                if (method_exists($user, 'roles')) {
                    $user->roles()->syncWithoutDetaching([1]);
                }
            });

            $token = Str::random(64);
            Cache::put('demo_autologin_'.$token, [
                'email' => $validated['email'],
                'lead_id' => $lead->id,
            ], now()->addMinutes(15));

            $request->session()->put('demo_email', $validated['email']);

            return redirect()->to(tenant_url('/demo/autologin?token='.$token, $tenant));
        }

        // Fallback para entornos donde no se hayan inicializado tenants (ej. tests unitarios)
        $demoUser = User::query()->firstOrCreate(
            ['email' => (string) config('demo.user_email', $validated['email'])],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make(Str::random(40)),
                'email_verified_at' => now(),
                'activo' => true,
                'fechaAlta' => now()->toDateString(),
                'uuid' => (string) Str::uuid(),
            ]
        );

        if (method_exists($demoUser, 'roles')) {
            $demoUser->roles()->sync([1]);
        }

        Auth::login($demoUser);
        $request->session()->regenerate();
        $request->session()->put('demo_mode', true);
        $request->session()->put('demo_lead_id', $lead->id);

        return redirect()->route('dashboard')->with('status', 'Has accedido en modo demo con acceso completo.');
    }
}
