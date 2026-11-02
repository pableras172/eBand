<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DemoAutologinController extends Controller
{
    /**
     * Iniciar sesión automáticamente en el espacio demo mediante token de un solo uso.
     */
    public function autologin(Request $request): RedirectResponse
    {
        $token = (string) $request->query('token');

        if ($token === '') {
            return redirect()->route('login');
        }

        $cacheKey = 'demo_autologin_'.$token;
        /** @var array{email?: string, lead_id?: int}|null $data */
        $data = Cache::pull($cacheKey);

        if (! is_array($data) || empty($data['email'])) {
            return redirect()->route('login')->with('status', 'El enlace de acceso ha caducado. Puedes acceder usando el botón de acceso directo a la demo.');
        }

        $email = (string) $data['email'];

        $user = User::query()->where('email', $email)->first()
            ?? User::query()->where('email', 'admin@eband.app')->first()
            ?? User::query()->first();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => 'No se ha encontrado el usuario de demostración.',
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->put('demo_mode', true);

        if (isset($data['lead_id'])) {
            $request->session()->put('demo_lead_id', $data['lead_id']);
        }

        return redirect()->route('dashboard')->with('status', '¡Bienvenido/a a la demo de eBand!');
    }

    /**
     * Acceso rápido de un solo clic desde la pantalla de login del tenant demo.
     */
    public function quickLogin(Request $request): RedirectResponse
    {
        $isDemoTenant = function_exists('tenant') && (tenant('id') === 'demo' || tenant('code') === 'demo');

        if (! $isDemoTenant && ! app()->environment('testing')) {
            abort(403, 'Acceso restringido al entorno demo.');
        }

        $user = User::query()->where('email', 'admin@eband.app')->first()
            ?? User::query()->first();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => 'No se ha encontrado el usuario administrador demo.',
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->put('demo_mode', true);

        return redirect()->route('dashboard')->with('status', 'Has accedido a la demo como Administrador.');
    }
}
