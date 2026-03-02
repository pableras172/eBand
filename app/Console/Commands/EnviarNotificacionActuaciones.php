<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Configuration;
use App\Models\Actuacion;
use App\Models\User;
use App\Mail\WeeklyActuacionesEmail;

class EnviarNotificacionActuaciones extends Command
{
    // Nombre del comando para usar en `artisan`
    protected $signature = 'notificaciones:enviar-actuaciones';

    // Descripción
    protected $description = 'Envía emails informativos cada lunes a las 16:00 con la agenda semanal de actuaciones.';

    /**
     * Lógica de ejecución de la tarea programada
     */
    public function handle()
    {
        // Verificar si el envío de emails está habilitado
        $enabled = Configuration::where('param', 'enable_weekly_actuaciones_email')->value('value');
        
        if (!$enabled || $enabled !== '1') {
            $this->info('El envío de emails semanales está deshabilitado.');
            Log::info('Email semanal de actuaciones no enviado: configuración deshabilitada.');
            return;
        }

        try {
            // Obtener fecha de inicio (hoy, lunes) y fin (domingo siguiente)
            $fechaInicio = Carbon::now()->startOfWeek(); // Lunes de esta semana
            $fechaFin = Carbon::now()->endOfWeek(); // Domingo de esta semana

            // Obtener actuaciones de la semana actual
            $actuaciones = Actuacion::whereBetween('fechaActuacion', [$fechaInicio, $fechaFin])
                ->with(['tipoactuacion', 'contrato'])
                ->orderBy('fechaActuacion', 'asc')
                ->get();

            // Obtener usuarios activos (verificados y no eliminados)
            $users = User::whereNotNull('email_verified_at')
                ->where('activo', 1)
                ->get();

            $emailsSent = 0;

            foreach ($users as $user) {
                Mail::to($user->email)->send(
                    new WeeklyActuacionesEmail(
                        $actuaciones,
                        $fechaInicio->format('d/m/Y'),
                        $fechaFin->format('d/m/Y'),
                        $user->name
                    )
                );
                $emailsSent++;
            }

            $this->info("Emails enviados correctamente. Total: {$emailsSent} usuarios.");
            Log::info("Email semanal de actuaciones enviado a {$emailsSent} usuarios.", [
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin' => $fechaFin->format('Y-m-d'),
                'total_actuaciones' => $actuaciones->count(),
            ]);

        } catch (\Exception $e) {
            $this->error('Error al enviar los emails: ' . $e->getMessage());
            Log::error('Error al enviar email semanal de actuaciones: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
