# Web Routes

The dashboard is now fully server-rendered with Laravel Blade and named web routes. No Vue, Vite, npm build, or JSON API is required for the primary application workflow.

## Dashboard

| Method | URI | Route name | Purpose |
| --- | --- | --- | --- |
| GET | `/` | `dashboard` | Home dashboard with active and recent matches. |

## Players

| Method | URI | Route name | Purpose |
| --- | --- | --- | --- |
| GET | `/players` | `players.index` | List players and display the create-player form. |
| POST | `/players` | `players.store` | Create a player. |
| GET | `/players/{player}/edit` | `players.edit` | Edit player form. |
| PUT/PATCH | `/players/{player}` | `players.update` | Update a player. |
| DELETE | `/players/{player}` | `players.destroy` | Delete a player. |

## Matches

| Method | URI | Route name | Purpose |
| --- | --- | --- | --- |
| GET | `/matches` | `matches.index` | List matches. |
| GET | `/matches/create` | `matches.create` | Create-match form with dynamic teams. |
| POST | `/matches` | `matches.store` | Create a match and attach teams/players. |
| GET | `/matches/{match}` | `matches.show` | Live scoring and match history page. |
| DELETE | `/matches/{match}` | `matches.destroy` | Delete a match and its rounds/results. |

## Rounds

| Method | URI | Route name | Purpose |
| --- | --- | --- | --- |
| POST | `/matches/{match}/rounds` | `matches.rounds.store` | Score and persist the next round for a match. |

## Leaderboard

| Method | URI | Route name | Purpose |
| --- | --- | --- | --- |
| GET | `/leaderboard` | `leaderboard` | Player leaderboard by wins and total score. |
