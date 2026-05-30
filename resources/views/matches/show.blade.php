@extends('layouts.app')

@section('title', 'Match #'.$match->id.' | Card Games Dashboard')

@section('content')
<section class="stack">
    <div class="card stack">
        <div class="row" style="justify-content: space-between">
            <div>
                <span class="badge">{{ $match->game_type->value }}</span>
                <h1>Match #{{ $match->id }}</h1>
                <p class="muted">Status: {{ $match->status }} @if($match->winnerTeam) • Winner: {{ $match->winnerTeam->name }} @endif</p>
            </div>
            <a class="button secondary" href="{{ route('matches.index') }}">All matches</a>
        </div>
    </div>

    <div class="grid">
        @foreach ($match->teams as $team)
            <div class="card">
                <h2>{{ $team->name }}</h2>
                <strong>{{ $team->score }} pts</strong>
                <p class="muted">{{ $team->players->pluck('name')->join(', ') }}</p>
            </div>
        @endforeach
    </div>

    @if ($match->status !== 'finished')
        <form class="card stack" method="POST" action="{{ route('matches.rounds.store', $match) }}">
            @csrf
            <h2>Score next round</h2>
            <div class="grid">
                <label>Round number <input type="number" name="number" value="{{ old('number', $match->rounds->count() + 1) }}" min="1"></label>
                <label>Kingdom <input name="kingdom" value="{{ old('kingdom') }}" placeholder="Trex kingdom"></label>
                <label>Contract
                    <select name="contract">
                        <option value="">Manual / not applicable</option>
                        <option value="king_of_hearts">Trex: King of Hearts</option>
                        <option value="queens">Trex: Queens</option>
                        <option value="diamonds">Trex: Diamonds</option>
                        <option value="collections">Trex: Collections</option>
                        <option value="trex">Trex: Trex</option>
                    </select>
                </label>
                <label>Bid team
                    <select name="bid_team_id">
                        <option value="">No bid</option>
                        @foreach ($match->teams as $team)
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Bid amount <input type="number" name="bid_amount" value="{{ old('bid_amount') }}"></label>
            </div>

            <h3>Trex / Konkan score input</h3>
            <p class="muted">For Trex penalty contracts, enter captured item counts. For Trex contract, enter placement score. For Konkan, enter the round score added to each team.</p>
            <div class="grid">
                @foreach ($match->teams as $team)
                    <label>{{ $team->name }} score/count
                        <input type="number" name="payload[scores][{{ $team->id }}]" value="{{ old('payload.scores.'.$team->id, 0) }}">
                    </label>
                @endforeach
            </div>

            <h3>Tarneeb tricks input</h3>
            <div class="grid">
                @foreach ($match->teams as $team)
                    <label>{{ $team->name }} tricks
                        <input type="number" name="payload[tricks][{{ $team->id }}]" value="{{ old('payload.tricks.'.$team->id, 0) }}">
                    </label>
                @endforeach
            </div>

            <h3>Kanasah card scoring input</h3>
            <div class="grid">
                @foreach ($match->teams as $team)
                    <div class="team-form stack">
                        <strong>{{ $team->name }}</strong>
                        <label>Card points <input type="number" name="payload[teams][{{ $team->id }}][card_points]" value="{{ old('payload.teams.'.$team->id.'.card_points', 0) }}"></label>
                        <label>Clean kanasta count <input type="number" name="payload[teams][{{ $team->id }}][kanasta]" value="{{ old('payload.teams.'.$team->id.'.kanasta', 0) }}"></label>
                        <label>Dirty kanasta count <input type="number" name="payload[teams][{{ $team->id }}][dirty_kanasta]" value="{{ old('payload.teams.'.$team->id.'.dirty_kanasta', 0) }}"></label>
                        <label>Trisa count <input type="number" name="payload[teams][{{ $team->id }}][trisa]" value="{{ old('payload.teams.'.$team->id.'.trisa', 0) }}"></label>
                        <label>Jokers <input type="number" name="payload[teams][{{ $team->id }}][jokers]" value="{{ old('payload.teams.'.$team->id.'.jokers', 0) }}"></label>
                        <label>Penalties <input type="number" name="payload[teams][{{ $team->id }}][penalties]" value="{{ old('payload.teams.'.$team->id.'.penalties', 0) }}"></label>
                    </div>
                @endforeach
            </div>

            <button>Save scored round</button>
        </form>
    @else
        <div class="notice">This match is finished and no more rounds can be scored.</div>
    @endif

    <div class="card">
        <h2>Round history</h2>
        <table class="table">
            <thead><tr><th>Round</th><th>Contract</th><th>Bid</th><th>Results</th></tr></thead>
            <tbody>
                @forelse ($match->rounds as $round)
                    <tr>
                        <td>#{{ $round->number }}</td>
                        <td>{{ $round->contract ?: '—' }}</td>
                        <td>{{ $round->bidTeam?->name ?? '—' }} {{ $round->bid_amount ? '(' . $round->bid_amount . ')' : '' }}</td>
                        <td>
                            @foreach ($round->results as $result)
                                <div>{{ $result->team->name }}: {{ $result->score_delta }} <span class="muted">raw {{ $result->raw_score }}</span></div>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">No rounds scored yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
