@extends('layouts.app')

@section('title', __('ui.create_match').' | '.__('ui.site_name'))

@section('content')
<form class="stack" method="POST" action="{{ route('matches.store') }}">
    @csrf
    <div class="card stack">
        <h1>{{ __('ui.create_match') }}</h1>
        <label>{{ __('ui.game_type') }}
            <select name="game_type" required>
                @foreach ($gameTypes as $gameType)
                    <option value="{{ $gameType->value }}" @selected(old('game_type', 'kanasah') === $gameType->value)>{{ __('ui.game_types.' . $gameType->value) }}</option>
                @endforeach
            </select>
        </label>
    </div>

    <div id="teams" class="grid">
        @php($oldTeams = old('teams', [['name' => 'T1', 'active'=>true, 'player_ids' => []], ['name' => 'T2', 'active'=>true, 'player_ids' => []], ['name' => 'T3', 'active'=>false, 'player_ids' => []], ['name' => 'T4', 'active'=>false, 'player_ids' => []]]))
        @foreach ($oldTeams as $index => $team)
            <div class="card team-form stack">
                <div class="row" style="justify-content: space-between; align-items: center;"><h2>{{ __('ui.team') }} {{ $index + 1 }}</h2><button type="button" class="secondary" onclick="this.closest('.team-form').remove()">{{ __('ui.remove') }}</button></div>
                <input type="hidden" name="teams[{{ $index }}][position]" value="{{ $index + 1 }}">
                <label>{{ __('ui.team_name') }} <input name="teams[{{ $index }}][name]" value="{{ $team['name'] ?? __('ui.team').' '.($index + 1) }}" required></label>
                <label>{{ __('ui.players_label') }}
                    <input style="margin-left: -200%;" type="checkbox" name="teams[{{ $index }}][active]" id="teams-{{ $index }}-active" @checked($team['active'] ?? false)>
                    <select name="teams[{{ $index }}][player_ids][]" multiple required>
                        @foreach ($players as $player)
                            <option value="{{ $player->id }}" @selected(in_array($player->id, $team['player_ids'] ?? []))>{{ $player->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        @endforeach
    </div>

    <div class="row">
        <button style="display: none;" type="button" class="secondary" id="add-team">{{ __('ui.add_dynamic_team') }}</button>
        <button>{{ __('ui.create_match') }}</button>
    </div>
</form>

<template id="team-template">
    <div class="card team-form stack">
        <div class="row" style="justify-content: space-between"><h2 data-team-title></h2><button type="button" class="secondary" onclick="this.closest('.team-form').remove()">{{ __('ui.remove') }}</button></div>
        <input type="hidden" data-position>
        <label>{{ __('ui.team_name') }} <input data-team-name required></label>
        <label>{{ __('ui.players_label') }}
            <select data-team-players multiple required>
                @foreach ($players as $player)
                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                @endforeach
            </select>
        </label>
    </div>
</template>
@endsection

@push('scripts')
<script>
    document.querySelector(`[name="teams[2][player_ids][]"]`).required = false;
    document.querySelector(`[name="teams[3][player_ids][]"]`).required = false;

    document.getElementById('add-team').addEventListener('click', () => {
        const teams = document.getElementById('teams');
        const index = teams.querySelectorAll('.team-form').length;
        const clone = document.getElementById('team-template').content.cloneNode(true);
        clone.querySelector('[data-team-title]').textContent = `Team ${index + 1}`;
        clone.querySelector('[data-position]').name = `teams[${index}][position]`;
        clone.querySelector('[data-position]').value = index + 1;
        clone.querySelector('[data-team-name]').name = `teams[${index}][name]`;
        clone.querySelector('[data-team-name]').value = `Team ${index + 1}`;
        clone.querySelector('[data-team-players]').name = `teams[${index}][player_ids][]`;
        teams.appendChild(clone);
    });

    const is_active_team2 = document.getElementById('teams-2-active');
    is_active_team2.addEventListener('change', () => {
        if (is_active_team2.checked) {
            document.querySelector(`[name="teams[2][player_ids][]"]`).required = true;
        } else {
            document.querySelector(`[name="teams[2][player_ids][]"]`).required = false;
        }
    });

    const is_active_team3 = document.getElementById('teams-3-active');
    is_active_team3.addEventListener('change', () => {
        if (is_active_team3.checked) {
            document.querySelector(`[name="teams[3][player_ids][]"]`).required = true;
        } else {
            document.querySelector(`[name="teams[3][player_ids][]"]`).required = false;
        }
    });
</script>
@endpush
