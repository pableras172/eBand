<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasInfoLeadRequest;
use App\Mail\MasInfoLeadAdminNotification;
use App\Models\BandSetting;
use App\Models\DemoAccessLead;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class MasInfoController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (! $this->isContactInfoEnabled()) {
            return redirect()->route('welcome');
        }

        return view('public.masinfo');
    }

    public function store(StoreMasInfoLeadRequest $request): RedirectResponse
    {
        if (! $this->isContactInfoEnabled()) {
            return redirect()->route('welcome');
        }

        $validated = $request->validated();
        [$nombre, $apellidos] = $this->splitFullName($validated['nombre_apellidos']);

        $lead = DemoAccessLead::query()->create([
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $validated['email_contacto'],
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'lead_type' => $validated['interes'] === 'busco_banda' ? 'quiero_presupuesto' : 'mas_info',
            'source' => 'masinfo',
            'entidad' => $validated['entidad'] ?? null,
            'municipio' => $validated['municipio'] ?? null,
            'telefono_contacto' => $validated['telefono_contacto'],
            'mensaje' => $validated['mensaje'] ?? null,
        ]);

        $adminEmail = config('mail.mail_admin');

        if (is_string($adminEmail) && filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            Mail::to($adminEmail)->send(new MasInfoLeadAdminNotification(
                tipoSolicitud: $validated['interes'] === 'busco_banda' ? 'Quiero un presupuesto' : 'Mas informacion',
                nombreCompleto: trim($nombre.' '.$apellidos),
                emailContacto: $validated['email_contacto'],
                telefonoContacto: $validated['telefono_contacto'],
                entidad: $validated['entidad'] ?? null,
                municipio: $validated['municipio'] ?? null,
                mensaje: $validated['mensaje'] ?? null,
                leadId: $lead->id,
                ipAddress: $lead->ip_address,
            ));
        }

        $message = $validated['interes'] === 'busco_banda'
            ? 'Gracias por contactar. Nos hace ilusion participar y en breve te contactaremos para preparar el presupuesto.'
            : 'Gracias por interesarte en eBand. En breve te contactaremos para ayudarte con todo lo que necesiteis.';

        return redirect()
            ->route('masinfo.create')
            ->with('success', $message);
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function splitFullName(string $fullName): array
    {
        $nameParts = preg_split('/\s+/', trim($fullName)) ?: [];

        if (count($nameParts) <= 1) {
            return [$fullName, '-'];
        }

        $nombre = (string) array_shift($nameParts);
        $apellidos = implode(' ', $nameParts);

        return [$nombre, $apellidos !== '' ? $apellidos : '-'];
    }

    private function isContactInfoEnabled(): bool
    {
        return (bool) BandSetting::query()->value('activarcontactoinfo');
    }
}
