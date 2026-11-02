<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\TenantAccessCodeRequest;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantAccessController extends Controller
{
    public function index(): View
    {
        return view('central.tenant-access');
    }

    public function store(TenantAccessCodeRequest $request): RedirectResponse
    {
        $code = (string) $request->validated('code');

        $tenant = Tenant::query()
            ->with('domains')
            ->where('code', $code)
            ->first();

        // Si el tenant demo existe pero no tiene dominio, asignarlo
        if ($tenant && strtolower($code) === 'demo' && ! $tenant->domains()->exists()) {
            $centralHost = (string) (request()?->getHost() ?? 'localhost');
            $demoDomain = str_contains($centralHost, 'localhost') ? 'demo.localhost' : 'demo.eband.app';

            try {
                $tenant->domains()->create([
                    'domain' => $demoDomain,
                ]);
            } catch (\Throwable) {
                // Silently handle if already exists
            }

            $tenant->unsetRelation('domains')->load('domains');
        }

        // Autoprovisionar tenant 'demo' si todavía no existe en base de datos
        if (! $tenant && strtolower($code) === 'demo') {
            $centralHost = (string) (request()?->getHost() ?? 'localhost');
            $demoDomain = str_contains($centralHost, 'localhost') ? 'demo.localhost' : 'demo.eband.app';

            try {
                $tenant = Tenant::query()->create([
                    'id' => 'demo',
                    'name' => 'Banda Demo',
                    'code' => 'demo',
                ]);
            } catch (\Throwable) {
                $tenant = Tenant::withoutEvents(function () {
                    return Tenant::query()->firstOrCreate(
                        ['id' => 'demo'],
                        [
                            'name' => 'Banda Demo',
                            'code' => 'demo',
                        ]
                    );
                });
            }

            if (! $tenant->domains()->exists()) {
                $tenant->domains()->create([
                    'domain' => $demoDomain,
                ]);
            }

            $tenant->unsetRelation('domains')->load('domains');
        }

        if (! $tenant) {
            return back()
                ->withInput()
                ->withErrors(['code' => __('Código de grupo no válido.')]);
        }

        $tenantDomain = $tenant->domains->first()?->domain ?? $tenant->domains()->first()?->domain;

        if (! $tenantDomain) {
            return back()
                ->withInput()
                ->withErrors(['code' => __('El grupo existe pero no tiene un dominio configurado todavía.')]);
        }

        if (strtolower($code) === 'demo') {
            $token = Str::random(64);
            $demoEmail = (string) (session('demo_email') ?? 'admin@eband.app');
            Cache::put('demo_autologin_'.$token, [
                'email' => $demoEmail,
            ], now()->addMinutes(15));

            return redirect()->away(tenant_url('/demo/autologin?token='.$token, $tenant));
        }

        return redirect()->away(tenant_url('/login', $tenant));
    }
}
