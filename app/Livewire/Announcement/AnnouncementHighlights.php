<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class AnnouncementHighlights extends Component
{
    public function openAnnouncement(int $announcementId): void
    {
        $this->dispatch('open-announcement-popup', announcementId: $announcementId);
    }

    public function render(): View
    {
        if (! Auth::check()) {
            return view('livewire.announcement.announcement-highlights', [
                'announcements' => collect(),
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        $announcements = Announcement::query()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where(function (Builder $builder) use ($user): void {
                $builder->where('applies_to_all', true)
                    ->orWhereHas('instruments', function (Builder $instrumentBuilder) use ($user): void {
                        $instrumentBuilder->where('instruments.id', $user->instrument_id ?? 0);
                    });
            })
            ->latest('created_at')
            ->limit(3)
            ->get();

        return view('livewire.announcement.announcement-highlights', [
            'announcements' => $announcements,
        ]);
    }
}
