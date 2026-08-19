<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" data-theme="{{ \Illuminate\Support\Facades\Auth::user()->theme ?? 'default' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') — @yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen flex flex-col items-center justify-center px-4 py-10" style="gap:24px">

    <div class="flex items-center justify-between w-full" style="max-width:420px">
        <a href="{{ Illuminate\Support\Facades\Auth::check() ? route('dashboard') : route('login') }}" class="nav-brand" style="font-size:19px;margin:0">
            <svg width="30" height="30" viewBox="0 0 500 500" style="flex:none;color:var(--color-accent)">
                <g fill="none" stroke="currentColor" stroke-width="26" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="40" y="165" width="90" height="170" rx="44"/>
                    <rect x="130" y="200" width="48" height="100" rx="14"/>
                    <line x1="178" y1="250" x2="322" y2="250"/>
                    <rect x="322" y="200" width="48" height="100" rx="14"/>
                    <rect x="370" y="165" width="90" height="170" rx="44"/>
                </g>
            </svg>
            <span style="letter-spacing:-0.01em">Record<span style="color:var(--color-accent)">breaking</span></span>
        </a>
        <div class="flex items-center gap-1" style="font-size:13px">
            <a href="{{ route('locale.switch', 'en') }}" style="{{ app()->getLocale() === 'en' ? 'color:var(--color-accent)' : '' }}">EN</a>
            <span class="text-muted">/</span>
            <a href="{{ route('locale.switch', 'fa') }}" style="{{ app()->getLocale() === 'fa' ? 'color:var(--color-accent)' : '' }}">فا</a>
        </div>
    </div>

    <div class="card elev-sm w-full text-center" style="max-width:420px;padding:40px 28px;gap:14px">
        <div style="font-family:var(--font-heading);font-weight:600;font-size:56px;line-height:1;color:var(--color-accent);letter-spacing:-0.02em">
            @yield('code')
        </div>
        <div class="card-title" style="font-size:19px">@yield('title')</div>
        <p class="card-body">@yield('message')</p>

        <a href="{{ Illuminate\Support\Facades\Auth::check() ? route('dashboard') : route('login') }}" class="btn btn-primary" style="align-self:center;margin-top:10px">
            {{ Illuminate\Support\Facades\Auth::check() ? __('Back to dashboard') : __('Back to log in') }}
        </a>
    </div>

</body>
</html>
