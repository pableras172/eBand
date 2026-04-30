<?php

namespace App\Http\Controllers;

use App\Mail\DemoInterestThankYou;
use App\Models\DemoAccessLead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $validated = $request->validateWithBag('demoAccess', [
            'nombre' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ]);

        $lead = DemoAccessLead::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $demoUser = User::firstOrCreate(
            ['email' => (string) config('demo.user_email')],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make(Str::random(40)),
                'email_verified_at' => now(),
                'activo' => true,
                'fechaAlta' => now()->toDateString(),
                'uuid' => (string) Str::uuid(),
            ]
        );

        $demoUser->roles()->sync([1]);

        Mail::to($validated['email'])->send(new DemoInterestThankYou($validated['nombre']));

        Auth::login($demoUser);
        $request->session()->regenerate();
        $request->session()->put('demo_mode', true);
        $request->session()->put('demo_lead_id', $lead->id);

        return redirect()->route('dashboard')->with('status', 'Has accedido en modo demo con acceso completo.');
    }
}
