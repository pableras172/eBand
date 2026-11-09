<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Exports\ActividadInscritosExport;
use App\Livewire\Actividades\ActividadDetalle;
use App\Livewire\Actividades\Admin\ActividadAdminDetail;
use App\Models\Actividad;
use App\Models\ActividadInscripcion;
use App\Models\ActividadInscripcionItem;
use App\Models\ActividadOpcion;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ActividadInscripcionTest extends TestCase
{
    use RefreshDatabase;

    protected function ensureBaseRoles(): void
    {
        Role::query()->insertOrIgnore([
            ['id' => 1, 'title' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'User', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    protected function createAdminUser(): User
    {
        $this->ensureBaseRoles();
        $admin = User::factory()->create();
        $admin->roles()->attach(1);

        return $admin;
    }

    protected function createRegularUser(): User
    {
        $this->ensureBaseRoles();
        $user = User::factory()->create();
        $user->roles()->attach(2);

        return $user;
    }

    public function test_non_admin_cannot_access_admin_actividades(): void
    {
        $user = $this->createRegularUser();

        $this->actingAs($user)
            ->get(route('admin.actividades.index'))
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_actividades(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin)
            ->get(route('admin.actividades.index'))
            ->assertOk();
    }

    public function test_musician_sees_open_activity_and_can_inscribe(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Cena Santa Cecilia',
            'tipo' => 'cena',
            'descripcion' => 'Cena de celebración',
            'lugar' => 'Restaurante Central',
            'fecha' => Carbon::now()->addDays(5),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(3),
            'estado' => 'abierta',
            'instrucciones_pago' => 'Bizum al 600000000',
        ]);

        $opcionCarne = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Carne',
            'precio' => 25.00,
            'orden' => 1,
        ]);

        $opcionInfantil = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Infantil',
            'precio' => 12.00,
            'orden' => 2,
        ]);

        // Verificar listado público
        $this->actingAs($user)
            ->get(route('actividades.index'))
            ->assertOk()
            ->assertSee('Cena Santa Cecilia');

        // Probar inscripción vía Livewire
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->set("cantidades.{$opcionCarne->id}", 2)
            ->set("cantidades.{$opcionInfantil->id}", 1)
            ->set('observaciones_alergias', '1 menú sin cebolla')
            ->call('inscribirme')
            ->assertHasNoErrors();

        // Comprobar persistencia
        $this->assertDatabaseHas('actividad_inscripciones', [
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'total' => 62.00, // (2 * 25) + (1 * 12) = 62.00
            'observaciones_alergias' => '1 menú sin cebolla',
            'pagado' => false,
        ]);

        $this->assertDatabaseCount('actividad_inscripcion_items', 2);
    }

    public function test_musician_cannot_register_twice_for_same_activity(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Comida Primavera',
            'tipo' => 'comida',
            'fecha' => Carbon::now()->addDays(10),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(8),
            'estado' => 'abierta',
        ]);

        $opcion = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Único',
            'precio' => 20.00,
            'orden' => 1,
        ]);

        // Primera inscripción
        ActividadInscripcion::query()->create([
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'fecha_inscripcion' => now(),
            'total' => 20.00,
            'pagado' => false,
        ]);

        // Intentar inscribirse de nuevo debe mostrar ya inscrito
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->assertSee(__('actividades.already_inscribed'))
            ->assertDontSee(__('actividades.confirm_registration'));
    }

    public function test_musician_can_modify_selected_options_and_menus(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Cena Patronal',
            'tipo' => 'cena',
            'fecha' => Carbon::now()->addDays(10),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(5),
            'estado' => 'abierta',
        ]);

        $opcionCarne = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Carne',
            'precio' => 25.00,
            'orden' => 1,
        ]);

        $opcionPescado = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Pescado',
            'precio' => 25.00,
            'orden' => 2,
        ]);

        $inscripcion = ActividadInscripcion::query()->create([
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'fecha_inscripcion' => Carbon::now()->subDay(),
            'total' => 25.00,
            'asiste' => true,
            'pagado' => false,
            'observaciones_alergias' => 'Ninguna',
        ]);

        ActividadInscripcionItem::query()->create([
            'actividad_inscripcion_id' => $inscripcion->id,
            'actividad_opcion_id' => $opcionCarne->id,
            'cantidad' => 1,
            'precio_unitario' => 25.00,
            'subtotal' => 25.00,
        ]);

        // El músico abre la vista, ve el botón de modificar y cambia de Menú Carne a Menú Pescado
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->assertSee(__('actividades.modify_options'))
            ->call('modificarOpciones')
            ->assertSet('cambiandoRespuesta', true)
            ->assertSet("cantidades.{$opcionCarne->id}", 1)
            ->assertSet("cantidades.{$opcionPescado->id}", 0)
            ->set("cantidades.{$opcionCarne->id}", 0)
            ->set("cantidades.{$opcionPescado->id}", 1)
            ->set('observaciones_alergias', 'Alérgico a mariscos')
            ->call('inscribirme')
            ->assertHasNoErrors()
            ->assertSet('cambiandoRespuesta', false);

        // Comprobar que en la base de datos se ha actualizado
        $this->assertDatabaseHas('actividad_inscripciones', [
            'id' => $inscripcion->id,
            'user_id' => $user->id,
            'total' => 25.00,
            'observaciones_alergias' => 'Alérgico a mariscos',
        ]);

        $this->assertDatabaseCount('actividad_inscripcion_items', 1);
        $this->assertDatabaseHas('actividad_inscripcion_items', [
            'actividad_inscripcion_id' => $inscripcion->id,
            'actividad_opcion_id' => $opcionPescado->id,
            'cantidad' => 1,
            'subtotal' => 25.00,
        ]);
        $this->assertDatabaseMissing('actividad_inscripcion_items', [
            'actividad_opcion_id' => $opcionCarne->id,
        ]);
    }

    public function test_modifying_options_with_different_total_resets_paid_status(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Comida de Navidad',
            'tipo' => 'comida',
            'fecha' => Carbon::now()->addDays(12),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(6),
            'estado' => 'abierta',
        ]);

        $opcion = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú',
            'precio' => 30.00,
            'orden' => 1,
        ]);

        $inscripcion = ActividadInscripcion::query()->create([
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'fecha_inscripcion' => Carbon::now()->subDays(2),
            'total' => 30.00,
            'asiste' => true,
            'pagado' => true,
            'metodo_pago' => 'bizum',
            'fecha_pago' => Carbon::now()->subDay(),
        ]);

        ActividadInscripcionItem::query()->create([
            'actividad_inscripcion_id' => $inscripcion->id,
            'actividad_opcion_id' => $opcion->id,
            'cantidad' => 1,
            'precio_unitario' => 30.00,
            'subtotal' => 30.00,
        ]);

        // Modifica a 2 menús (total 60.00 €)
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->call('modificarOpciones')
            ->set("cantidades.{$opcion->id}", 2)
            ->call('inscribirme')
            ->assertHasNoErrors();

        // El estado de pago debe resetearse a pendiente
        $this->assertDatabaseHas('actividad_inscripciones', [
            'id' => $inscripcion->id,
            'total' => 60.00,
            'pagado' => false,
            'metodo_pago' => null,
            'fecha_pago' => null,
        ]);
    }

    public function test_modifying_options_with_same_total_preserves_paid_status(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Cena de Verano',
            'tipo' => 'cena',
            'fecha' => Carbon::now()->addDays(15),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(8),
            'estado' => 'abierta',
        ]);

        $opcionA = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Opción A',
            'precio' => 20.00,
            'orden' => 1,
        ]);

        $opcionB = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Opción B',
            'precio' => 20.00,
            'orden' => 2,
        ]);

        $inscripcion = ActividadInscripcion::query()->create([
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'fecha_inscripcion' => Carbon::now()->subDays(2),
            'total' => 20.00,
            'asiste' => true,
            'pagado' => true,
            'metodo_pago' => 'transferencia',
            'fecha_pago' => Carbon::now()->subDay(),
        ]);

        ActividadInscripcionItem::query()->create([
            'actividad_inscripcion_id' => $inscripcion->id,
            'actividad_opcion_id' => $opcionA->id,
            'cantidad' => 1,
            'precio_unitario' => 20.00,
            'subtotal' => 20.00,
        ]);

        // Cambiar de opción A a opción B (mismo importe 20€)
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->call('modificarOpciones')
            ->set("cantidades.{$opcionA->id}", 0)
            ->set("cantidades.{$opcionB->id}", 1)
            ->call('inscribirme')
            ->assertHasNoErrors();

        // El pago debe mantenerse pagado y con su método
        $this->assertDatabaseHas('actividad_inscripciones', [
            'id' => $inscripcion->id,
            'total' => 20.00,
            'pagado' => true,
            'metodo_pago' => 'transferencia',
        ]);
    }

    public function test_musician_cannot_modify_options_when_deadline_passed(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Cena Pasada',
            'tipo' => 'cena',
            'fecha' => Carbon::now()->addDays(5),
            'fecha_limite_inscripcion' => Carbon::now()->subHour(), // Ya cerrada
            'estado' => 'abierta',
        ]);

        $opcion = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú',
            'precio' => 20.00,
            'orden' => 1,
        ]);

        $inscripcion = ActividadInscripcion::query()->create([
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'fecha_inscripcion' => Carbon::now()->subDays(2),
            'total' => 20.00,
            'asiste' => true,
            'pagado' => false,
        ]);

        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->call('modificarOpciones')
            ->assertHasErrors(['error' => __('actividades.error_closed')]);
    }

    public function test_musician_can_cancel_modifying_options_restoring_selection(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Cena de Prueba',
            'tipo' => 'cena',
            'fecha' => Carbon::now()->addDays(5),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(2),
            'estado' => 'abierta',
        ]);

        $opcion = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú',
            'precio' => 20.00,
            'orden' => 1,
        ]);

        $inscripcion = ActividadInscripcion::query()->create([
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'fecha_inscripcion' => Carbon::now()->subDays(1),
            'total' => 20.00,
            'asiste' => true,
            'pagado' => false,
            'observaciones_alergias' => 'Sin gluten',
        ]);

        ActividadInscripcionItem::query()->create([
            'actividad_inscripcion_id' => $inscripcion->id,
            'actividad_opcion_id' => $opcion->id,
            'cantidad' => 1,
            'precio_unitario' => 20.00,
            'subtotal' => 20.00,
        ]);

        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->call('modificarOpciones')
            ->set("cantidades.{$opcion->id}", 3)
            ->set('observaciones_alergias', 'Cambio temporal')
            ->call('cancelarEdicion')
            ->assertSet('cambiandoRespuesta', false)
            ->assertSet("cantidades.{$opcion->id}", 1)
            ->assertSet('observaciones_alergias', 'Sin gluten')
            ->assertSet('totalCalculado', 20.00);
    }

    public function test_admin_can_export_actividad_to_excel(): void
    {
        Excel::fake();
        $admin = $this->createAdminUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Excursión a Valencia',
            'tipo' => 'excursion',
            'fecha' => Carbon::now()->addDays(20),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(15),
            'estado' => 'abierta',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.actividades.export', $actividad))
            ->assertOk();

        Excel::assertDownloaded("actividad_excursion-a-valencia_{$actividad->fecha->format('Ymd')}.xlsx", function (ActividadInscritosExport $export): bool {
            return true;
        });
    }

    public function test_admin_can_send_onesignal_notification_for_activity(): void
    {
        $admin = $this->createAdminUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Cena de Navidad',
            'tipo' => 'cena',
            'fecha' => Carbon::now()->addDays(15),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(10),
            'estado' => 'abierta',
        ]);

        \OneSignal::shouldReceive('sendNotificationToSegment')
            ->once()
            ->andReturn(null);

        Livewire::actingAs($admin)
            ->test(ActividadAdminDetail::class, ['actividadId' => $actividad->id])
            ->call('notificarOneSignal')
            ->assertHasNoErrors();

        $this->assertNotNull($actividad->fresh()->notified_at);
    }

    public function test_admin_can_inscribe_registered_musician(): void
    {
        $admin = $this->createAdminUser();
        $musician = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Comida de Santa Cecilia',
            'tipo' => 'comida',
            'fecha' => Carbon::now()->addDays(10),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(5),
            'estado' => 'abierta',
        ]);

        $opcionAdulto = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Adulto',
            'precio' => 25.00,
            'orden' => 1,
        ]);

        $opcionNino = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Infantil',
            'precio' => 12.00,
            'orden' => 2,
        ]);

        Livewire::actingAs($admin)
            ->test(ActividadAdminDetail::class, ['actividadId' => $actividad->id])
            ->call('openCreateInscripcionModal')
            ->set('tipoAsistente', 'miembro')
            ->set('selectedUserId', $musician->id)
            ->set("cantidades.{$opcionAdulto->id}", 2)
            ->set("cantidades.{$opcionNino->id}", 2)
            ->set('observaciones_alergias', 'Uno de los niños es celíaco')
            ->set('marcarPagado', true)
            ->set('metodoPago', 'efectivo')
            ->call('guardarInscripcion')
            ->assertHasNoErrors()
            ->assertSet('showingInscripcionModal', false);

        $this->assertDatabaseHas('actividad_inscripciones', [
            'actividad_id' => $actividad->id,
            'user_id' => $musician->id,
            'total' => 74.00, // 2*25 + 2*12
            'pagado' => true,
            'metodo_pago' => 'efectivo',
            'observaciones_alergias' => 'Uno de los niños es celíaco',
        ]);
    }

    public function test_admin_can_inscribe_guest_without_app_account(): void
    {
        $admin = $this->createAdminUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Comida Fin de Curso',
            'tipo' => 'comida',
            'fecha' => Carbon::now()->addDays(10),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(5),
            'estado' => 'abierta',
        ]);

        $opcion = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú Único',
            'precio' => 20.00,
            'orden' => 1,
        ]);

        Livewire::actingAs($admin)
            ->test(ActividadAdminDetail::class, ['actividadId' => $actividad->id])
            ->call('openCreateInscripcionModal')
            ->set('tipoAsistente', 'manual')
            ->set('nombreManual', 'Vicente Gómez (músico honorífico)')
            ->set("cantidades.{$opcion->id}", 3)
            ->set('marcarPagado', false)
            ->call('guardarInscripcion')
            ->assertHasNoErrors()
            ->assertSet('showingInscripcionModal', false);

        $this->assertDatabaseHas('actividad_inscripciones', [
            'actividad_id' => $actividad->id,
            'user_id' => null,
            'nombre_manual' => 'Vicente Gómez (músico honorífico)',
            'total' => 60.00,
            'pagado' => false,
        ]);

        $inscripcion = ActividadInscripcion::query()
            ->where('nombre_manual', 'Vicente Gómez (músico honorífico)')
            ->firstOrFail();

        $this->assertEquals('Vicente Gómez (músico honorífico)', $inscripcion->nombre_completo);
    }

    public function test_musician_can_indicate_not_attending(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Cena de Primavera',
            'tipo' => 'cena',
            'fecha' => Carbon::now()->addDays(10),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(5),
            'estado' => 'abierta',
        ]);

        $opcion = ActividadOpcion::query()->create([
            'actividad_id' => $actividad->id,
            'titulo' => 'Menú',
            'precio' => 20.00,
            'orden' => 1,
        ]);

        // El músico indica que no va
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->call('indicarNoVoy')
            ->assertHasNoErrors()
            ->assertSee(__('actividades.declined_card_title'));

        $this->assertDatabaseHas('actividad_inscripciones', [
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'asiste' => false,
            'total' => 0.00,
        ]);

        // Cambiar de opinión y apuntarse con un menú
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->call('toggleCambiarRespuesta')
            ->set("cantidades.{$opcion->id}", 1)
            ->call('inscribirme')
            ->assertHasNoErrors()
            ->assertSee(__('actividades.registration_summary'));

        $this->assertDatabaseHas('actividad_inscripciones', [
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'asiste' => true,
            'total' => 20.00,
        ]);
    }

    public function test_activity_description_supports_html_formatting(): void
    {
        $user = $this->createRegularUser();

        $htmlDesc = '<p>Reunión en la <strong>sede</strong>:</p><ul><li>Traer partituras</li><li>Uniforme oficial</li></ul>';

        $actividad = Actividad::query()->create([
            'titulo' => 'Concierto de Gala',
            'tipo' => 'concierto',
            'es_de_pago' => false,
            'descripcion' => $htmlDesc,
            'fecha' => Carbon::now()->addDays(10),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(5),
            'estado' => 'abierta',
        ]);

        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->assertSeeHtml('<strong>sede</strong>')
            ->assertSeeHtml('<li>Traer partituras</li>');
    }

    public function test_musician_can_confirm_attendance_in_free_individual_activity(): void
    {
        $user = $this->createRegularUser();

        $actividad = Actividad::query()->create([
            'titulo' => 'Concierto Fiestas Mayores',
            'tipo' => 'concierto',
            'es_de_pago' => false,
            'fecha' => Carbon::now()->addDays(8),
            'fecha_limite_inscripcion' => Carbon::now()->addDays(4),
            'estado' => 'abierta',
        ]);

        // El músico confirma asistencia directamente (Sí)
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->assertSee(__('actividades.btn_confirm_attendance'))
            ->assertSee(__('actividades.btn_not_attending'))
            ->call('inscribirme')
            ->assertHasNoErrors()
            ->assertSee(__('actividades.attendance_confirmed_title'));

        $this->assertDatabaseHas('actividad_inscripciones', [
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'asiste' => true,
            'total' => 0.00,
            'pagado' => true,
        ]);

        // Cambiar respuesta a "No voy"
        Livewire::actingAs($user)
            ->test(ActividadDetalle::class, ['actividadId' => $actividad->id])
            ->call('indicarNoVoy')
            ->assertHasNoErrors()
            ->assertSee(__('actividades.declined_card_title'));

        $this->assertDatabaseHas('actividad_inscripciones', [
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
            'asiste' => false,
        ]);
    }
}
