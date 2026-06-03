<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0f172a">
    <link rel="icon" href="{{ asset('icons/icon-192.svg') }}" sizes="192x192" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-512.svg') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title', __('ui.site_name'))</title>
    <style>
        :root { color-scheme: dark; font-family: Inter, ui-sans-serif, system-ui, sans-serif; background: #0f172a; color: #e2e8f0; }
        * { box-sizing: border-box; }
        body { margin: 0; }
        a { color: inherit; text-decoration: none; }
        button, .button, input, select { border: 0; border-radius: .75rem; padding: .75rem 1rem; font-size: 1rem; }
        button, .button { display: inline-flex; align-items: center; justify-content: center; background: #38bdf8; color: #082f49; font-weight: 800; cursor: pointer; min-height: 44px; }
        .button.secondary, button.secondary { background: #334155; color: #e2e8f0; }
        .button.danger, button.danger { background: #f87171; color: #450a0a; }
        input, select { background: #020617; color: #e2e8f0; border: 1px solid #334155; width: 100%; min-height: 44px; }
        select[multiple] { min-height: 8rem; }
        label { display: grid; gap: .4rem; color: #cbd5e1; font-weight: 700; }
        .layout { max-width: 1180px; margin: 0 auto; padding: 1rem; }
        .nav { display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; justify-content: space-between; }
        .nav > strong { font-size: 1.1rem; }
        .nav > div { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }
        .nav a { padding: .65rem 1rem; background: #1e293b; border-radius: 999px; font-size: 0.9rem; }
        .nav a:hover, .nav a.active { background: #0e7490; }
        .card { background: #111827; border: 1px solid #334155; border-radius: 1.25rem; padding: 1.25rem; box-shadow: 0 20px 60px rgba(0,0,0,.25); }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; }
        .stack { display: grid; gap: 1rem; }
        .row { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
        .table { width: 100%; border-collapse: collapse; }
        html[dir="rtl"] { direction: rtl; text-align: right; }
        html[dir="rtl"] .nav { justify-content: space-between; }
        html[dir="rtl"] .row { direction: rtl; }
        .table th, .table td { padding: .85rem; border-bottom: 1px solid #334155; text-align: left; vertical-align: top; }
        .badge { display: inline-flex; padding: .3rem .65rem; border-radius: 999px; background: #134e4a; color: #99f6e4; font-size: .8rem; font-weight: 800; }
        .notice { border: 1px solid #22c55e; color: #bbf7d0; background: #052e16; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; }
        .errors { border: 1px solid #f87171; color: #fecaca; background: #450a0a; padding: 1rem; border-radius: 1rem; margin-bottom: 1rem; }
        .muted { color: #94a3b8; }
        .team-form { border: 1px dashed #475569; border-radius: 1rem; padding: 1rem; }
        .btn-lang { border-radius: 0.357rem; padding: 0.5rem 0.75rem; font-size: 0.9rem; }
        
        /* Table responsiveness */
        .table-wrapper { overflow-x: auto; margin: -1.25rem; padding: 1.25rem; }
        
        /* Mobile-first responsive adjustments */
        @media (max-width: 768px) {
            .layout { padding: 0.75rem; }
            
            .nav { gap: 0.75rem; margin-bottom: 1.5rem; }
            .nav > strong { font-size: 1rem; }
            .nav > div { gap: 0.25rem; }
            .nav a { padding: 0.5rem 0.75rem; font-size: 0.85rem; }
            
            .card { padding: 1rem; border-radius: 0.75rem; }
            
            .grid { grid-template-columns: 1fr; gap: 0.75rem; }
            
            .table { font-size: 0.9rem; }
            .table th, .table td { padding: 0.6rem; }
            
            h1 { font-size: 1.5rem; margin: 0.5rem 0; }
            h2 { font-size: 1.25rem; margin: 0.4rem 0; }
            h3 { font-size: 1.1rem; margin: 0.3rem 0; }
            
            button, .button, input, select { padding: 0.6rem 0.9rem; font-size: 0.95rem; min-height: 40px; }
            
            .row { gap: 0.5rem; }
            
            label { gap: 0.3rem; font-size: 0.95rem; }
            
            .btn-lang { padding: 0.4rem 0.6rem; font-size: 0.8rem; }
        }
        
        @media (max-width: 480px) {
            .layout { padding: 0.5rem; }
            
            .nav { gap: 0.5rem; margin-bottom: 1rem; flex-direction: column; align-items: stretch; }
            .nav > div { width: 100%; justify-content: flex-start; }
            .nav > strong { font-size: 0.95rem; }
            .nav a { padding: 0.5rem 0.75rem; font-size: 0.8rem; /*flex: 1;*/ text-align: center; }
            
            .card { padding: 0.75rem; }
            
            .grid { gap: 0.5rem; }
            
            .table { font-size: 0.8rem; }
            .table th, .table td { padding: 0.5rem 0.25rem; }
            
            h1 { font-size: 1.3rem; margin: 0.4rem 0; }
            h2 { font-size: 1.1rem; margin: 0.3rem 0; }
            h3 { font-size: 1rem; margin: 0.2rem 0; }
            p { margin: 0.25rem 0; }
            
            button, .button, input, select { padding: 0.65rem 0.8rem; font-size: 0.9rem; min-height: 44px; width: 100%; }
            
            .row { gap: 0.3rem; }
            .row button, .row .button, .row form { width: 100%; }
            
            label { gap: 0.2rem; font-size: 0.9rem; display: grid; }
            label input, label select { width: 100%; }
            
            .btn-lang { padding: 0.35rem 0.55rem; font-size: 0.75rem; }
            
            .badge { padding: 0.25rem 0.5rem; font-size: 0.7rem; }
            
            [style*="display: grid;grid-auto-flow: column"] { grid-auto-flow: row !important; gap: 0.5rem !important; }
            [style*="justify-content: space-between"] { justify-content: flex-start !important; }
        }
        
        /* Tablet adjustments */
        @media (min-width: 769px) and (max-width: 1024px) {
            .layout { padding: 1.25rem; }
            .grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
            .table { font-size: 0.95rem; }
        }
    </style>
</head>
<body>
    <main class="layout">
        <nav class="nav">
            <strong>{{ __('ui.site_name') }}</strong>
            <div>
                <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>{{ __('ui.home') }}</a>
                <a href="{{ route('matches.index') }}" @class(['active' => request()->routeIs('matches.*')])>{{ __('ui.matches') }}</a>
                <a href="{{ route('matches.create') }}">{{ __('ui.create_match') }}</a>
                <a href="{{ route('players.index') }}" @class(['active' => request()->routeIs('players.*')])>{{ __('ui.players') }}</a>
                <!-- <a href="{{ route('leaderboard') }}" @class(['active' => request()->routeIs('leaderboard')])>{{ __('ui.leaderboard') }}</a> -->
            </div>
            <div aria-label="{{ __('Language') }}">
                <a href="{{ route('lang.switch', 'en') }}" class="btn-lang {{ app()->getLocale() === 'en' ? 'active' : '' }}">En</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="btn-lang {{ app()->getLocale() === 'ar' ? 'active' : '' }}">Ar</a>
            </div>
        </nav>

        @if (session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        @if (session('error'))
            <div class="errors">{{ session('error') }}</div>
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

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/service-worker.js')
                    .catch(function (error) {
                        console.warn('Service Worker registration failed:', error);
                    });
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
