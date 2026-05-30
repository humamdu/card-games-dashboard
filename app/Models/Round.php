<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Round extends Model
{
    use HasFactory;

    protected $fillable = ['match_id', 'number', 'kingdom', 'contract', 'bid_team_id', 'bid_amount', 'payload'];

    protected $casts = ['payload' => 'array'];

    public function match(): BelongsTo
    {
        return $this->belongsTo(MatchGame::class, 'match_id');
    }

    public function bidTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'bid_team_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(RoundResult::class);
    }
}
