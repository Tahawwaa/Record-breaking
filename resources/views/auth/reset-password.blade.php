@extends('layouts.guest')

@section('title', __('Reset password') . ' · ' . config('app.name'))

@section('content')

<div class="card-title mb-1">{{ __('Reset your password') }}</div>
<p class="card-body mb-5">{{ __('Choose a new password for your account.') }}</p>

<form method="POST" action="{{ route('password.store') }}" class="flex flex-col gap-3.5">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="field">
        <label for="email">{{ __('Email') }}</label>
        <input class="input" type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
        @error('email')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label for="password">{{ __('New password') }}</label>
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

    <button type="submit" class="btn btn-primary btn-block mt-1.5">{{ __('Reset password') }}</button>
</form>

@endsection
