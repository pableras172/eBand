<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OneSignal;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnviarNotificacionActuaciones extends Command
{
    // Nombre del comando para usar en `artisan`
    protected $signature = 'notificaciones:enviar-actuaciones';

    // Descripción
    protected $description = 'Envía notificaciones push cada lunes a las 16:00 para informar sobre la agenda semanal.';

    /**
     * Lógica de ejecución de la tarea programada
     */
    public function handle()
    {
        // Enviar notificación a usuarios activos
        try {
            OneSignal::sendNotificationToSegment(
                Lang::get('messages.agenda'),
                "Active Subscriptions", // Segmento de OneSignal
                env('APP_URL') . "/actuacion", // URL a visitar
                null, 
                null, 
                null, 
                Lang::get('messages.consultaagenda'), 
                Lang::get('messages.view_details')
            );

            $this->info('Notificación enviada correctamente.');
            Log::info('Notificación de actuaciones enviada correctamente.');

        } catch (\Exception $e) {
            $this->error('Error al enviar la notificación: ' . $e->getMessage());
            Log::error('Error al enviar la notificación: ' . $e->getMessage());
        }
    }
}
