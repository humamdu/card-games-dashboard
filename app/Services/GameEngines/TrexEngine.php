<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;
use InvalidArgumentException;

class TrexEngine extends AbstractGameEngine
{
    private const CONTRACT_SCORES = [
        'king_of_hearts' => -75,
        'queens' => -25,
        'diamonds' => -10,
        'collections' => -15,
        'trex-1' => 200,
        'trex-2' => 150,
        'trex-3' => 100,
        'trex-4' => 50,
    ];

    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array
    {
        if ($match->teams()->count() !== 4) {
            throw new InvalidArgumentException('Trex requires exactly 4 single-player teams.');
        }

        $contract = $round->contract ?? $input['contract'] ?? null;
        $scores = $input['scores'] ?? [];

        return collect($scores)->map(function ($value, $teamId) use ($contract) {
            $multiplier = self::CONTRACT_SCORES[$contract] ?? 1;
            $delta = $contract === 'trex' ? (int) $value : (int) $value * $multiplier;

            return $this->result((int) $teamId, $delta, (int) $value, ['contract' => $contract]);
        })->values()->all();
    }

    public function winner(MatchGame $match): ?array
    {
        if ($match->rounds()->count() < 20) {
            return null;
        }

        $team = $match->teams()->orderByDesc('score')->first();

        return $team ? ['team_id' => $team->id, 'name' => $team->name, 'score' => $team->score] : null;
    }
}
