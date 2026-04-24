<?php

namespace App\Models;

use Database\Factories\AnnouncementStatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnouncementStatus extends Model
{
    /** @use HasFactory<AnnouncementStatusFactory> */
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'user_id',
        'seen_at',
        'closed_at',
    ];

    protected $casts = [
        'seen_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
