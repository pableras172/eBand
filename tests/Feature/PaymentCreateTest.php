<?php

namespace Tests\Feature;

use App\Livewire\Payment\PaymentCreate;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class PaymentCreateTest extends TestCase
{
    public function test_payment_create_screen_can_be_rendered(): void
    {
        tenancy()->initialize('demo');
        $admin = User::whereHas('roles', fn ($q) => $q->where('title', 'Admin'))->first() ?? User::first();

        $response = $this->actingAs($admin)->get('/payments/create');
        $response->assertStatus(200);
        $response->assertSee(__('Generar Nova Liquidació'));
        $response->assertSee(__('Paràmetres de la liquidació'));
        $response->assertSee(__('Previsualització d\'actuacions'));
    }

    public function test_payment_create_livewire_component_queries_actuaciones(): void
    {
        tenancy()->initialize('demo');
        $admin = User::whereHas('roles', fn ($q) => $q->where('title', 'Admin'))->first() ?? User::first();

        Livewire::actingAs($admin)
            ->test(PaymentCreate::class)
            ->set('form.fechaInicio', '2026-01-01')
            ->set('form.fechaFin', '2026-12-31')
            ->set('form.users_id', '0')
            ->call('consultarActuaciones')
            ->assertSet('form.users_id', '0')
            ->assertSee(__('Previsualització d\'actuacions'));
    }
}
