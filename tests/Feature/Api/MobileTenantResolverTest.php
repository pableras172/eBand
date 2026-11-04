<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Tenant;
use Tests\TestCase;

class MobileTenantResolverTest extends TestCase
{
    public function test_resolve_tenant_successfully_with_demo_code(): void
    {
        $response = $this->getJson('/api/v1/mobile/tenants/resolve?code=demo');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'tenant_id',
                'name',
                'code',
                'target_url',
                'login_url',
                'logo_url',
                'primary_color',
                'onesignal_app_id',
            ],
        ]);
    }

    public function test_resolve_tenant_is_case_insensitive_and_trims_whitespace(): void
    {
        $response = $this->getJson('/api/v1/mobile/tenants/resolve?code=  DEMO  ');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'code' => 'demo',
            ],
        ]);
    }

    public function test_resolve_tenant_returns_404_for_unknown_code(): void
    {
        $response = $this->getJson('/api/v1/mobile/tenants/resolve?code=CODIGO-INEXISTENTE-999');

        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
        ]);
    }

    public function test_resolve_tenant_returns_422_when_code_is_missing(): void
    {
        $response = $this->getJson('/api/v1/mobile/tenants/resolve');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['code']);
    }

    public function test_resolve_tenant_returns_403_when_tenant_is_inactive(): void
    {
        $tenantId = 'test-inactive-tenant';
        
        try {
            $tenant = Tenant::query()->create([
                'id' => $tenantId,
                'name' => 'Banda Inactiva',
                'code' => 'INACTIVA',
                'data' => ['is_active' => false],
            ]);
            $tenant->domains()->create(['domain' => 'inactiva.localhost']);

            $response = $this->getJson('/api/v1/mobile/tenants/resolve?code=INACTIVA');

            $response->assertStatus(403);
            $response->assertJson([
                'success' => false,
            ]);
        } finally {
            Tenant::query()->where('id', $tenantId)->delete();
        }
    }
}
