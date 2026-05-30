<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MatchGame;
use App\Models\Player;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard.index', [
            'activeMatches' => MatchGame::with('teams.players')->where('status', 'active')->latest()->take(8)->get(),
            'recentMatches' => MatchGame::with('teams.players')->latest()->take(10)->get(),
            'playersCount' => Player::count(),
            'matchesCount' => MatchGame::count(),
            'finishedMatchesCount' => MatchGame::where('status', 'finished')->count(),
        ]);
    }
}
