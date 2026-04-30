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

        $globalAnnouncements = Announcement::factory(3)
            ->state([
                'applies_to_all' => true,
                'created_by' => $creatorId,
            ])
            ->create();

        $instrumentAnnouncements = Announcement::factory(3)
            ->state([
                'applies_to_all' => false,
                'created_by' => $creatorId,
            ])
            ->create();

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
