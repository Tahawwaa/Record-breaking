<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen flex flex-col items-center justify-center px-4 py-10" style="gap:24px">

    <div class="flex items-center justify-between w-full" style="max-width:380px">
        <a href="{{ route('login') }}" class="nav-brand whitespace-nowrap" style="margin:0">
            <svg width="32" height="32" viewBox="0 0 500 500" style="flex:none;color:var(--color-accent)">
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
    </div>

    <div class="card elev-sm w-full" style="max-width:380px;padding:28px">
        @yield('content')
    </div>

</body>
</html>
