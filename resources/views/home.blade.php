<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen flex flex-col">

    <nav class="nav border-b border-divider px-4 sm:px-7 h-16">
        <a href="{{ route('dashboard') }}" class="nav-brand whitespace-nowrap">
            <svg width="30" height="30" viewBox="0 0 500 500" style="flex:none;color:var(--color-accent)">
                <g fill="none" stroke="currentColor" stroke-width="26" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="40" y="165" width="90" height="170" rx="44"/>
                    <rect x="130" y="200" width="48" height="100" rx="14"/>
                    <line x1="178" y1="250" x2="322" y2="250"/>
                    <rect x="322" y="200" width="48" height="100" rx="14"/>
                    <rect x="370" y="165" width="90" height="170" rx="44"/>
                </g>
            </svg>
            <span style="font-size:19px;letter-spacing:-0.01em">Record<span style="color:var(--color-accent)">breaking</span></span>
        </a>
        <div class="flex items-center gap-1" style="font-size:13px">
            <a href="{{ route('locale.switch', 'en') }}" style="{{ app()->getLocale() === 'en' ? 'color:var(--color-accent)' : '' }}">EN</a>
            <span class="text-muted">/</span>
            <a href="{{ route('locale.switch', 'fa') }}" style="{{ app()->getLocale() === 'fa' ? 'color:var(--color-accent)' : '' }}">فا</a>
        </div>
        <a href="{{ route('login') }}" class="hidden sm:inline">{{ __('Log in') }}</a>
        <a href="{{ route('register') }}" class="btn btn-primary whitespace-nowrap">{{ __('Sign up') }}</a>
    </nav>

    <main class="flex-1 flex items-center justify-center px-4 py-16">
        <div class="text-center flex flex-col items-center" style="max-width:560px;gap:22px">
            <span class="card-kicker">{{ config('app.name') }}</span>
            <h1 class="font-heading font-semibold" style="font-size:34px;line-height:1.25;letter-spacing:-0.02em">
                {{ __('Track your workouts. Beat your own records.') }}
            </h1>
            <p class="card-body" style="font-size:15px">
                {{ __('Log every set, watch your personal records get flagged automatically, and follow your progress with charts — in English or Persian.') }}
            </p>
            <div class="flex items-center gap-3 mt-2">
                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Sign up') }}</a>
                <a href="{{ route('login') }}" class="btn" style="background:transparent;border:1px solid var(--color-divider);color:var(--color-text)">{{ __('Log in') }}</a>
            </div>
        </div>
    </main>

</body>
</html>
