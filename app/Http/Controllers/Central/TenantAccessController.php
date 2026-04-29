<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\TenantAccessCodeRequest;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TenantAccessController extends Controller
{
    public function index(): View
    {
        return view('central.tenant-access');
    }

    public function store(TenantAccessCodeRequest $request): RedirectResponse
    {
        $tenant = Tenant::query()
            ->with('domains')
            ->where('code', $request->validated('code'))
            ->first();

        if (! $tenant) {
            return back()
                ->withInput()
                ->withErrors(['code' => __('Código de grupo no válido.')]);
        }

        $tenantDomain = $tenant->domains->first()?->domain;

        if (! $tenantDomain) {
            return back()
                ->withInput()
                ->withErrors(['code' => __('El grupo existe pero no tiene un dominio configurado todavía.')]);
        }

        return redirect()->away(tenant_url('/login', $tenant));
    }
}
