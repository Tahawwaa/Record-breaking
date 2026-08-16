<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen">

    <nav class="nav border-b border-divider sticky top-0 bg-bg z-10 px-7">
        <a href="{{ route('dashboard') }}" class="nav-brand">Record-breaking</a>
        <a href="{{ route('dashboard') }}" @if (request()->routeIs('dashboard')) aria-current="page" @endif>Dashboard</a>
        <a href="{{ route('exercises.index') }}" @if (request()->routeIs('exercises.*')) aria-current="page" @endif>Exercises</a>
        <a href="{{ route('records.index') }}" @if (request()->routeIs('records.*')) aria-current="page" @endif>History</a>
        <a href="{{ route('dashboard') }}#quick-add" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round"><path d="M128 40v176M40 128h176"/></svg>
            Add Record
        </a>
    </nav>

    <div class="max-w-[1360px] mx-auto px-7 pt-8 pb-16 flex flex-col gap-10">

        @if (session('status'))
            <div class="card elev-sm" style="border-color: var(--color-accent-2)">
                <p class="card-body" style="color: var(--color-text)">{{ session('status') }}</p>
            </div>
        @endif

        @yield('content')

    </div>

</body>
</html>
