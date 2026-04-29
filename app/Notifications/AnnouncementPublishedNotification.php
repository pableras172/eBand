<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnnouncementPublishedNotification extends Notification
{
    use Queueable;

    public function __construct(public Announcement $announcement) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'announcement_id' => $this->announcement->id,
            'title' => $this->announcement->title,
            'starts_at' => optional($this->announcement->starts_at)->toDateTimeString(),
            'route' => '/dashboard',
        ];
    }
}
