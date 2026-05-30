@extends('layouts.app')

@section('title', 'Players | Card Games Dashboard')

@section('content')
<section class="stack">
    <form class="card stack" method="POST" action="{{ route('players.store') }}">
        @csrf
        <h1>Players management</h1>
        <div class="grid">
            <label>Name <input name="name" value="{{ old('name') }}" required></label>
            <label>Email <input name="email" type="email" value="{{ old('email') }}"></label>
            <label>Nickname <input name="nickname" value="{{ old('nickname') }}"></label>
        </div>
        <div><button>Add player</button></div>
    </form>

    <div class="card">
        <table class="table">
            <thead><tr><th>Name</th><th>Nickname</th><th>Email</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse ($players as $player)
                    <tr>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->nickname ?: '—' }}</td>
                        <td>{{ $player->email ?: '—' }}</td>
                        <td class="row">
                            <a class="button secondary" href="{{ route('players.edit', $player) }}">Edit</a>
                            <form method="POST" action="{{ route('players.destroy', $player) }}" onsubmit="return confirm('Delete this player?')">
                                @csrf @method('DELETE')
                                <button class="danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">No players have been created.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $players->links() }}
    </div>
</section>
@endsection
