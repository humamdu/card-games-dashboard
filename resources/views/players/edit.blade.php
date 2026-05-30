@extends('layouts.app')

@section('title', 'Edit Player | Card Games Dashboard')

@section('content')
<form class="card stack" method="POST" action="{{ route('players.update', $player) }}">
    @csrf
    @method('PUT')
    <h1>Edit {{ $player->name }}</h1>
    <div class="grid">
        <label>Name <input name="name" value="{{ old('name', $player->name) }}" required></label>
        <label>Email <input name="email" type="email" value="{{ old('email', $player->email) }}"></label>
        <label>Nickname <input name="nickname" value="{{ old('nickname', $player->nickname) }}"></label>
    </div>
    <div class="row">
        <button>Save changes</button>
        <a class="button secondary" href="{{ route('players.index') }}">Cancel</a>
    </div>
</form>
@endsection
