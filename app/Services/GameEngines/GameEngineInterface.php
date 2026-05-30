<?php

namespace App\Services\GameEngines;

use App\Models\MatchGame;
use App\Models\Round;

interface GameEngineInterface
{
    public function calculateRoundResults(MatchGame $match, Round $round, array $input): array;

    public function updateMatchScore(MatchGame $match, Round $round, array $results): array;

    public function hasWinner(MatchGame $match): bool;

    public function winner(MatchGame $match): ?array;
}
