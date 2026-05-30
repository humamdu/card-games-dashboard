<?php

namespace App\Models;

use App\Enums\GameType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchGame extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $fillable = ['game_type', 'status', 'settings', 'scoreboard', 'winner_team_id', 'started_at', 'finished_at'];

    protected $casts = [
        'game_type' => GameType::class,
        'settings' => 'array',
        'scoreboard' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function winnerTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'match_id');
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class, 'match_id')->orderBy('number');
    }
}
