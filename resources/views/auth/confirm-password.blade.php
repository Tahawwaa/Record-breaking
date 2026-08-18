@extends('layouts.guest')

@section('title', __('Confirm password') . ' · ' . config('app.name'))

@section('content')

<div class="card-title mb-1">{{ __('Confirm password') }}</div>
<p class="card-body mb-5">{{ __('This is a secure area. Please confirm your password before continuing.') }}</p>

<form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-3.5">
    @csrf

    <div class="field">
        <label for="password">{{ __('Password') }}</label>
        <input class="input" type="password" name="password" id="password" required autofocus autocomplete="current-password">
        @error('password')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-1.5">{{ __('Confirm') }}</button>
</form>

@endsection
