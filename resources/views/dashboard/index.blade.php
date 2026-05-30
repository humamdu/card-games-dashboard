@extends('layouts.app')

@section('title', 'Dashboard | Card Games Dashboard')

@section('content')
<section class="stack">
    <div class="card">
        <h1>Live card game scoring</h1>
        <p class="muted">Server-rendered Laravel Blade dashboard for Trex, Tarneeb 41, Tarneeb 61, Konkan, and Kanasah.</p>
    </div>

    <div class="grid">
        <div class="card"><span class="badge">Players</span><h2>{{ $playersCount }}</h2></div>
        <div class="card"><span class="badge">Matches</span><h2>{{ $matchesCount }}</h2></div>
        <div class="card"><span class="badge">Finished</span><h2>{{ $finishedMatchesCount }}</h2></div>
    </div>

    <div class="card stack">
        <div class="row" style="justify-content: space-between">
            <h2>Active matches</h2>
            <a class="button" href="{{ route('matches.create') }}">Create match</a>
        </div>
        <div class="grid">
            @forelse ($activeMatches as $match)
                <a class="card" href="{{ route('matches.show', $match) }}">
                    <span class="badge">{{ $match->game_type->value }}</span>
                    <h3>Match #{{ $match->id }}</h3>
                    <p class="muted">{{ $match->teams->pluck('name')->join(' vs ') }}</p>
                </a>
            @empty
                <p class="muted">No active matches yet.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <h2>Recent matches</h2>
        <table class="table">
            <thead><tr><th>ID</th><th>Game</th><th>Status</th><th>Teams</th><th></th></tr></thead>
            <tbody>
                @foreach ($recentMatches as $match)
                    <tr>
                        <td>#{{ $match->id }}</td>
                        <td>{{ $match->game_type->value }}</td>
                        <td>{{ $match->status }}</td>
                        <td>{{ $match->teams->pluck('name')->join(', ') }}</td>
                        <td><a class="button secondary" href="{{ route('matches.show', $match) }}">Open</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
