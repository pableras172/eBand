<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

if (! function_exists('tenant_name')) {
    /**
     * Get the current tenant name or fallback to app.banda config.
     */
    function tenant_name(?string $default = null): string
    {
        if ($tenant = tenant()) {
            return $tenant->name;
        }

        return $default ?? config('app.banda', 'eBand');
    }
}

if (! function_exists('tenant_primary_domain')) {
    /**
     * Get the primary domain for the current tenant.
     */
    function tenant_primary_domain(?Tenant $tenant = null): ?string
    {
        $tenant ??= tenant();

        if (! $tenant) {
            return null;
        }

        if ($tenant->relationLoaded('domains')) {
            return $tenant->domains->first()?->domain;
        }

        return $tenant->domains()->first()?->domain;
    }
}

if (! function_exists('tenant_url')) {
    /**
     * Build an absolute URL for the current tenant when one is initialized.
     */
    function tenant_url(string $path = '/', ?Tenant $tenant = null): string
    {
        $tenant ??= tenant();

        if (! $tenant) {
            return url($path);
        }

        $domain = tenant_primary_domain($tenant);

        if (! $domain) {
            return url($path);
        }

        $scheme = request()?->getScheme() ?: parse_url((string) config('app.url'), PHP_URL_SCHEME) ?: 'http';

        return sprintf('%s://%s/%s', $scheme, $domain, ltrim($path, '/'));
    }
}

if (! function_exists('tenant_route')) {
    /**
     * Build a tenant-aware URL for a named route, falling back to a path when needed.
     *
     * @param  array<string, mixed>  $parameters
     */
    function tenant_route(string $route, array $parameters = [], ?string $fallbackPath = null, ?Tenant $tenant = null): string
    {
        if (! Route::has($route)) {
            return tenant_url($fallbackPath ?? '/', $tenant);
        }

        return tenant_url(route($route, $parameters, false), $tenant);
    }
}

if (! function_exists('tenant_onesignal_app_id')) {
    /**
     * Get the OneSignal app ID for the current tenant.
     */
    function tenant_onesignal_app_id(): string
    {
        if ($tenant = tenant()) {
            return $tenant->oneSignalAppId();
        }

        return (string) config('services.onesignal.app_id', '');
    }
}

if (! function_exists('tenant_onesignal_api_key')) {
    /**
     * Get the OneSignal API key for the current tenant.
     */
    function tenant_onesignal_api_key(): string
    {
        if ($tenant = tenant()) {
            return $tenant->oneSignalApiKey();
        }

        return (string) config('services.onesignal.rest_api_key', '');
    }
}
