@extends('layouts.app')

@section('title', 'Offline')

@section('content')
    <div class="card">
        <h1>Offline mode</h1>
        <p>You are offline. Cached pages are available, and you can return to the dashboard when connectivity is restored.</p>
        <div class="row">
            <a href="{{ route('dashboard') }}" class="button">Go back home</a>
        </div>
    </div>
@endsection
