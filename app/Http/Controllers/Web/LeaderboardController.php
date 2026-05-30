<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function __invoke(): View
    {
        $players = Player::query()
            ->select('players.id', 'players.name')
            ->selectRaw('COUNT(DISTINCT matches.id) as matches_played')
            ->selectRaw('SUM(CASE WHEN matches.winner_team_id = teams.id THEN 1 ELSE 0 END) as wins')
            ->selectRaw('COALESCE(SUM(teams.score), 0) as total_score')
            ->leftJoin('player_team', 'players.id', '=', 'player_team.player_id')
            ->leftJoin('teams', 'player_team.team_id', '=', 'teams.id')
            ->leftJoin('matches', 'teams.match_id', '=', 'matches.id')
            ->groupBy('players.id', 'players.name')
            ->orderByDesc(DB::raw('wins'))
            ->orderByDesc(DB::raw('total_score'))
            ->limit(100)
            ->get();

        return view('leaderboard.index', compact('players'));
    }
}
