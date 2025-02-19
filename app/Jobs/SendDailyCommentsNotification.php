<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;
use OneSignal;

class SendDailyCommentsNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Obtener los comentarios en las últimas 24 horas
        $commentsCount = Comment::where('created_at', '>=', Carbon::now()->subDay())->count();

        if ($commentsCount > 0) {
            try {
                // Enviar notificación a todos los usuarios activos
                OneSignal::sendNotificationToSegment(
                    Lang::get('messages.daily_comments_title'),
                    "Active Subscriptions",
                    env('APP_URL') . "/comments",
                    null,
                    null,
                    null,
                    Lang::get('messages.daily_comments_subtitle', ['count' => $commentsCount]),
                    Lang::get('messages.view_details')
                );

                Log::info("✅ Notificación enviada: $commentsCount nuevos comentarios en las últimas 24h.");
            } catch (\Exception $e) {
                Log::error("❌ Error al enviar la notificación de comentarios: " . $e->getMessage());
            }
        } else {
            Log::info("🔍 No hay nuevos comentarios en las últimas 24 horas.");
        }
    }
}
