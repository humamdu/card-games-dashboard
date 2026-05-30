<?php

namespace App\Http\Controllers\Web;

use App\Enums\GameType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMatchRequest;
use App\Models\MatchGame;
use App\Models\Player;
use App\Services\MatchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MatchController extends Controller
{
    public function __construct(private readonly MatchService $matchService)
    {
    }

    public function index(): View
    {
        return view('matches.index', ['matches' => MatchGame::with('teams.players', 'winnerTeam')->latest()->paginate(20)]);
    }

    public function create(): View
    {
        return view('matches.create', [
            'gameTypes' => GameType::cases(),
            'players' => Player::orderBy('name')->get(),
        ]);
    }

    public function store(StoreMatchRequest $request): RedirectResponse
    {
        $match = $this->matchService->create($request->validated());

        return redirect()->route('matches.show', $match)->with('status', 'Match created successfully.');
    }

    public function show(MatchGame $match): View
    {
        return view('matches.show', [
            'match' => $match->load('teams.players', 'rounds.bidTeam', 'rounds.results.team', 'rounds.results.player', 'winnerTeam'),
        ]);
    }

    public function destroy(MatchGame $match): RedirectResponse
    {
        $match->delete();

        return redirect()->route('matches.index')->with('status', 'Match deleted successfully.');
    }
}
