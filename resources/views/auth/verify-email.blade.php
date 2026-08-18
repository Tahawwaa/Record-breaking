@extends('layouts.guest')

@section('title', __('Verify email') . ' · ' . config('app.name'))

@section('content')

<div class="card-title mb-1">{{ __('Verify your email') }}</div>
<p class="card-body mb-5">{{ __("Before getting started, click the link we emailed you. Didn't get it? We can send another.") }}</p>

@if (session('status') == 'verification-link-sent')
    <div class="text-sm mb-4" style="color: var(--color-accent)">{{ __('A new verification link has been sent to your email address.') }}</div>
@endif

<div class="flex items-center justify-between gap-3">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">{{ __('Resend verification email') }}</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm" style="color:var(--color-muted);background:none;border:none;cursor:pointer">{{ __('Log out') }}</button>
    </form>
</div>

@endsection
