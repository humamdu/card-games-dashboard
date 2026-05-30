<?php

namespace App\Services;

use App\Models\MatchGame;
use App\Models\Round;
use Illuminate\Support\Facades\DB;

class ScoreService
{
    public function __construct(private readonly GameEngineFactory $engineFactory)
    {
    }

    public function scoreRound(MatchGame $match, Round $round, array $payload): array
    {
        return DB::transaction(function () use ($match, $round, $payload) {
            $match->load('teams.players');
            $engine = $this->engineFactory->make($match->game_type);
            $results = $engine->calculateRoundResults($match, $round, $payload);

            foreach ($results as $result) {
                $round->results()->create([
                    'team_id' => $result['teamId'],
                    'player_id' => $result['playerId'] ?? null,
                    'raw_score' => $result['raw'],
                    'score_delta' => $result['delta'],
                    'details' => $result['details'] ?? [],
                ]);
            }

            return $engine->updateMatchScore($match, $round, $results);
        });
    }
}
