<?php

namespace Tests\Feature;

use Tests\TestCase;

class TenantAccessTest extends TestCase
{
    public function test_tenant_access_page_loads_with_preloaded_demo_code(): void
    {
        $response = $this->get('/acceso');

        $response->assertStatus(200);
        $response->assertSee('value="demo"', false);
        $response->assertSee('demo');
        $response->assertSee('Acceso a tu Agrupación');
    }

    public function test_tenant_access_store_redirects_for_demo_code(): void
    {
        $response = $this->post('/tenant/access', [
            'code' => 'demo',
        ]);

        $response->assertStatus(302);
        $response->assertRedirectContains('/login');
    }
}
