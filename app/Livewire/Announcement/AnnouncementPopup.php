<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use App\Models\AnnouncementStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class AnnouncementPopup extends Component
{
    public ?Announcement $announcement = null;

    public bool $showModal = false;

    public bool $hasCustomView = false;

    public function mount(): void
    {
        if (! Auth::check()) {
            return;
        }

        /** @var User $user */
        $user = Auth::user();

        $this->announcement = Announcement::query()
            ->with('instruments')
            ->visibleForUser($user)
            ->orderBy('starts_at', 'desc')
            ->first();

        if (! $this->announcement) {
            return;
        }

        $this->hasCustomView = filled($this->announcement->content_view)
            && str_starts_with($this->announcement->content_view, 'announcements.')
            && view()->exists($this->announcement->content_view);

        $this->showModal = true;
    }

    #[On('open-announcement-popup')]
    public function openAnnouncementPopup(int $announcementId): void
    {
        if (! Auth::check()) {
            return;
        }

        /** @var User $user */
        $user = Auth::user();

        $announcement = Announcement::query()
            ->with('instruments')
            ->activeWindow()
            ->whereKey($announcementId)
            ->where(function (Builder $builder) use ($user): void {
                $builder->where('applies_to_all', true)
                    ->orWhereHas('instruments', function (Builder $instrumentBuilder) use ($user): void {
                        $instrumentBuilder->where('instruments.id', $user->instrument_id ?? 0);
                    });
            })
            ->first();

        if (! $announcement) {
            return;
        }

        $this->announcement = $announcement;
        $this->hasCustomView = filled($announcement->content_view)
            && str_starts_with($announcement->content_view, 'announcements.')
            && view()->exists($announcement->content_view);
        $this->showModal = true;
    }

    public function markAsRead()
    {
        if (! $this->announcement || ! Auth::check()) {
            return;
        }

        AnnouncementStatus::query()->updateOrCreate(
            [
                'announcement_id' => $this->announcement->id,
                'user_id' => Auth::id(),
            ],
            [
                'seen_at' => now(),
            ]
        );

        $this->showModal = false;

        if ($this->announcement->redirect_url) {
            return redirect()->to($this->announcement->redirect_url);
        }
    }

    public function dismiss()
    {
        if (! $this->announcement || ! Auth::check()) {
            return;
        }

        AnnouncementStatus::query()->updateOrCreate(
            [
                'announcement_id' => $this->announcement->id,
                'user_id' => Auth::id(),
            ],
            [
                'closed_at' => now(),
            ]
        );

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.announcement.announcement-popup');
    }
}
