<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementPublishedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementIndex extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public string $search = '';

    public bool $confirmingDeletion = false;

    public ?int $deletingAnnouncementId = null;

    public function mount(): void
    {
        $this->authorize('viewAny', Announcement::class);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeletion(int $announcementId): void
    {
        $this->deletingAnnouncementId = $announcementId;
        $this->confirmingDeletion = true;
    }

    public function delete(): void
    {
        if (! $this->deletingAnnouncementId) {
            return;
        }

        $announcement = Announcement::query()->findOrFail($this->deletingAnnouncementId);
        $this->authorize('delete', $announcement);

        $announcement->delete();

        $this->confirmingDeletion = false;
        $this->deletingAnnouncementId = null;
    }

    public function notifyUsers(int $announcementId): void
    {
        $announcement = Announcement::query()->with('instruments')->findOrFail($announcementId);
        $this->authorize('update', $announcement);

        $announcement->targetUsersQuery()
            ->chunkById(200, function ($users) use ($announcement): void {
                Notification::send($users, new AnnouncementPublishedNotification($announcement));
            });

        $announcement->update([
            'notified_at' => now(),
        ]);

        session()->flash('success', 'Anuncio notificado correctamente.');
    }

    public function render()
    {
        $announcements = Announcement::query()
            ->with(['creator', 'instruments'])
            ->withCount([
                'statuses as handled_count',
                'statuses as read_count' => function ($query): void {
                    $query->whereNotNull('seen_at');
                },
                'statuses as closed_count' => function ($query): void {
                    $query->whereNotNull('closed_at');
                },
            ])
            ->when($this->search !== '', function ($query): void {
                $query->where(function ($builder): void {
                    $builder->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('body', 'like', '%'.$this->search.'%');
                });
            })
            ->latest()
            ->paginate(10);

        $metrics = $this->buildMetrics($announcements);

        return view('livewire.announcement.announcement-index', [
            'announcements' => $announcements,
            'metrics' => $metrics,
        ]);
    }

    protected function buildMetrics(LengthAwarePaginator $announcements): array
    {
        $activeUsersCount = User::query()
            ->where('activo', true)
            ->count();

        $activeUsersByInstrument = User::query()
            ->where('activo', true)
            ->whereNotNull('instrument_id')
            ->groupBy('instrument_id')
            ->selectRaw('instrument_id, count(*) as total')
            ->pluck('total', 'instrument_id');

        $metrics = [];

        foreach ($announcements->items() as $announcement) {
            $targetedUsers = $announcement->applies_to_all
                ? $activeUsersCount
                : $announcement->instruments
                    ->sum(fn ($instrument) => (int) ($activeUsersByInstrument[$instrument->id] ?? 0));

            $handledCount = (int) ($announcement->handled_count ?? 0);
            $pendingCount = max(0, $targetedUsers - $handledCount);

            $metrics[$announcement->id] = [
                'targeted' => $targetedUsers,
                'read' => (int) ($announcement->read_count ?? 0),
                'closed' => (int) ($announcement->closed_count ?? 0),
                'pending' => $pendingCount,
            ];
        }

        return $metrics;
    }
}
