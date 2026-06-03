<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'level_id',
        'completed',
        'score',
        'attempts',
        'time_played',
        'difficulty',
        'distance',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'score' => 'integer',
        'attempts' => 'integer',
        'time_played' => 'integer',
        'distance' => 'integer',
    ];

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
