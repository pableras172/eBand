<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDemoInformationRequest;
use App\Mail\DemoInformationRequestNotification;
use App\Models\DemoAccessLead;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class DemoInformationRequestController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (! request()->session()->get('demo_mode')) {
            return redirect()->route('dashboard');
        }

        $user = request()->user();
        $lead = DemoAccessLead::query()->find(request()->session()->get('demo_lead_id'));

        return view('demo.information-request', [
            'defaultNombreApellidos' => trim((string) ($lead?->nombre.' '.$lead?->apellidos)) ?: (string) ($user?->name ?? ''),
            'defaultEmailContacto' => (string) ($lead?->email ?? $user?->email ?? ''),
            'defaultTelefonoContacto' => (string) ($user?->telefono ?? ''),
        ]);
    }

    public function store(StoreDemoInformationRequest $request): RedirectResponse
    {
        $adminEmail = config('mail.mail_admin');

        if (! is_string($adminEmail) || ! filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            return redirect()
                ->route('demo.info.create')
                ->with('error', 'No se ha podido enviar la solicitud en este momento.');
        }

        $validated = $request->validated();

        Mail::to($adminEmail)->send(new DemoInformationRequestNotification(
            nombreApellidos: $validated['nombre_apellidos'],
            emailContacto: $validated['email_contacto'],
            telefonoContacto: $validated['telefono_contacto'],
            nombreBanda: $validated['nombre_banda'] ?: null,
            numeroMusicos: isset($validated['numero_musicos']) ? (int) $validated['numero_musicos'] : null,
            notas: $validated['notas'],
        ));

        return redirect()
            ->route('demo.info.create')
            ->with('success', 'Solicitud enviada correctamente. Te contactaremos pronto.');
    }
}
