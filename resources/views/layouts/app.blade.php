<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Card Games Dashboard')</title>
    <style>
        :root { color-scheme: dark; font-family: Inter, ui-sans-serif, system-ui, sans-serif; background: #0f172a; color: #e2e8f0; }
        * { box-sizing: border-box; }
        body { margin: 0; }
        a { color: inherit; text-decoration: none; }
        button, .button, input, select { border: 0; border-radius: .75rem; padding: .75rem 1rem; }
        button, .button { display: inline-flex; align-items: center; justify-content: center; background: #38bdf8; color: #082f49; font-weight: 800; cursor: pointer; }
        .button.secondary, button.secondary { background: #334155; color: #e2e8f0; }
        .button.danger, button.danger { background: #f87171; color: #450a0a; }
        input, select { background: #020617; color: #e2e8f0; border: 1px solid #334155; width: 100%; }
        select[multiple] { min-height: 8rem; }
        label { display: grid; gap: .4rem; color: #cbd5e1; font-weight: 700; }
        .layout { max-width: 1180px; margin: 0 auto; padding: 2rem; }
        .nav { display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; }
        .nav a { padding: .65rem 1rem; background: #1e293b; border-radius: 999px; }
        .nav a:hover, .nav a.active { background: #0e7490; }
        .card { background: #111827; border: 1px solid #334155; border-radius: 1.25rem; padding: 1.25rem; box-shadow: 0 20px 60px rgba(0,0,0,.25); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; }
        .stack { display: grid; gap: 1rem; }
        .row { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: .85rem; border-bottom: 1px solid #334155; text-align: left; vertical-align: top; }
        .badge { display: inline-flex; padding: .3rem .65rem; border-radius: 999px; background: #134e4a; color: #99f6e4; font-size: .8rem; font-weight: 800; }
        .notice { border: 1px solid #22c55e; color: #bbf7d0; background: #052e16; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; }
        .errors { border: 1px solid #f87171; color: #fecaca; background: #450a0a; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; }
        .muted { color: #94a3b8; }
        .team-form { border: 1px dashed #475569; border-radius: 1rem; padding: 1rem; }
    </style>
</head>
<body>
    <main class="layout">
        <nav class="nav">
            <strong>Card Games Dashboard</strong>
            <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Home</a>
            <a href="{{ route('matches.index') }}" @class(['active' => request()->routeIs('matches.*')])>Matches</a>
            <a href="{{ route('matches.create') }}">Create Match</a>
            <a href="{{ route('players.index') }}" @class(['active' => request()->routeIs('players.*')])>Players</a>
            <a href="{{ route('leaderboard') }}" @class(['active' => request()->routeIs('leaderboard')])>Leaderboard</a>
        </nav>

        @if (session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">
                <strong>Please fix the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
