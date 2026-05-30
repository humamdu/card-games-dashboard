@extends('layouts.app')

@section('title', 'Matches | Card Games Dashboard')

@section('content')
<section class="card stack">
    <div class="row" style="justify-content: space-between">
        <h1>Matches</h1>
        <a class="button" href="{{ route('matches.create') }}">Create match</a>
    </div>
    <table class="table">
        <thead><tr><th>ID</th><th>Game</th><th>Status</th><th>Teams</th><th>Winner</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse ($matches as $match)
                <tr>
                    <td>#{{ $match->id }}</td>
                    <td>{{ $match->game_type->value }}</td>
                    <td>{{ $match->status }}</td>
                    <td>{{ $match->teams->map(fn ($team) => $team->name.' ('.$team->score.')')->join(', ') }}</td>
                    <td>{{ $match->winnerTeam?->name ?? '—' }}</td>
                    <td class="row">
                        <a class="button secondary" href="{{ route('matches.show', $match) }}">Score</a>
                        <form method="POST" action="{{ route('matches.destroy', $match) }}" onsubmit="return confirm('Delete this match and all rounds?')">
                            @csrf @method('DELETE')
                            <button class="danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">No matches have been created.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $matches->links() }}
</section>
@endsection
