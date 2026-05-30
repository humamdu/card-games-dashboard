<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        return view('players.index', ['players' => Player::latest()->paginate(25)]);
    }

    public function store(StorePlayerRequest $request): RedirectResponse
    {
        Player::create($request->validated());

        return redirect()->route('players.index')->with('status', 'Player created successfully.');
    }

    public function edit(Player $player): View
    {
        return view('players.edit', compact('player'));
    }

    public function update(UpdatePlayerRequest $request, Player $player): RedirectResponse
    {
        $player->update($request->validated());

        return redirect()->route('players.index')->with('status', 'Player updated successfully.');
    }

    public function destroy(Player $player): RedirectResponse
    {
        $player->delete();

        return redirect()->route('players.index')->with('status', 'Player deleted successfully.');
    }
}
