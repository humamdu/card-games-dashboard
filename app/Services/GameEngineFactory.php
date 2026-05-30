<?php

namespace App\Services;

use App\Enums\GameType;
use App\Services\GameEngines\GameEngineInterface;
use App\Services\GameEngines\KanasahEngine;
use App\Services\GameEngines\KonkanEngine;
use App\Services\GameEngines\Tarneeb41Engine;
use App\Services\GameEngines\Tarneeb61Engine;
use App\Services\GameEngines\TrexEngine;

class GameEngineFactory
{
    public function make(GameType|string $gameType): GameEngineInterface
    {
        $type = $gameType instanceof GameType ? $gameType : GameType::from($gameType);

        return match ($type) {
            GameType::Trex => new TrexEngine(),
            GameType::Tarneeb41 => new Tarneeb41Engine(),
            GameType::Tarneeb61 => new Tarneeb61Engine(),
            GameType::Konkan => new KonkanEngine(),
            GameType::Kanasah => new KanasahEngine(),
        };
    }
}
