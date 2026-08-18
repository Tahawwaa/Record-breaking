@extends('layouts.guest')

@section('title', __('Forgot password') . ' · ' . config('app.name'))

@section('content')

<div class="card-title mb-1">{{ __('Forgot your password?') }}</div>
<p class="card-body mb-5">{{ __("No problem. Tell us your email and we'll send you a password reset link.") }}</p>

@if (session('status'))
    <div class="text-sm mb-4" style="color: var(--color-accent)">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-3.5">
    @csrf

    <div class="field">
        <label for="email">{{ __('Email') }}</label>
        <input class="input" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-1.5">{{ __('Email password reset link') }}</button>
</form>

<p class="text-sm mt-5" style="color:var(--color-muted)">
    <a href="{{ route('login') }}">{{ __('Back to log in') }}</a>
</p>

@endsection
