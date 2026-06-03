@extends('layouts.app')

@section('title', __('ui.players').' | '.__('ui.site_name'))

@section('content')
<section class="stack">
    <form class="card stack" method="POST" action="{{ route('players.store') }}">
        @csrf
        <h1>{{ __('ui.players_management') }}</h1>
        <div class="grid">
            <label>{{ __('ui.name') }} <input name="name" value="{{ old('name') }}" required></label>
            <label>{{ __('ui.email') }} <input name="email" type="email" value="{{ old('email') }}"></label>
            <label>{{ __('ui.nickname') }} <input name="nickname" value="{{ old('nickname') }}"></label>
        </div>
        <div><button>{{ __('ui.add_player') }}</button></div>
    </form>

    <div class="card">
        <div style="overflow-x: auto;">
            <table class="table">
                <thead><tr><th>{{ __('ui.name') }}</th><th>{{ __('ui.nickname') }}</th><th>{{ __('ui.email') }}</th><th>{{ __('ui.actions') }}</th></tr></thead>
                <tbody>
                    @forelse ($players as $player)
                        <tr>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->nickname ?: '—' }}</td>
                            <td>{{ $player->email ?: '—' }}</td>
                            <td class="row">
                                <a class="button secondary" href="{{ route('players.edit', $player) }}">{{ __('ui.edit') }}</a>
                                <form method="POST" action="{{ route('players.destroy', $player) }}" onsubmit="return confirm('Delete this player?')">
                                    @csrf @method('DELETE')
                                    <button class="danger">{{ __('ui.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="muted">{{ __('ui.no_players') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $players->links() }}
    </div>
</section>
@endsection
