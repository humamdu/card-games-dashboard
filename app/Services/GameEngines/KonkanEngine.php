<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;

class KonkanEngine extends AbstractGameEngine
{
    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array
    {
        return collect($input['scores'] ?? [])->map(fn ($score, $teamId) => $this->result((int) $teamId, (int) $score, (int) $score, ['lose_limit' => 550]))->values()->all();
    }

    public function winner(MatchGame $match): ?array
    {
        $loserExists = $match->teams()->where('score', '>=', 550)->exists();
        if (! $loserExists) {
            return null;
        }

        $team = $match->teams()->orderBy('score')->first();

        return $team ? ['team_id' => $team->id, 'name' => $team->name, 'score' => $team->score] : null;
    }
}
