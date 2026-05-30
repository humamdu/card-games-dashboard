<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;

class Tarneeb61Engine extends AbstractGameEngine
{
    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array
    {
        $bidTeamId = (int) ($round->bid_team_id ?? $input['bid_team_id']);
        $bid = (int) ($round->bid_amount ?? $input['bid_amount']);
        $tricks = collect($input['tricks'] ?? []);

        return $match->teams->map(function ($team) use ($bidTeamId, $bid, $tricks) {
            $teamTricks = (int) $tricks->get($team->id, 0);
            $delta = $team->id === $bidTeamId && $teamTricks < $bid ? -$bid : $teamTricks;

            return $this->result($team->id, $delta, $teamTricks, ['bid' => $bid, 'bid_success' => $teamTricks >= $bid]);
        })->all();
    }

    public function winner(MatchGame $match): ?array
    {
        $team = $match->teams()->where('score', '>=', 61)->orderByDesc('score')->first();

        return $team ? ['team_id' => $team->id, 'name' => $team->name, 'score' => $team->score] : null;
    }
}
