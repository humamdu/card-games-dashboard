@extends('layouts.app')

@section('title', 'Create Match | Card Games Dashboard')

@section('content')
<form class="stack" method="POST" action="{{ route('matches.store') }}">
    @csrf
    <div class="card stack">
        <h1>Create match</h1>
        <label>Game type
            <select name="game_type" required>
                @foreach ($gameTypes as $gameType)
                    <option value="{{ $gameType->value }}" @selected(old('game_type', 'tarneeb_41') === $gameType->value)>{{ $gameType->value }}</option>
                @endforeach
            </select>
        </label>
        <p class="muted">Trex should use four one-player teams. Other games can use any dynamic team setup supported by your table rules.</p>
    </div>

    <div id="teams" class="stack">
        @php($oldTeams = old('teams', [['name' => 'Team 1', 'player_ids' => []], ['name' => 'Team 2', 'player_ids' => []]]))
        @foreach ($oldTeams as $index => $team)
            <div class="card team-form stack">
                <div class="row" style="justify-content: space-between"><h2>Team {{ $index + 1 }}</h2><button type="button" class="secondary" onclick="this.closest('.team-form').remove()">Remove</button></div>
                <input type="hidden" name="teams[{{ $index }}][position]" value="{{ $index + 1 }}">
                <label>Team name <input name="teams[{{ $index }}][name]" value="{{ $team['name'] ?? 'Team '.($index + 1) }}" required></label>
                <label>Players
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
        <button type="button" class="secondary" id="add-team">Add dynamic team</button>
        <button>Create match</button>
    </div>
</form>

<template id="team-template">
    <div class="card team-form stack">
        <div class="row" style="justify-content: space-between"><h2 data-team-title></h2><button type="button" class="secondary" onclick="this.closest('.team-form').remove()">Remove</button></div>
        <input type="hidden" data-position>
        <label>Team name <input data-team-name required></label>
        <label>Players
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
</script>
@endpush
