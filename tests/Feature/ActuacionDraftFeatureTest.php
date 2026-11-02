<?php

namespace Tests\Feature;

use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Role;
use App\Models\Tipoactuacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActuacionDraftFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Contratos $contrato;

    protected Tipoactuacion $tipoActuacion;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['id' => 1], ['title' => 'Admin']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([$role->id]);
        $this->tipoActuacion = Tipoactuacion::factory()->create(['nombre' => 'Concierto']);
        $this->contrato = Contratos::factory()->create();
    }

    public function test_actuacion_can_be_marked_as_draft(): void
    {
        $this->actingAs($this->admin);

        $actuacion = Actuacion::factory()->create([
            'contratos_id' => $this->contrato->id,
            'tipoactuacions_id' => $this->tipoActuacion->id,
            'is_draft' => true,
        ]);

        $this->assertTrue($actuacion->is_draft);
    }

    public function test_actuacion_can_be_created_as_draft(): void
    {
        $this->actingAs($this->admin);

        $data = [
            'fechaActuacion' => now()->format('Y-m-d'),
            'descripcion' => 'Test Draft Actuacion',
            'tipoactuacions_id' => $this->tipoActuacion->id,
            'contratos_id' => $this->contrato->id,
            'coches' => 1,
            'preciocoche' => 50,
            'musicos' => 5,
            'preciomusico' => 25,
            'is_draft' => '1',
        ];

        $this->post(route('actuacion.store'), $data);

        $actuacion = Actuacion::where('descripcion', 'Test Draft Actuacion')->first();
        $this->assertNotNull($actuacion);
        $this->assertTrue($actuacion->is_draft);
    }

    public function test_actuacion_default_is_not_draft(): void
    {
        $this->actingAs($this->admin);

        $data = [
            'fechaActuacion' => now()->format('Y-m-d'),
            'descripcion' => 'Test Non-Draft Actuacion',
            'tipoactuacions_id' => $this->tipoActuacion->id,
            'contratos_id' => $this->contrato->id,
            'coches' => 1,
            'preciocoche' => 50,
            'musicos' => 5,
            'preciomusico' => 25,
        ];

        $this->post(route('actuacion.store'), $data);

        $actuacion = Actuacion::where('descripcion', 'Test Non-Draft Actuacion')->first();
        $this->assertNotNull($actuacion);
        $this->assertFalse($actuacion->is_draft);
    }

    public function test_actuacion_can_be_updated_to_draft(): void
    {
        $this->actingAs($this->admin);

        $actuacion = Actuacion::factory()->create([
            'contratos_id' => $this->contrato->id,
            'tipoactuacions_id' => $this->tipoActuacion->id,
            'is_draft' => false,
        ]);

        $data = [
            'fechaActuacion' => $actuacion->fechaActuacion instanceof \DateTimeInterface ? $actuacion->fechaActuacion->format('Y-m-d') : (string) $actuacion->fechaActuacion,
            'descripcion' => $actuacion->descripcion,
            'tipoactuacions_id' => $actuacion->tipoactuacions_id,
            'contratos_id' => $actuacion->contratos_id,
            'is_draft' => '1',
        ];

        $this->put(route('actuacion.update', $actuacion), $data);

        $actuacion->refresh();
        $this->assertTrue((bool) $actuacion->is_draft);
    }

    public function test_is_draft_is_cast_to_boolean(): void
    {
        $actuacion = Actuacion::factory()->create([
            'contratos_id' => $this->contrato->id,
            'tipoactuacions_id' => $this->tipoActuacion->id,
            'is_draft' => true,
        ]);

        $this->assertIsBool($actuacion->is_draft);
        $this->assertTrue($actuacion->is_draft);
    }
}
