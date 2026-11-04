<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\ResolveTenantRequest;
use App\Http\Resources\MobileTenantResource;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class MobileTenantResolverController extends Controller
{
    /**
     * Resolve and validate a tenant code for the mobile application.
     */
    public function resolve(ResolveTenantRequest $request): JsonResponse
    {
        $code = $request->validatedCode();

        $tenant = Tenant::query()
            ->with('domains')
            ->where(function ($query) use ($code) {
                $query->where('code', $code)
                    ->orWhereRaw('LOWER(code) = ?', [strtolower($code)]);
            })
            ->first();

        // Autoprovisionar o asignar dominio al tenant 'demo' si aplica
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
                $tenant = Tenant::query()->where('code', 'demo')->orWhere('id', 'demo')->first();
            }

            if ($tenant && ! $tenant->domains()->exists()) {
                $tenant->domains()->create([
                    'domain' => $demoDomain,
                ]);
            }

            $tenant?->unsetRelation('domains')->load('domains');
        } elseif ($tenant && strtolower($code) === 'demo' && ! $tenant->domains()->exists()) {
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

        if (! $tenant) {
            return response()->json([
                'success' => false,
                'message' => __('No se ha encontrado ninguna agrupación con el código proporcionado.'),
            ], 404);
        }

        $tenantDomain = $tenant->domains->first()?->domain ?? $tenant->domains()->first()?->domain;

        if (! $tenantDomain) {
            return response()->json([
                'success' => false,
                'message' => __('La agrupación existe pero aún no tiene un dominio asignado.'),
            ], 422);
        }

        if (isset($tenant->data['is_active']) && ! $tenant->data['is_active']) {
            return response()->json([
                'success' => false,
                'message' => __('El acceso a esta agrupación se encuentra suspendido.'),
            ], 403);
        }

        $bandSetting = null;
        try {
            $bandSetting = $tenant->run(function () {
                return \App\Models\BandSetting::query()->first();
            });
            Log::info('[MobileTenantResolver] BandSetting resolved successfully', [
                'tenant_id' => $tenant->id,
                'band_setting_found' => (bool) $bandSetting,
                'nombre' => $bandSetting?->nombre,
                'logo' => $bandSetting?->logo,
                'direccion' => $bandSetting?->direccion,
                'urlinstagram' => $bandSetting?->urlinstagram,
            ]);
        } catch (\Throwable $e) {
            Log::error('[MobileTenantResolver] Error retrieving BandSetting', [
                'tenant_id' => $tenant->id,
                'error' => $e->getMessage(),
            ]);
        }

        $resourceData = (new MobileTenantResource($tenant, $bandSetting))->resolve();

        Log::info('[MobileTenantResolver] Returning payload to mobile app', [
            'code' => $code,
            'payload' => $resourceData,
        ]);

        return response()->json([
            'success' => true,
            'data' => $resourceData,
        ]);
    }
}
