<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConcertProgramPiece extends Model
{
    use HasFactory;

    protected $fillable = [
        'concert_program_id',
        'title',
        'author',
        'details',
        'url',
        'sort_order',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(ConcertProgram::class, 'concert_program_id');
    }
}
