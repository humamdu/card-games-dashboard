# Card Games Dashboard

A production-ready Laravel 10 Blade application for managing live scorekeeping, historical rounds, teams, and leaderboards for Trex, Tarneeb 41, Tarneeb 61, Konkan, and Kanasah.

## Core Features

- Players CRUD through Laravel web routes and Blade forms.
- Matches CRUD through Laravel web routes with dynamic teams per match.
- Round and round-result persistence for full match history.
- Strategy-pattern game engine architecture.
- Engines for Trex, Tarneeb 41, Tarneeb 61, Konkan, and Kanasah.
- Service layer: `MatchService`, `ScoreService`, and `TeamService`.
- Blade pages for dashboard, match creation, live scoring, players, and leaderboard.

## Stack

- Laravel 10 / PHP 8.1+
- Laravel Blade server-rendered frontend
- MySQL 8+ or SQLite for local development

## Installation

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

## Web Route Overview

- `GET /`
- `GET|POST /players`
- `GET /players/{player}/edit`
- `PUT|DELETE /players/{player}`
- `GET|POST /matches`
- `GET /matches/create`
- `GET|DELETE /matches/{match}`
- `POST /matches/{match}/rounds`
- `GET /leaderboard`

## Documentation

- [Architecture](docs/ARCHITECTURE.md)
- [Database](docs/DATABASE.md)
- [Game Rules](docs/GAME_RULES.md)
- [Web Routes](docs/WEB_ROUTES.md)
- [Deployment](docs/DEPLOYMENT.md)
