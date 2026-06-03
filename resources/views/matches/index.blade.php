@extends('layouts.app')

@section('title', __('ui.matches').' | '.__('ui.site_name'))

@section('content')
<section class="card stack">
    <div class="row" style="justify-content: space-between;">
        <h1>{{ __('ui.matches') }}</h1>
        <a class="button" href="{{ route('matches.create') }}">{{ __('ui.create_match') }}</a>
    </div style="overflow-x: auto;">
    <table class="table">
        <thead><tr><th>{{ __('ui.id') }}</th><th>{{ __('ui.game') }}</th><th>{{ __('ui.status') }}</th><th>{{ __('ui.teams') }}</th><th>{{ __('ui.winner') }}</th><th>{{ __('ui.actions') }}</th></tr></thead>
        <tbody>
            @forelse ($matches as $match)
                <tr>
                    <td>#{{ $match->id }}</td>
                    <td>{{ __('ui.game_types.' . $match->game_type->value) }}</td>
                    <td>{{ $match->status }}</td>
                    <td>{{ $match->teams->map(fn ($team) => $team->name.' ('.$team->score.')')->join(', ') }}</td>
                    <td>{{ $match->winnerTeam?->name ?? '—' }}</td>
                    <td class="row">
                        <a class="button secondary" href="{{ route('matches.show', $match) }}">{{ __('ui.score') }}</a>
                        <form method="POST" action="{{ route('matches.destroy', $match) }}" onsubmit="return confirm('Delete this match and all rounds?')">
                            @csrf @method('DELETE')
                            <button class="danger">{{ __('ui.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">{{ __('ui.no_matches') }}</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $matches->links() }}
</section>
@endsection
