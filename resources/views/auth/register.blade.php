@extends('layouts.guest')

@section('title', __('Sign up') . ' · ' . config('app.name'))

@section('content')

<div class="card-title mb-1">{{ __('Create your account') }}</div>
<p class="card-body mb-5">{{ __('Start tracking your workouts and personal records.') }}</p>

<form method="POST" action="{{ route('register') }}" class="flex flex-col gap-3.5">
    @csrf

    <div class="field">
        <label for="phone">{{ __('Phone number') }}</label>
        <input class="input" type="tel" name="phone" id="phone" value="{{ old('phone') }}" required autofocus autocomplete="tel">
        @error('phone')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="username">{{ __('Username') }}</label>
        <input class="input" type="text" name="username" id="username" value="{{ old('username') }}" required autocomplete="username">
        @error('username')
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
