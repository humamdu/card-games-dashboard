# Architecture

## Layers

1. **Web Controllers** expose named Laravel web routes and return Blade views or redirects.
2. **Form Requests** validate Blade form submissions before they reach business logic.
3. **Services** coordinate workflows:
   - `MatchService` creates matches and appends rounds.
   - `TeamService` creates dynamic teams and attaches players.
   - `ScoreService` resolves game engines, persists round results, and updates match totals.
4. **Game Engines** implement `GameEngineInterface` using the Strategy Pattern.
5. **Models** own relationships and casting for persisted state.

## Game Engine Strategy

`GameEngineFactory` maps the match `game_type` enum to one of:

- `TrexEngine`
- `Tarneeb41Engine`
- `Tarneeb61Engine`
- `KonkanEngine`
- `KanasahEngine`

Each engine implements:

- `calculateRoundResults()`
- `updateMatchScore()`
- `hasWinner()`
- `winner()`

## Frontend

The UI is rendered with Laravel Blade templates under `resources/views` and named routes in `routes/web.php` for:

- Dashboard home
- Create match
- Match live scoring
- Players management
- Leaderboard

A small inline vanilla JavaScript helper in the create-match Blade template adds dynamic team form sections without requiring Vue, Vite, or an npm build.
