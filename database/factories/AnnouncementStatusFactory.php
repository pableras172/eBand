<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\AnnouncementStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnnouncementStatus>
 */
class AnnouncementStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'announcement_id' => Announcement::factory(),
            'user_id' => User::factory(),
            'seen_at' => now(),
            'closed_at' => null,
        ];
    }
}
