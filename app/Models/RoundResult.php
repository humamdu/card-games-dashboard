<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoundResult extends Model
{
    use HasFactory;

    protected $fillable = ['round_id', 'team_id', 'player_id', 'raw_score', 'score_delta', 'details'];

    protected $casts = ['details' => 'array'];

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
