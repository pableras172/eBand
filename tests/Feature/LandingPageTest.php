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
        $response->assertSee('eBand — El software de gestión para Bandas de Música, Charangas y Corales');
        $response->assertSee('Charangas');
        $response->assertSee('Bandas');
        $response->assertSee('Corales');

        // Nuevas funcionalidades requeridas
        $response->assertSee('Control Parental');
        $response->assertSee('Actividades Extra');
        $response->assertSee('Disponible');
        $response->assertSee('Inventario de Uniformes y Material');

        // Partituras NO debe aparecer
        $response->assertDontSee('archivo de partituras digital', false);
        $response->assertDontSee('Repertorio sincronizado', false);

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
