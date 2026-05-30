<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;

class KanasahEngine extends AbstractGameEngine
{
    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array
    {
        return collect($input['teams'] ?? [])->map(function (array $data, $teamId) {
            $cardPoints = (int) ($data['card_points'] ?? 0);
            $kanasta = (int) ($data['kanasta'] ?? 0) * 500;
            $dirtyKanasta = (int) ($data['dirty_kanasta'] ?? 0) * 300;
            $trisa = (int) ($data['trisa'] ?? 0) * 100;
            $jokers = (int) ($data['jokers'] ?? 0);
            $jokerPoints = min($jokers * 50, $jokers >= 2 ? 100 : 50);
            $penalties = (int) ($data['penalties'] ?? 0);
            $delta = $cardPoints + $kanasta + $dirtyKanasta + $trisa + $jokerPoints - $penalties;

            return $this->result((int) $teamId, $delta, $cardPoints, [
                'kanasta_bonus' => $kanasta,
                'dirty_kanasta_bonus' => $dirtyKanasta,
                'trisa_bonus' => $trisa,
                'joker_points_capped' => $jokerPoints,
                'penalties' => $penalties,
            ]);
        })->values()->all();
    }

    public function winner(MatchGame $match): ?array
    {
        $target = (int) data_get($match->settings, 'target_score', 5500);
        $team = $match->teams()->where('score', '>=', $target)->orderByDesc('score')->first();

        return $team ? ['team_id' => $team->id, 'name' => $team->name, 'score' => $team->score] : null;
    }
}
