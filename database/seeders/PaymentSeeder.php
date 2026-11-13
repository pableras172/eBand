<?php

namespace Database\Seeders;

use App\Models\Actuacion;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\Payment;
use App\Models\Paymentresume;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurar que el tenant demo esté inicializado si se ejecuta individualmente
        if (! tenancy()->initialized) {
            $tenant = Tenant::find('demo') ?? Tenant::first();
            if ($tenant) {
                tenancy()->initialize($tenant);
            }
        }

        $users = User::where('activo', 1)->get();
        if ($users->isEmpty()) {
            $users = User::all();
        }

        if ($users->isEmpty()) {
            $this->command?->warn('No hi ha usuaris a la base de dades per a generar pagaments.');

            return;
        }

        $admin = $users->first(fn ($u) => method_exists($u, 'hasRole') && $u->hasRole('Admin')) ?? $users->first();

        // Obtener actuaciones existentes con sus listas
        $actuaciones = Actuacion::with('lista')->get();

        if ($actuaciones->isEmpty()) {
            $this->command?->info('No hi ha actuacions. Cal executar ContratosSeeder primer.');

            return;
        }

        // Asegurarse de que cada actuación tenga su lista asociada
        foreach ($actuaciones as $actuacion) {
            if (! $actuacion->lista) {
                Listas::create([
                    'actuacions_id' => $actuacion->id,
                    'pagada' => 0,
                    'cuentas' => 0,
                ]);
            }
        }
        $actuaciones = Actuacion::with('lista')->get();

        // Limpiar registros antiguos de pagos y resúmenes para regenerar datos limpios y consistentes
        ListasUser::query()->update(['payment_id' => null]);
        Payment::query()->delete();
        Paymentresume::query()->delete();

        // Definición de remesas / resúmenes de liquidaciones
        $remesasData = [
            [
                'descripcion' => 'Liquidació Festes Patronals 2026',
                'fechaInicio' => Carbon::now()->subMonths(3)->startOfMonth(),
                'fechaFin' => Carbon::now()->subMonths(2)->endOfMonth(),
                'fechaPago' => Carbon::now()->subMonths(1)->day(15),
            ],
            [
                'descripcion' => 'Liquidació Concerts de Primavera i Moros i Cristians',
                'fechaInicio' => Carbon::now()->subMonths(2)->startOfMonth(),
                'fechaFin' => Carbon::now()->subMonths(1)->endOfMonth(),
                'fechaPago' => Carbon::now()->subDays(10),
            ],
            [
                'descripcion' => 'Liquidació Intercanvis Musicals i Cercaviles Recents',
                'fechaInicio' => Carbon::now()->subMonth()->startOfMonth(),
                'fechaFin' => Carbon::now()->endOfMonth(),
                'fechaPago' => Carbon::now(),
            ],
        ];

        DB::transaction(function () use ($users, $admin, $actuaciones, $remesasData) {
            foreach ($remesasData as $rIndex => $rData) {
                $resume = Paymentresume::create([
                    'descripcion' => $rData['descripcion'],
                    'user_id' => $admin->id,
                    'created_at' => $rData['fechaPago'],
                    'updated_at' => $rData['fechaPago'],
                ]);

                // Tomamos un grupo de músicos para este resumen (los primeros 6 u 8 músicos)
                $musicosSample = $users->take(6);

                foreach ($musicosSample as $mIndex => $musico) {
                    $isConfirmed = ($rIndex === 0) || ($mIndex % 2 === 0);
                    $observacion = $isConfirmed ? null : 'Pendent de revisar el quilometratge del viatge de tornada.';

                    $payment = Payment::create([
                        'users_id' => $musico->id,
                        'fechaPago' => $rData['fechaPago'],
                        'descripcion' => $rData['descripcion'].' - '.$musico->name,
                        'fechaInicio' => $rData['fechaInicio'],
                        'fechaFin' => $rData['fechaFin'],
                        'totalPago' => 0,
                        'confirmadausuaroi' => $isConfirmed,
                        'paymentresume_id' => $resume->id,
                        'observaciones' => $observacion,
                        'created_at' => $rData['fechaPago'],
                        'updated_at' => $rData['fechaPago'],
                    ]);

                    $totalPago = 0.0;
                    // Seleccionar entre 2 y 4 actuaciones distintas para este músico
                    $actuacionesSeleccionadas = $actuaciones->shuffle()->take(rand(2, 4));

                    foreach ($actuacionesSeleccionadas as $actuacion) {
                        $lista = $actuacion->lista;
                        if (! $lista) {
                            continue;
                        }

                        $tieneCoche = (bool) rand(0, 1);
                        $tieneFurgo = ! $tieneCoche && (bool) rand(0, 1);

                        $porcentaje = ($musico->porcentaje && $musico->porcentaje > 0) ? ($musico->porcentaje / 100) : 1.0;
                        if ($actuacion->preciofurgona <= 0) {
                            $actuacion->preciofurgona = 35.00;
                            $actuacion->save();
                        }
                        if ($actuacion->preciomusico <= 0) {
                            $actuacion->preciomusico = 50.00;
                            $actuacion->save();
                        }
                        if ($actuacion->preciocoche <= 0) {
                            $actuacion->preciocoche = 18.00;
                            $actuacion->save();
                        }

                        $precioMusico = (float) $actuacion->preciomusico;
                        $precioCoche = (float) $actuacion->preciocoche;
                        $precioFurgo = (float) $actuacion->preciofurgona;

                        $totalActuacion = $precioMusico * $porcentaje;
                        $totalCoche = $tieneCoche ? $precioCoche : 0.0;
                        $totalFurgo = $tieneFurgo ? $precioFurgo : 0.0;
                        $totalActo = $totalActuacion + $totalCoche + $totalFurgo;

                        // Buscar o crear la entrada en la lista para este músico
                        $listaUser = ListasUser::updateOrCreate(
                            [
                                'listas_id' => $lista->id,
                                'user_id' => $musico->id,
                            ],
                            [
                                'disponible' => true,
                                'duda' => false,
                                'coche' => $tieneCoche,
                                'furgona' => $tieneFurgo,
                                'pagada' => true,
                                'cuentas' => true,
                                'totalActuacion' => $totalActuacion,
                                'totalCoche' => $totalCoche,
                                'totalFurgo' => $totalFurgo,
                                'totalActo' => $totalActo,
                                'payment_id' => $payment->id,
                            ]
                        );

                        $totalPago += $totalActo;
                    }

                    $payment->totalPago = $totalPago;
                    $payment->save();
                }
            }
        });
    }
}
