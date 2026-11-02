<?php

namespace Tests\Feature;

use App\Livewire\Announcement\AnnouncementIndex;
use App\Livewire\Announcement\AnnouncementPopup;
use App\Models\Announcement;
use App\Models\Instrument;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AnnouncementFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function ensureBaseRoles(): void
    {
        Role::query()->upsert([
            ['id' => 1, 'title' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'User', 'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['title', 'updated_at']);
    }

    public function test_targeted_user_sees_announcement_on_dashboard(): void
    {
        $this->ensureBaseRoles();

        $instrument = Instrument::factory()->create();
        $user = User::factory()->create(['instrument_id' => $instrument->id]);

        $announcement = Announcement::factory()->create([
            'applies_to_all' => false,
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addHour(),
        ]);
        $announcement->instruments()->attach($instrument->id);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($announcement->title);
    }

    public function test_user_does_not_see_announcement_after_dismiss(): void
    {
        $this->ensureBaseRoles();

        $instrument = Instrument::factory()->create();
        $user = User::factory()->create(['instrument_id' => $instrument->id]);

        $announcement = Announcement::factory()->create([
            'applies_to_all' => false,
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addHour(),
        ]);
        $announcement->instruments()->attach($instrument->id);

        Livewire::actingAs($user)
            ->test(AnnouncementPopup::class)
            ->call('dismiss');

        $this->assertDatabaseHas('announcement_statuses', [
            'announcement_id' => $announcement->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(AnnouncementPopup::class)
            ->assertSet('showModal', false)
            ->assertDontSee($announcement->title);
    }

    public function test_non_targeted_user_does_not_see_targeted_announcement(): void
    {
        $this->ensureBaseRoles();

        $instrumentA = Instrument::factory()->create();
        $instrumentB = Instrument::factory()->create();

        $targetUser = User::factory()->create(['instrument_id' => $instrumentA->id]);
        $otherUser = User::factory()->create(['instrument_id' => $instrumentB->id]);

        $announcement = Announcement::factory()->create([
            'applies_to_all' => false,
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addHour(),
        ]);
        $announcement->instruments()->attach($instrumentA->id);

        $this->actingAs($targetUser)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($announcement->title);

        $this->actingAs($otherUser)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee($announcement->title);
    }

    public function test_admin_can_notify_target_users_from_list(): void
    {
        $this->ensureBaseRoles();

        $instrument = Instrument::factory()->create();

        $admin = User::factory()->create(['instrument_id' => $instrument->id]);
        $admin->roles()->sync([1]);

        $target = User::factory()->create(['instrument_id' => $instrument->id]);
        $other = User::factory()->create();

        $announcement = Announcement::factory()->create([
            'applies_to_all' => false,
            'starts_at' => now()->subMinute(),
            'ends_at' => now()->addHour(),
            'created_by' => $admin->id,
        ]);
        $announcement->instruments()->attach($instrument->id);

        Livewire::actingAs($admin)
            ->test(AnnouncementIndex::class)
            ->call('notifyUsers', $announcement->id);

        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $target->id,
        ]);

        $this->assertDatabaseMissing('notifications', [
            'notifiable_id' => $other->id,
        ]);
    }
}
