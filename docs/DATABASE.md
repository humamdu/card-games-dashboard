# Database

## Tables

## `players`
Stores player identity, optional email, nickname, and metadata.

## `matches`
Stores game type, lifecycle status, JSON settings, denormalized scoreboard snapshot, winner team, and timestamps.

## `teams`
Dynamic teams scoped to each match. A Trex game should create four one-player teams; Tarneeb/Konkan/Kanasah can create team-based rows.

## `player_team`
Many-to-many assignment of players to teams.

## `rounds`
Stores ordered match rounds with optional kingdom, contract, bid team, bid amount, and raw payload.

## `round_results`
Stores immutable per-team or per-player result rows for every round, including raw score, score delta, and details JSON.

## History Model

Match history is retained through `rounds` and `round_results`. The `matches.scoreboard` column is a snapshot optimized for dashboard reads and can be rebuilt from team totals and historical results.
