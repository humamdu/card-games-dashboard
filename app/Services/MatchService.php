<?php

namespace App\Services;

use App\Models\MatchGame;
use App\Models\Round;
use Illuminate\Support\Facades\DB;

class MatchService
{
    public function __construct(
        private readonly TeamService $teamService,
        private readonly ScoreService $scoreService,
    ) {
    }

    public function create(array $data): MatchGame
    {
        return DB::transaction(function () use ($data) {
            $match = MatchGame::create([
                'game_type' => $data['game_type'],
                'status' => 'active',
                'settings' => $data['settings'] ?? [],
                'scoreboard' => [],
                'started_at' => now(),
            ]);

            $this->teamService->createTeams($match, $data['teams']);

            return $match->load('teams.players');
        });
    }

    public function addRound(MatchGame $match, array $data): Round
    {
        return DB::transaction(function () use ($match, $data) {
            $round = $match->rounds()->create([
                'number' => $data['number'] ?? $match->rounds()->count() + 1,
                'kingdom' => $data['kingdom'] ?? null,
                'contract' => $data['contract'] ?? null,
                'bid_team_id' => $data['bid_team_id'] ?? null,
                'bid_amount' => $data['bid_amount'] ?? null,
                'payload' => $data['payload'] ?? [],
            ]);

            $this->scoreService->scoreRound($match, $round, $data['payload'] ?? $data);

            return $round->load('results.team', 'results.player');
        });
    }
}
