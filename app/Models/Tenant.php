<?php

namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;
    use HasDomains;

    protected $fillable = [
        'id',
        'name',
        'code',
        'custom_domain',
        'data',
    ];

    /**
     * Columns stored directly in the tenants table instead of the data JSON column.
     *
     * @return array<int, string>
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'code',
            'custom_domain',
        ];
    }

    /**
     * Get OneSignal app ID for this tenant.
     */
    public function oneSignalAppId(): string
    {
        return (string) ($this->data['onesignal_app_id'] ?? config('services.onesignal.app_id'));
    }

    /**
     * Get OneSignal API key for this tenant.
     */
    public function oneSignalApiKey(): string
    {
        return (string) ($this->data['onesignal_api_key'] ?? config('services.onesignal.api_key'));
    }

    /**
     * Set OneSignal credentials for this tenant.
     */
    public function setOneSignalCredentials(string $appId, string $apiKey): self
    {
        $this->data = array_merge($this->data ?? [], [
            'onesignal_app_id' => $appId,
            'onesignal_api_key' => $apiKey,
        ]);

        return $this;
    }
}
