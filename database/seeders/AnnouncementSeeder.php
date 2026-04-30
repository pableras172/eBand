<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\AnnouncementStatus;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()->where('activo', true)->get();
        $creatorId = $users->first()?->id;
        $instrumentIds = Instrument::query()->pluck('id');

        $globalAnnouncementsData = [
            [
                'title' => 'Bienvenido a eBand',
                'body' => 'Gracias por formar parte de la plataforma. Revisa tu panel para empezar a gestionar actuaciones y tareas.',
            ],
            [
                'title' => 'Recordatorio de uso',
                'body' => 'Manteneos al dia con comentarios y notificaciones para coordinar mejor ensayos y actuaciones.',
            ],
            [
                'title' => 'Novedades de la plataforma',
                'body' => 'Hemos mejorado la gestion de anuncios y permisos para facilitar el trabajo diario.',
            ],
        ];

        $globalAnnouncements = collect($globalAnnouncementsData)->map(function (array $announcementData) use ($creatorId): Announcement {
            return Announcement::query()->create([
                'title' => $announcementData['title'],
                'body' => $announcementData['body'],
                'content_view' => null,
                'redirect_url' => null,
                'starts_at' => now()->subHour(),
                'ends_at' => now()->addDays(7),
                'is_active' => true,
                'applies_to_all' => true,
                'created_by' => $creatorId,
                'notified_at' => null,
            ]);
        });

        $instrumentAnnouncementsData = [
            [
                'title' => 'Aviso por instrumento',
                'body' => 'Hay cambios en el repertorio para vuestra seccion. Revisad el listado actualizado.',
            ],
            [
                'title' => 'Ensayo extraordinario',
                'body' => 'Se convoca ensayo extraordinario para preparar el proximo concierto.',
            ],
            [
                'title' => 'Revision de material',
                'body' => 'Revisad estado y disponibilidad del material asignado antes del fin de semana.',
            ],
        ];

        $instrumentAnnouncements = collect($instrumentAnnouncementsData)->map(function (array $announcementData) use ($creatorId): Announcement {
            return Announcement::query()->create([
                'title' => $announcementData['title'],
                'body' => $announcementData['body'],
                'content_view' => null,
                'redirect_url' => null,
                'starts_at' => now()->subHour(),
                'ends_at' => now()->addDays(7),
                'is_active' => true,
                'applies_to_all' => false,
                'created_by' => $creatorId,
                'notified_at' => null,
            ]);
        });

        if ($instrumentIds->isNotEmpty()) {
            foreach ($instrumentAnnouncements as $announcement) {
                $announcement->instruments()->sync(
                    $instrumentIds->random(min(2, $instrumentIds->count()))->values()->all()
                );
            }
        }

        if ($users->isNotEmpty()) {
            $announcementsForStatus = $globalAnnouncements->merge($instrumentAnnouncements)->take(2);

            foreach ($announcementsForStatus as $announcement) {
                foreach ($users->take(3) as $user) {
                    AnnouncementStatus::query()->firstOrCreate([
                        'announcement_id' => $announcement->id,
                        'user_id' => $user->id,
                    ], [
                        'seen_at' => now()->subMinutes(rand(5, 120)),
                        'closed_at' => null,
                    ]);
                }
            }
        }
    }
}
