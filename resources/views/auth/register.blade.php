@extends('layouts.guest')

@section('title', __('Sign up') . ' · ' . config('app.name'))

@section('content')

<div class="card-title mb-1">{{ __('Create your account') }}</div>
<p class="card-body mb-5">{{ __('Start tracking your workouts and personal records.') }}</p>

<form method="POST" action="{{ route('register') }}" class="flex flex-col gap-3.5">
    @csrf

    <div class="field">
        <label for="name">{{ __('Name') }}</label>
        <input class="input" type="text" name="name" id="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="email">{{ __('Email') }}</label>
        <input class="input" type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="username">
        @error('email')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="password">{{ __('Password') }}</label>
        <input class="input" type="password" name="password" id="password" required autocomplete="new-password">
        @error('password')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="password_confirmation">{{ __('Confirm password') }}</label>
        <input class="input" type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
        @error('password_confirmation')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-1.5">{{ __('Sign up') }}</button>
</form>

<p class="text-sm mt-5" style="color:var(--color-muted)">
    {{ __('Already have an account?') }}
    <a href="{{ route('login') }}">{{ __('Log in') }}</a>
</p>

@endsection
