<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoundRequest;
use App\Models\MatchGame;
use App\Services\MatchService;
use InvalidArgumentException;
use Illuminate\Http\RedirectResponse;

class RoundController extends Controller
{
    public function __construct(private readonly MatchService $matchService)
    {
    }

    public function store(StoreRoundRequest $request, MatchGame $match): RedirectResponse
    {
        try {
            $this->matchService->addRound($match, $request->validated());

            return redirect()->route('matches.show', $match)->with('status', 'Round scored successfully.');
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', __('ui.unexpected_error'));
        }
    }
}
