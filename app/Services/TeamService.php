<?php

namespace App\Services;

use App\Models\MatchGame;
use App\Models\Team;

class TeamService
{
    public function createTeams(MatchGame $match, array $teams): void
    {
        foreach ($teams as $index => $teamData) {

            if (isset($teamData['active'])) {
                $team = Team::create([
                    'match_id' => $match->id,
                    'name' => $teamData['name'] ?? 'T'.($index + 1),
                    'position' => $teamData['position'] ?? $index + 1,
                    'score' => 0,
                ]);
    
                $team->players()->sync($teamData['player_ids'] ?? []);
            } else{
                continue; // Skip inactive teams
            }
        }
    }
}
