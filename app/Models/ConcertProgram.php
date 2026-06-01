<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConcertProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'event_date',
        'event_time',
        'location',
        'participants',
        'is_published',
        'is_featured',
        'image_path',
        'logo_1_path',
        'logo_2_path',
        'logo_3_path',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function pieces(): HasMany
    {
        return $this->hasMany(ConcertProgramPiece::class)->orderBy('sort_order');
    }
}
