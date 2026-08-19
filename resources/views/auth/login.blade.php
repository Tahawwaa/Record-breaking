@extends('layouts.guest')

@section('title', __('Log in') . ' · ' . config('app.name'))

@section('content')

<div class="card-title mb-1">{{ __('Log in') }}</div>
<p class="card-body mb-5">{{ __('Welcome back — track your next PR.') }}</p>

@if (session('status'))
    <div class="text-sm mb-4" style="color: var(--color-accent)">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}" class="flex flex-col gap-3.5">
    @csrf

    <div class="field">
        <label for="username">{{ __('Username') }}</label>
        <input class="input" type="text" name="username" id="username" value="{{ old('username') }}" required autofocus autocomplete="username">
        @error('username')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="password">{{ __('Password') }}</label>
        <input class="input" type="password" name="password" id="password" required autocomplete="current-password">
        @error('password')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center" style="font-size:13px">
        <label class="flex items-center gap-2" style="color:var(--color-muted)">
            <input type="checkbox" name="remember" @checked(old('remember', true))>
            {{ __('Remember me') }}
        </label>
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-1.5">{{ __('Log in') }}</button>
</form>

<p class="text-sm mt-5" style="color:var(--color-muted)">
    {{ __("Don't have an account?") }}
    <a href="{{ route('register') }}">{{ __('Sign up') }}</a>
</p>

@endsection
