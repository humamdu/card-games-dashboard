<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;

class KanasahEngine extends AbstractGameEngine
{
    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array
    {
        return collect($input['teams'] ?? [])->map(function (array $data, $teamId) {
            $is_positive = -1;
            $cardPoints = (int) ($data['card_points'] ?? 0)*10;
            $jokerKanasta = (int) ($data['joker_kanasta'] ?? 0) * 500;
            $cleanKanasta = (int) ($data['kanasta'] ?? 0) * 300;
            $dirtyKanasta = (int) ($data['dirty_kanasta'] ?? 0) * 200;
            $trisa = (int) ($data['trisa'] ?? 0) * 200;
            $jokers = (int) ($data['jokers'] ?? 0);
            $jokerPoints = $jokers * 200;
            $penalties = (int) ($data['penalties'] ?? 0);
            
            if ($cleanKanasta || $dirtyKanasta || $jokerKanasta) {
                $is_positive = 1;
            } 
            $delta = $is_positive * ($cardPoints + $jokerKanasta + $cleanKanasta + $dirtyKanasta + $trisa + $jokerPoints - $penalties);
            return $this->result((int) $teamId, $delta, $cardPoints, [
                'joker_kanasta_bonus' => $jokerKanasta,
                'clean_kanasta_bonus' => $cleanKanasta,
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
