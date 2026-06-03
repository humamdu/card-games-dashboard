@extends('layouts.app')

@section('title', __('ui.leaderboard').' | '.__('ui.site_name'))

@section('content')
<section class="card">
    <h1>{{ __('ui.leaderboard') }}</h1>
    <table class="table">
        <thead><tr><th>{{ __('ui.rank') }}</th><th>{{ __('ui.name') }}</th><th>{{ __('ui.matches') }}</th><th>{{ __('ui.wins') }}</th><th>{{ __('ui.total_score') }}</th></tr></thead>
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
                <tr><td colspan="5" class="muted">{{ __('ui.no_leaderboard') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection
