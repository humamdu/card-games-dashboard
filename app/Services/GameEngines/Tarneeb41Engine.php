<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;
use InvalidArgumentException;

class Tarneeb41Engine extends AbstractGameEngine
{
    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array
    {
        $bids = collect($input['bids'] ?? []);
        $tricks = collect($input['tricks'] ?? []);

        return $match->teams->flatMap(function ($team) use ($bids, $tricks) {
            $teamScore = (int) $team->score;

            return $team->players->map(function ($player) use ($team, $teamScore, $bids, $tricks) {
                $playerId = $player->id;

                if (! $bids->has($playerId)) {
                    throw new InvalidArgumentException('Tarneeb 41 requires a bid for each player.');
                }

                $bid = (int) $bids->get($playerId, 0);
                $playerTricks = (int) $tricks->get($playerId, 0);
                $success = $playerTricks >= $bid;
                $multiplier = ($teamScore < 30 && $bid > 4) ? 2 : 1;
                $delta = $success ? $playerTricks * $multiplier : -$bid * $multiplier;

                return $this->result(
                    $team->id,
                    $delta,
                    $playerTricks,
                    [
                        'bid' => $bid,
                        'success' => $success,
                        'multiplier' => $multiplier,
                    ],
                    $playerId
                );
            });
        })->values()->all();
    }

    public function winner(MatchGame $match): ?array
    {
        $team = $match->teams()->where('score', '>=', 41)->orderByDesc('score')->first();

        return $team ? ['team_id' => $team->id, 'name' => $team->name, 'score' => $team->score] : null;
    }
}
