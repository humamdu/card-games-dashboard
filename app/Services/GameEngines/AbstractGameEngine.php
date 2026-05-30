<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;
use Illuminate\Support\Collection;

abstract class AbstractGameEngine implements GameEngineInterface
{
    protected function teamScores(MatchGame $match): Collection
    {
        return $match->teams()->with('players')->get()->map(fn ($team) => [
            'team_id' => $team->id,
            'name' => $team->name,
            'score' => (int) $team->score,
            'players' => $team->players->pluck('name'),
        ]);
    }

    protected function result(int $teamId, int $delta, int $raw = 0, array $details = [], ?int $playerId = null): array
    {
        return compact('teamId', 'delta', 'raw', 'details', 'playerId');
    }

    public function updateMatchScore(MatchGame $match, Round $round, array $results): array
    {
        foreach ($results as $result) {
            $team = $match->teams()->findOrFail($result['teamId']);
            $team->increment('score', $result['delta']);
        }

        $match->refresh()->load('teams.players');
        $scoreboard = $this->teamScores($match)->values()->all();
        $winner = $this->winner($match);

        $match->forceFill([
            'scoreboard' => $scoreboard,
            'winner_team_id' => $winner['team_id'] ?? null,
            'status' => $winner ? 'finished' : 'active',
            'finished_at' => $winner ? now() : null,
        ])->save();

        return $scoreboard;
    }

    public function winner(MatchGame $match): ?array
    {
        return null;
    }

    public function hasWinner(MatchGame $match): bool
    {
        return $this->winner($match) !== null;
    }
}
