@extends('layouts.app')

@section('title', __('Plans') . ' · ' . config('app.name'))

@section('content')

<section>
    <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
        <div>
            <span class="card-kicker block mb-1">{{ __('Plans') }}</span>
            <div class="card-title">{{ __('Your workout plans') }}</div>
        </div>
        <a href="{{ route('plans.create') }}" class="btn btn-primary whitespace-nowrap">
            <svg width="14" height="14" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round"><path d="M128 40v176M40 128h176"/></svg>
            {{ __('New plan') }}
        </a>
    </div>

    <div class="grid gap-4" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr))">
        @forelse ($plans as $plan)
            @include('partials.plan-card', ['plan' => $plan])
        @empty
            <p class="card-body">{{ __("No workout plans yet — create one to plan your next session.") }}</p>
        @endforelse
    </div>
</section>

@endsection
