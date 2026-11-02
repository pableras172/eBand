<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_renders_successfully_with_saas_features(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // SEO y Encabezados
        $response->assertSee('eBand — El software de gestión para Bandas de Música, Xarangas y Corales');
        $response->assertSee('Corales');
        $response->assertSee('Xarangas');
        $response->assertSee('Bandas');

        // Tarifa Plana 150€
        $response->assertSee('150€');
        $response->assertSee('Tarifa Plana');

        // Formulario de contacto y acceso a demo
        $response->assertSee(route('contact.send'), false);
        $response->assertSee(route('demo.access'), false);

        // JSON-LD Schema
        $response->assertSee('"@type": "SoftwareApplication"', false);
        $response->assertSee('"price": "150.00"', false);
    }
}
