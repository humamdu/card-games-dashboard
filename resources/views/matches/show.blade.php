@extends('layouts.app')

@section('title', __('ui.match').' #'.$match->id.' | '.__('ui.site_name'))

@section('content')
<section class="stack">
    <div class="card stack">
        <div class="row" style="justify-content: space-between">
            <div style="display: grid;grid-auto-flow: column;gap: 2rem; align-items: baseline;">
                <span class="badge">{{ __('ui.game_types.' . $match->game_type->value) }}</span>
                <h3>{{ __('ui.match') }} #{{ $match->id }}</h3>
                <p class="muted">{{ __('ui.status') }}: {{ $match->status }} @if($match->winnerTeam) • {{ __('ui.winner') }}: {{ $match->winnerTeam->name }} @endif</p>
            </div>
            <a class="button secondary" href="{{ route('matches.index') }}">{{ __('ui.matches') }}</a>
        </div>

        <div class="grid">
            @foreach ($match->teams as $team)
                <div class="card">
                    <div class="grid" style="grid-auto-flow: auto;align-items: baseline;">
                        <h2>{{ $team->name }}</h2>
                        <strong>{{ $team->score }} Pts</strong>
                    </div>
                    <p class="muted">{{ $team->players->pluck('name')->join(', ') }}</p>
                </div>
            @endforeach
        </div>
    </div>


    @if ($match->status !== 'finished')
        <form class="card stack" method="POST" action="{{ route('matches.rounds.store', $match) }}">
            @csrf
            <div class="grid">
                <h2>{{ __('ui.score_next_round') }}</h2>
                <label style="display: none;">{{ __('ui.round') }} <input type="number" name="number" value="{{ old('number', $match->rounds->count() + 1) }}" min="1"></label>
                @if ($match->game_type->value === 'trex')
                    <label>{{ __('ui.kingdom') }} <input name="kingdom" value="{{ old('kingdom') }}" placeholder="{{ __('ui.kingdom') }}"></label>
                    <label>{{ __('ui.contract_label') }}
                        <select name="contract">
                            <option value="">{{ __('ui.manual_not_applicable') }}</option>
                            <option value="king_of_hearts">Trex: King of Hearts</option>
                            <option value="queens">Trex: Queens</option>
                            <option value="diamonds">Trex: Diamonds</option>
                            <option value="collections">Trex: Collections</option>
                            <option value="trex">Trex: Trex</option>
                        </select>
                    </label>
                @endif
                @if ($match->game_type->value === 'tarneeb_61')
                    <label>{{ __('ui.bid_team') }}
                        <select name="bid_team_id">
                            <option value="">{{ __('ui.no_bid') }}</option>
                            @foreach ($match->teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>{{ __('ui.bid_amount') }}
                        <div class="stepper">
                            <div class="stepper-row">
                                <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                <input type="number" name="bid_amount" value="{{ old('bid_amount') }}">
                                <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                            </div>
                        </div>
                    </label>
                @endif
            </div>

            @if ($match->game_type->value === 'trex') 
                <!-- <h3>{{ __('ui.score_input') }}</h3> -->
                <div class="grid">
                    @foreach ($match->teams as $team)
                        <label>{{ $team->name }} {{ __('ui.score_count') }}
                            <div class="stepper">
                                <div class="stepper-row">
                                    <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                    <input type="number" name="payload[scores][{{ $team->id }}]" value="{{ old('payload.scores.'.$team->id, 0) }}">
                                    <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif

            @if ($match->game_type->value === 'konkan') 
                <!-- <h3>{{ __('ui.score_input') }}</h3> -->
                <div class="grid">
                    @foreach ($match->teams as $team)
                        <label>{{ $team->name }} {{ __('ui.score_count') }}
                            <div class="stepper">
                                <div class="stepper-row">
                                    <button type="button" class="stepper-button" data-step="25" aria-label="Decrease">25</button>
                                    <input type="number" name="payload[scores][{{ $team->id }}]" value="{{ old('payload.scores.'.$team->id, 0) }}">
                                    <button type="button" class="stepper-button" data-step="10" aria-label="Increase">10</button>
                                    <button type="button" class="stepper-button" data-step="100" aria-label="Increase">100</button>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif

            @if ($match->game_type->value === 'tarneeb_41')
                <h3>{{ __('ui.player_bids') }}</h3>
                <div class="grid">
                    @foreach ($match->teams as $team)
                        <div class="team-form stack">
                            <strong>{{ $team->name }}</strong>
                            @foreach ($team->players as $player)
                                <label>{{ $player->name }} {{ __('ui.bid') }}
                                    <div class="stepper">
                                        <div class="stepper-row">
                                            <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                            <input type="number" name="payload[bids][{{ $player->id }}]" value="{{ old('payload.bids.'.$player->id, 0) }}" required>
                                            <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                        </div>
                                    </div>
                                </label>
                                <label>{{ $player->name }} {{ __('ui.tricks') }}
                                    <div class="stepper">
                                        <div class="stepper-row">
                                            <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                            <input type="number" name="payload[tricks][{{ $player->id }}]" value="{{ old('payload.tricks.'.$player->id, 0) }}" required>
                                            <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($match->game_type->value === 'kanasah')
                <!-- <h3>{{ __('ui.score_input') }}</h3> -->
                <div class="grid">
                    @foreach ($match->teams as $team)
                        <div class="team-form stack">
                            <strong>{{ $team->name }}</strong>
                            <label>{{ __('ui.joker_kanasta') }}
                                <div class="stepper">
                                    <div class="stepper-row">
                                        <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                        <input type="number" name="payload[teams][{{ $team->id }}][joker_kanasta]" value="{{ old('payload.teams.'.$team->id.'.joker_kanasta', 0) }}">
                                        <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                    </div>
                                </div>
                            </label>
                            <label>{{ __('ui.clean_kanasta') }}
                                <div class="stepper">
                                    <div class="stepper-row">
                                        <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                        <input type="number" name="payload[teams][{{ $team->id }}][kanasta]" value="{{ old('payload.teams.'.$team->id.'.kanasta', 0) }}">
                                        <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                    </div>
                                </div>
                            </label>
                            <label>{{ __('ui.dirty_kanasta') }}
                                <div class="stepper">
                                    <div class="stepper-row">
                                        <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                        <input type="number" name="payload[teams][{{ $team->id }}][dirty_kanasta]" value="{{ old('payload.teams.'.$team->id.'.dirty_kanasta', 0) }}">
                                        <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                    </div>
                                </div>
                            </label>
                            <label>{{ __('ui.trisa') }}
                                <div class="stepper">
                                    <div class="stepper-row">
                                        <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                        <input type="number" name="payload[teams][{{ $team->id }}][trisa]" value="{{ old('payload.teams.'.$team->id.'.trisa', 0) }}">
                                        <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                    </div>
                                </div>
                            </label>
                            <label>{{ __('ui.card_points') }}
                                <div class="stepper">
                                    <div class="stepper-row">
                                        <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                        <input type="number" name="payload[teams][{{ $team->id }}][card_points]" value="{{ old('payload.teams.'.$team->id.'.card_points', 0) }}">
                                        <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                        <button type="button" class="stepper-button" data-step="10" aria-label="Increase">++</button>
                                    </div>
                                </div>
                            </label>
                            <label>{{ __('ui.jokers') }}
                                <div class="stepper">
                                    <div class="stepper-row">
                                        <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                        <input type="number" name="payload[teams][{{ $team->id }}][jokers]" value="{{ old('payload.teams.'.$team->id.'.jokers', 0) }}">
                                        <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                    </div>
                                </div>
                            </label>
                            <label>{{ __('ui.penalties') }}
                                <div class="stepper">
                                    <div class="stepper-row">
                                        <button type="button" class="stepper-button" data-step="-1" aria-label="Decrease">−</button>
                                        <input type="number" name="payload[teams][{{ $team->id }}][penalties]" value="{{ old('payload.teams.'.$team->id.'.penalties', 0) }}">
                                        <button type="button" class="stepper-button" data-step="1" aria-label="Increase">+</button>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif

            <button>{{ __('ui.save_scored_round') }}</button>
        </form>
    @else
        <div class="notice">{{ __('ui.match_finished_notice') }}</div>
    @endif

    <div class="card">
        <h2>{{ __('ui.round_history') }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('ui.round') }}</th>
                    @if ($match->game_type->value === 'trex')
                    <th>{{ __('ui.contract') }}</th>
                    @endif
                    @if ($match->game_type->value === 'tarneeb_61')
                    <th>{{ __('ui.bid') }}</th>
                    @endif
                    @if ($match->game_type->value === 'tarneeb_41')
                    <th>1</th> <th>3</th> <th>2</th> <th>4</th>
                    @else
                    <th>{{ __('ui.results') }} ( 1</th>
                    <th>2 )</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($match->rounds as $round)
                    <tr>
                        <td>#{{ $round->number }}</td>
                        @if ($match->game_type->value === 'trex')
                        <td>{{ $round->contract ?: '—' }}</td>
                        @endif
                        @if ($match->game_type->value === 'tarneeb_61')
                        <td>{{ $round->bidTeam?->name ?? '—' }} {{ $round->bid_amount ? '(' . $round->bid_amount . ')' : '' }}</td>
                        @endif
                        @foreach ($round->results as $result)
                        <td>
                            <div>
                                <!-- {{ $result->player?->name ?? $result->team->name }}: -->
                                {{ $result->score_delta }}
                                <span class="muted">
                                    @if ($match->game_type->value === 'kanasah')
                                    {{ '*' }} 
                                    @elseif ($match->game_type->value === 'tarneeb_41')
                                    {{ '/' }}
                                    {{ $result->details['bid'] }}
                                    @endif
                                </span>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">{{ __('ui.no_rounds') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('click', function (event) {
        var button = event.target.closest('.stepper-button');
        if (!button) return;

        var row = button.closest('.stepper-row');
        if (!row) return;

        var input = row.querySelector('input[type="number"]');
        if (!input) return;

        var step = parseFloat(button.getAttribute('data-step')) || 1;
        var current = parseFloat(input.value);
        if (Number.isNaN(current)) current = 0;

        var next = current + step;
        if (input.hasAttribute('min')) {
            var min = parseFloat(input.min);
            if (!Number.isNaN(min) && next < min) next = min;
        }
        if (input.hasAttribute('max')) {
            var max = parseFloat(input.max);
            if (!Number.isNaN(max) && next > max) next = max;
        }

        input.value = Number.isInteger(current) && Number.isInteger(step) ? parseInt(next, 10) : next;
    });
</script>
@endpush
