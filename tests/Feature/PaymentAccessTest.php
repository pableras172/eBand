<?php

namespace Tests\Feature;

use App\Livewire\Payment\PaymentEdit;
use App\Livewire\Payment\PaymentListasUsersDetail;
use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Tipoactuacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PaymentAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function ensureBaseRoles(): void
    {
        Role::query()->upsert([
            ['id' => 1, 'title' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'User', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'title' => 'SuperAdmin', 'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['title', 'updated_at']);
    }

    protected function createPaymentForUser(User $user, array $overrides = []): Payment
    {
        return Payment::create(array_merge([
            'users_id' => $user->id,
            'fechaPago' => Carbon::now(),
            'descripcion' => 'Liquidació '.$user->name,
            'fechaInicio' => Carbon::now()->subMonth(),
            'fechaFin' => Carbon::now(),
            'totalPago' => 120.50,
            'confirmadausuaroi' => false,
            'paymentresume_id' => 1,
            'observaciones' => null,
        ], $overrides));
    }

    public function test_admin_can_access_payments_index(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->roles()->sync([1]); // Admin

        $musician = User::factory()->create(['name' => 'Musician Uno']);
        $this->createPaymentForUser($musician);

        $this->actingAs($admin)
            ->get(route('payments.index'))
            ->assertOk()
            ->assertSee('Musician Uno');
    }

    public function test_musician_can_access_payments_index_and_sees_own_payments(): void
    {
        $this->ensureBaseRoles();

        $musician = User::factory()->create(['name' => 'Musician Personal']);
        $musician->roles()->sync([2]); // User / Musician

        $otherMusician = User::factory()->create(['name' => 'Other Musician']);
        $otherMusician->roles()->sync([2]);

        $this->createPaymentForUser($musician);
        $this->createPaymentForUser($otherMusician);

        // Al acceder a /payments directamente, no debe dar 403 y debe ver su propio nombre
        $this->actingAs($musician)
            ->get(route('payments.index'))
            ->assertOk()
            ->assertSee('Musician Personal')
            ->assertDontSee('Other Musician');
    }

    public function test_musician_can_access_own_payments_user_route(): void
    {
        $this->ensureBaseRoles();

        $musician = User::factory()->create(['name' => 'Musician Propio']);
        $musician->roles()->sync([2]);

        $this->createPaymentForUser($musician);

        $this->actingAs($musician)
            ->get(route('payments.user', $musician))
            ->assertOk()
            ->assertSee('Musician Propio');
    }

    public function test_musician_cannot_access_other_musician_payments(): void
    {
        $this->ensureBaseRoles();

        $musician = User::factory()->create();
        $musician->roles()->sync([2]);

        $otherMusician = User::factory()->create();
        $otherMusician->roles()->sync([2]);

        $this->actingAs($musician)
            ->get(route('payments.user', $otherMusician))
            ->assertForbidden();
    }

    public function test_parent_can_access_child_payments(): void
    {
        $this->ensureBaseRoles();

        $parent = User::factory()->create();
        $parent->roles()->sync([2]);

        $child = User::factory()->create(['name' => 'Menor Fill', 'parent_id' => $parent->id]);
        $child->roles()->sync([2]);

        $this->createPaymentForUser($child);

        $this->actingAs($parent)
            ->get(route('payments.user', $child))
            ->assertOk()
            ->assertSee('Menor Fill');
    }

    public function test_musician_can_confirm_payment(): void
    {
        $this->ensureBaseRoles();

        $musician = User::factory()->create();
        $musician->roles()->sync([2]);

        $payment = $this->createPaymentForUser($musician, ['confirmadausuaroi' => false]);

        Livewire::actingAs($musician)
            ->test(PaymentEdit::class, ['payment' => $payment])
            ->call('confirm')
            ->assertDispatched('confirmed');

        $this->assertTrue((bool) $payment->fresh()->confirmadausuaroi);
    }

    public function test_musician_requires_observaciones_to_mark_not_confirmed(): void
    {
        $this->ensureBaseRoles();

        $musician = User::factory()->create();
        $musician->roles()->sync([2]);

        $payment = $this->createPaymentForUser($musician, ['confirmadausuaroi' => true]);

        // Sin observaciones -> errorobservaciones
        Livewire::actingAs($musician)
            ->test(PaymentEdit::class, ['payment' => $payment])
            ->set('form.observaciones', '')
            ->call('noConfirmar')
            ->assertDispatched('errorobservaciones');

        $this->assertTrue((bool) $payment->fresh()->confirmadausuaroi);

        // Con observaciones -> se marca no confirmada (pendiente)
        Livewire::actingAs($musician)
            ->test(PaymentEdit::class, ['payment' => $payment])
            ->set('form.observaciones', 'Falta el pagament del cotxe')
            ->call('noConfirmar')
            ->assertDispatched('notconfirmed');

        $this->assertFalse((bool) $payment->fresh()->confirmadausuaroi);
        $this->assertEquals('Falta el pagament del cotxe', $payment->fresh()->observaciones);
    }

    public function test_admin_can_update_supplements_and_recalculates_totals(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $musician = User::factory()->create();
        $musician->roles()->sync([2]);

        $tipo = Tipoactuacion::factory()->create(['nombre' => 'Concert']);
        $contrato = Contratos::factory()->create();

        $actuacion = Actuacion::factory()->create([
            'descripcion' => 'Concert de Santa Cecília',
            'fechaActuacion' => Carbon::now(),
            'tipoactuacions_id' => $tipo->id,
            'contratos_id' => $contrato->id,
            'preciomusico' => 50.00,
            'preciocoche' => 20.00,
            'preciofurgona' => 30.00,
            'noaplicapago' => 0,
            'aplicaporcentaje' => 0,
        ]);

        $lista = Listas::create([
            'actuacions_id' => $actuacion->id,
            'pagada' => 1,
            'cuentas' => 1,
        ]);

        $payment = $this->createPaymentForUser($musician, ['totalPago' => 50.00]);

        $listaUser = ListasUser::create([
            'listas_id' => $lista->id,
            'user_id' => $musician->id,
            'payment_id' => $payment->id,
            'disponible' => true,
            'coche' => false,
            'furgona' => false,
            'totalActuacion' => 50.00,
            'totalCoche' => 0.00,
            'totalFurgo' => 0.00,
            'totalActo' => 50.00,
            'pagada' => true,
            'cuentas' => true,
        ]);

        // Modificar suplemento coche a true
        Livewire::actingAs($admin)
            ->test(PaymentListasUsersDetail::class, ['payment' => $payment])
            ->call('editListasUser', $listaUser->id)
            ->set('form.coche', true)
            ->call('save')
            ->assertDispatched('listas-user-updated');

        $listaUser->refresh();
        $this->assertTrue((bool) $listaUser->coche);
        $this->assertEquals(20.00, (float) $listaUser->totalCoche);
        $this->assertEquals(70.00, (float) $listaUser->totalActo);
        $this->assertEquals(70.00, (float) $payment->fresh()->totalPago);
    }

    public function test_admin_can_resolve_incidence(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $musician = User::factory()->create();
        $musician->roles()->sync([2]);

        $payment = $this->createPaymentForUser($musician, [
            'confirmadausuaroi' => false,
            'observaciones' => 'No tinc el cotxe registrat',
        ]);

        Livewire::actingAs($admin)
            ->test(PaymentEdit::class, ['payment' => $payment])
            ->call('resolverIncidencia')
            ->assertDispatched('incidencia-resuelta');

        $payment->refresh();
        $this->assertTrue((bool) $payment->confirmadausuaroi);
        $this->assertStringContainsString('Incidència resolta', $payment->observaciones);
    }

    public function test_admin_can_open_and_save_actuacion_prices_modal(): void
    {
        $this->ensureBaseRoles();

        $admin = User::factory()->create();
        $admin->roles()->sync([1]);

        $musician = User::factory()->create(['porcentaje' => 100]);
        $musician->roles()->sync([2]);

        $tipo = Tipoactuacion::factory()->create();
        $contrato = Contratos::factory()->create();

        $actuacion = Actuacion::factory()->create([
            'descripcion' => 'Concert de Primavera',
            'fechaActuacion' => Carbon::now(),
            'tipoactuacions_id' => $tipo->id,
            'contratos_id' => $contrato->id,
            'preciomusico' => 50.00,
            'preciocoche' => 10.00,
            'preciofurgona' => 20.00,
            'noaplicapago' => 0,
            'aplicaporcentaje' => 0,
        ]);

        $lista = Listas::firstOrCreate(
            ['actuacions_id' => $actuacion->id],
            ['pagada' => 1, 'cuentas' => 1]
        );

        $payment = $this->createPaymentForUser($musician, ['totalPago' => 60.00]);

        $listaUser = ListasUser::create([
            'listas_id' => $lista->id,
            'user_id' => $musician->id,
            'payment_id' => $payment->id,
            'disponible' => true,
            'coche' => true,
            'furgona' => false,
            'totalActuacion' => 50.00,
            'totalCoche' => 10.00,
            'totalFurgo' => 0.00,
            'totalActo' => 60.00,
            'pagada' => true,
            'cuentas' => true,
        ]);

        Livewire::actingAs($admin)
            ->test(PaymentListasUsersDetail::class, ['payment' => $payment])
            ->call('openActuacionPriceModal', $actuacion->id, $listaUser->id)
            ->assertSet('showingActuacionPriceModal', true)
            ->assertSet('editingActuacionPagosCount', 1)
            ->set('editingPrecioMusico', 80.00)
            ->set('editingPrecioCoche', 15.00)
            ->set('editingPrecioFurgona', 40.00)
            ->set('editingMusicoFurgona', true)
            ->call('saveActuacionPrices')
            ->assertDispatched('actuacion-prices-updated')
            ->assertSet('showingActuacionPriceModal', false);

        $actuacion->refresh();
        $this->assertEquals(80.00, (float) $actuacion->preciomusico);
        $this->assertEquals(15.00, (float) $actuacion->preciocoche);
        $this->assertEquals(40.00, (float) $actuacion->preciofurgona);

        $listaUser->refresh();
        $this->assertEquals(80.00, (float) $listaUser->totalActuacion);
        $this->assertEquals(15.00, (float) $listaUser->totalCoche);
        $this->assertEquals(40.00, (float) $listaUser->totalFurgo);
        $this->assertEquals(135.00, (float) $listaUser->totalActo);
        $this->assertEquals(135.00, (float) $payment->fresh()->totalPago);
    }
}
