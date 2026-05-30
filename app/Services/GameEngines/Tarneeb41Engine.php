<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;

class Tarneeb41Engine extends AbstractGameEngine
{
    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array
    {
        $bidTeamId = (int) ($round->bid_team_id ?? $input['bid_team_id']);
        $bid = (int) ($round->bid_amount ?? $input['bid_amount']);
        $tricks = collect($input['tricks'] ?? []);
        $bidTeamTricks = (int) $tricks->get($bidTeamId, 0);
        $multiplier = $match->teams()->findOrFail($bidTeamId)->score < 30 ? 2 : 1;

        return $match->teams->map(function ($team) use ($bidTeamId, $bid, $bidTeamTricks, $tricks, $multiplier) {
            $teamTricks = (int) $tricks->get($team->id, 0);
            $delta = $team->id === $bidTeamId
                ? ($bidTeamTricks >= $bid ? $bidTeamTricks * $multiplier : -$bid * $multiplier)
                : $teamTricks;

            return $this->result($team->id, $delta, $teamTricks, ['bid' => $bid, 'under_30_multiplier' => $team->id === $bidTeamId ? $multiplier : 1]);
        })->all();
    }

    public function winner(MatchGame $match): ?array
    {
        $team = $match->teams()->where('score', '>=', 41)->orderByDesc('score')->first();

        return $team ? ['team_id' => $team->id, 'name' => $team->name, 'score' => $team->score] : null;
    }
}
