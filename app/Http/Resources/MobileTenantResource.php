<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Tenant
 */
class MobileTenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $targetUrl = rtrim(tenant_url('/', $this->resource), '/');
        $loginUrl = tenant_url('/login', $this->resource);

        return [
            'tenant_id' => (string) $this->id,
            'name' => (string) $this->name,
            'code' => (string) $this->code,
            'target_url' => $targetUrl,
            'login_url' => $loginUrl,
            'logo_url' => $this->data['logo_url'] ?? null,
            'primary_color' => $this->data['primary_color'] ?? '#1e40af',
            'onesignal_app_id' => $this->oneSignalAppId() ?: null,
        ];
    }
}
