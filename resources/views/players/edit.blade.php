@extends('layouts.app')

@section('title', __('ui.edit').' | '.__('ui.site_name'))

@section('content')
<form class="card stack" method="POST" action="{{ route('players.update', $player) }}">
    @csrf
    @method('PUT')
    <h1>{{ __('ui.edit') }} {{ $player->name }}</h1>
    <div class="grid">
        <label>{{ __('ui.name') }} <input name="name" value="{{ old('name', $player->name) }}" required></label>
        <label>{{ __('ui.email') }} <input name="email" type="email" value="{{ old('email', $player->email) }}"></label>
        <label>{{ __('ui.nickname') }} <input name="nickname" value="{{ old('nickname', $player->nickname) }}"></label>
    </div>
    <div class="row">
        <button>{{ __('ui.save_changes') }}</button>
        <a class="button secondary" href="{{ route('players.index') }}">{{ __('ui.cancel') }}</a>
    </div>
</form>
@endsection
