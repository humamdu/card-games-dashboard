@extends('layouts.app')

@section('title', __('ui.home').' | '.__('ui.site_name'))

@section('content')
<section class="stack">
    
    <div class="card stack">
        <div>
            <h1>{{ __('ui.live_scoring') }}</h1>
            <p class="muted">{{ __('ui.dashboard_description') }}</p>
        </div>
        <div class="grid">
            <div class="card"><span class="badge">{{ __('ui.players') }}</span><h2>{{ $playersCount }}</h2></div>
            <div class="card"><span class="badge">{{ __('ui.matches') }}</span><h2>{{ $matchesCount }}</h2></div>
            <div class="card"><span class="badge">{{ __('ui.finish') }}</span><h2>{{ $finishedMatchesCount }}</h2></div>
        </div>    
    </div>

    <div class="card stack">
        <div class="row" style="justify-content: space-between">
            <h2>{{ __('ui.active_matches') }}</h2>
            <a class="button" href="{{ route('matches.create') }}">{{ __('ui.create_match') }}</a>
        </div>
        <div class="grid">
            @forelse ($activeMatches as $match)
                <a class="card" href="{{ route('matches.show', $match) }}">
                    <span class="badge">{{ __('ui.game_types.' . $match->game_type->value) }}</span>
                    <h3>{{ __('ui.match') }} #{{ $match->id }}</h3>
                    <p class="muted">{{ $match->teams->pluck('name')->join(' vs ') }}</p>
                </a>
            @empty
                <p class="muted">{{ __('ui.no_active_matches') }}</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <h2>{{ __('ui.recent_matches') }}</h2>
        <div style="overflow-x: auto;">
            <table class="table">
                <thead><tr><th>{{ __('ui.id') }}</th><th>{{ __('ui.game') }}</th><th>{{ __('ui.status') }}</th><th>{{ __('ui.teams') }}</th><th></th></tr></thead>
                <tbody>
                    @foreach ($recentMatches as $match)
                        <tr>
                            <td>#{{ $match->id }}</td>
                            <td>{{ __('ui.game_types.' . $match->game_type->value) }}</td>
                            <td>{{ $match->status }}</td>
                            <td>{{ $match->teams->pluck('name')->join(', ') }}</td>
                            <td><a class="button secondary" href="{{ route('matches.show', $match) }}">{{ __('ui.open') }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
