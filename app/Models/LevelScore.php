<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelScore extends Model
{
    protected $fillable = [
        'user_id',
        'level_id',
        'score',
        'best_score',
        'attempts',
        'completed',
        'mode',
        'practice_mode',
    ];

    protected $casts = [
        'score' => 'integer',
        'best_score' => 'integer',
        'attempts' => 'integer',
        'completed' => 'boolean',
        'practice_mode' => 'boolean',
    ];

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
