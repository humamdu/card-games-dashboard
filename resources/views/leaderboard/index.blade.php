@extends('layouts.app')

@section('title', 'Leaderboard | Card Games Dashboard')

@section('content')
<section class="card">
    <h1>Leaderboard</h1>
    <table class="table">
        <thead><tr><th>Rank</th><th>Player</th><th>Matches</th><th>Wins</th><th>Total score</th></tr></thead>
        <tbody>
            @forelse ($players as $index => $player)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->matches_played }}</td>
                    <td>{{ $player->wins }}</td>
                    <td>{{ $player->total_score }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">No leaderboard data yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection
