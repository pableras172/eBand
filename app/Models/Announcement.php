<?php

namespace App\Models;

use Database\Factories\AnnouncementFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    /** @use HasFactory<AnnouncementFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'content_view',
        'redirect_url',
        'starts_at',
        'ends_at',
        'is_active',
        'applies_to_all',
        'created_by',
        'notified_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'applies_to_all' => 'boolean',
        'notified_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'announcement_instrument');
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(AnnouncementStatus::class);
    }

    public function scopeActiveWindow(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where(function (Builder $builder): void {
                $builder->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }

    public function scopeVisibleForUser(Builder $query, User $user): Builder
    {
        return $query
            ->activeWindow()
            ->whereDoesntHave('statuses', function (Builder $builder) use ($user): void {
                $builder->where('user_id', $user->id);
            })
            ->where(function (Builder $builder) use ($user): void {
                $builder->where('applies_to_all', true)
                    ->orWhereHas('instruments', function (Builder $instrumentBuilder) use ($user): void {
                        $instrumentBuilder->where('instruments.id', $user->instrument_id ?? 0);
                    });
            });
    }

    public function targetUsersQuery(): Builder
    {
        return User::query()
            ->where('activo', true)
            ->when(! $this->applies_to_all, function (Builder $builder): void {
                $builder->whereIn('instrument_id', $this->instruments()->pluck('instruments.id'));
            });
    }
}
