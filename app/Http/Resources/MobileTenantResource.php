<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\BandSetting;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Tenant
 */
class MobileTenantResource extends JsonResource
{
    /**
     * @var BandSetting|null
     */
    protected ?BandSetting $bandSetting;

    /**
     * Create a new resource instance.
     */
    public function __construct(Tenant $resource, ?BandSetting $bandSetting = null)
    {
        parent::__construct($resource);
        $this->bandSetting = $bandSetting;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $targetUrl = rtrim(tenant_url('/', $this->resource), '/');
        $loginUrl = tenant_url('/login', $this->resource);

        // Nombre completo desde BandSetting si existe, o el nombre del Tenant
        $fullName = ! empty($this->bandSetting?->nombre)
            ? (string) $this->bandSetting->nombre
            : (string) $this->name;

        // Logo desde BandSetting o fallback
        $logoUrl = null;
        if (! empty($this->bandSetting?->logo)) {
            $logoUrl = tenant_url('/storage/' . ltrim($this->bandSetting->logo, '/'), $this->resource);
        } elseif (! empty($this->data['logo_url'])) {
            $logoUrl = (string) $this->data['logo_url'];
        }

        return [
            'tenant_id' => (string) $this->id,
            'name' => $fullName,
            'short_name' => (string) $this->name,
            'code' => (string) $this->code,
            'target_url' => $targetUrl,
            'login_url' => $loginUrl,
            'logo_url' => $logoUrl,
            'primary_color' => $this->data['primary_color'] ?? '#1e40af',
            'direccion' => $this->bandSetting?->direccion ?: null,
            'telefono' => $this->bandSetting?->telefono ?: null,
            'email' => $this->bandSetting?->email ?: null,
            'website' => $this->bandSetting?->website ?: null,
            'social' => [
                'instagram' => $this->bandSetting?->urlinstagram ?: null,
                'facebook' => $this->bandSetting?->urlfacebook ?: null,
                'tiktok' => $this->bandSetting?->urltiktok ?: null,
            ],
            'onesignal_app_id' => $this->oneSignalAppId() ?: null,
        ];
    }
}
