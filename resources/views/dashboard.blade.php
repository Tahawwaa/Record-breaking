@extends('layouts.app')

@section('title', __('Dashboard') . ' · ' . config('app.name'))

@php
    $weightUnit = \App\Support\Preferences::weightUnit();
@endphp

@section('content')

<section>
    <span class="card-kicker block mb-3">{{ __('Overview') }}</span>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="card elev-sm gap-2.5">
            <div class="flex items-center justify-between">
                <span class="card-kicker">{{ __('Total Workouts Logged') }}</span>
                <svg width="16" height="16" viewBox="0 0 256 256" fill="none" stroke="var(--color-accent)" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"><rect x="40" y="56" width="176" height="152" rx="12"/><path d="M40 96h176M84 40v32M172 40v32"/><path d="M88 140l24 24 56-56"/></svg>
            </div>
            <div class="text-4xl font-semibold leading-none" style="font-family: var(--font-heading)">{{ $totalWorkouts }}</div>
        </div>

        <div class="card elev-sm gap-2.5">
            <div class="flex items-center justify-between">
                <span class="card-kicker">{{ __('Personal Records This Month') }}</span>
                <svg width="16" height="16" viewBox="0 0 256 256" fill="none" stroke="var(--color-accent)" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"><path d="M80 40h96v40a48 48 0 0 1-96 0V40Z"/><path d="M80 56H48a24 24 0 0 0 24 40"/><path d="M176 56h32a24 24 0 0 1-24 40"/><path d="M108 168h40l8 48H100l8-48Z"/><path d="M128 128v40"/><path d="M96 216h64"/></svg>
            </div>
            <div class="text-4xl font-semibold leading-none" style="font-family: var(--font-heading)">{{ $personalRecordsThisMonth }}</div>
        </div>

        <div class="card elev-sm gap-2.5">
            <div class="flex items-center justify-between">
                <span class="card-kicker">{{ __('Current Streak') }}</span>
                <svg width="16" height="16" viewBox="0 0 256 256" fill="var(--color-accent)"><path d="M128 24c0 40-56 56-56 112a56 56 0 0 0 112 0c0-24-16-32-16-56 0 24-24 24-24 48a16 16 0 0 1-32 0c0-48 16-64 16-104Z"/></svg>
            </div>
            <div class="text-4xl font-semibold leading-none" style="font-family: var(--font-heading)">
                {{ $currentStreak }} <span class="text-base font-normal opacity-60">{{ __('days') }}</span>
            </div>
        </div>

        <div class="card elev-sm gap-2.5">
            <div class="flex items-center justify-between">
                <span class="card-kicker">{{ __('Favorite Exercise') }}</span>
                <svg width="16" height="16" viewBox="0 0 256 256" fill="none" stroke="var(--color-accent)" stroke-width="16" stroke-linecap="round"><line x1="46" y1="128" x2="210" y2="128"/><rect x="30" y="96" width="16" height="64" rx="4" fill="var(--color-accent)" stroke="none"/><rect x="10" y="80" width="16" height="96" rx="4" fill="var(--color-accent)" stroke="none"/><rect x="210" y="96" width="16" height="64" rx="4" fill="var(--color-accent)" stroke="none"/><rect x="230" y="80" width="16" height="96" rx="4" fill="var(--color-accent)" stroke="none"/></svg>
            </div>
            <div class="text-2xl font-semibold leading-snug" style="font-family: var(--font-heading)">{{ $favoriteExercise ?? '—' }}</div>
        </div>

    </div>
</section>

<section class="grid grid-cols-1 lg:grid-cols-[1.6fr_1fr] gap-4 items-start">

    <div class="card elev-sm p-5">
        <span class="card-kicker">{{ __('Recent activity') }}</span>
        <div class="card-title mb-2">{{ __('Recent records') }}</div>
        @include('partials.records-table', ['records' => $recentRecords])
    </div>

    <div id="quick-add" class="card elev-sm p-5 gap-3.5 scroll-mt-24">
        <span class="card-kicker">{{ __('Log a set') }}</span>
        <div class="card-title">{{ __('Quick add') }}</div>

        @if ($errors->any())
            <div class="text-sm" style="color:#ff6a6a">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('records.store') }}" class="flex flex-col gap-3.5">
            @csrf
            <div class="field">
                <label for="qa-exercise">{{ __('Exercise') }}</label>
                @include('partials.exercise-select', ['id' => 'qa-exercise', 'name' => 'exercise', 'options' => $allExercises->pluck('name'), 'selected' => old('exercise', $selectedExercise?->name), 'freeText' => true])
            </div>
            <div class="grid grid-cols-3 gap-2.5">
                <div class="field"><label for="qa-weight">{{ __('Weight (:unit)', ['unit' => $weightUnit]) }}</label><input class="input" id="qa-weight" name="weight" type="number" step="0.5" min="0" placeholder="{{ $weightUnit === 'lb' ? '175' : '80' }}" value="{{ old('weight') }}" required></div>
                <div class="field"><label for="qa-reps">{{ __('Reps') }}</label><input class="input" id="qa-reps" name="reps" type="number" min="1" placeholder="5" value="{{ old('reps') }}" required></div>
                <div class="field"><label for="qa-set">{{ __('Set') }}</label><input class="input" id="qa-set" name="set_number" type="number" min="1" placeholder="1" value="{{ old('set_number', 1) }}" required></div>
            </div>
            <div class="field">
                <label for="qa-date">{{ __('Date') }}</label>
                <div class="flex items-center gap-2">
                    <input class="input" id="qa-date" name="date" type="date" value="{{ old('date', now()->toDateString()) }}" required oninput="updateWeekdayLabel(this)">
                    <span id="qa-date-weekday" class="text-xs whitespace-nowrap" style="color:var(--color-muted);min-width:40px"></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">{{ __('Save record') }}</button>
        </form>
    </div>

</section>

<section class="card elev-sm p-5 gap-3.5">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <span class="card-kicker">{{ __('Progress') }}</span>
            <div class="card-title">{{ __('Weight & reps progression') }}</div>
        </div>
        <form method="GET" action="{{ route('dashboard') }}">
            @include('partials.exercise-select', ['id' => 'chart-exercise', 'name' => 'exercise', 'options' => $allExercises->pluck('name'), 'selected' => $selectedExercise?->name, 'autosubmit' => true, 'style' => 'width:auto;min-width:180px'])
        </form>
    </div>

    @if ($selectedExercise && count($chartLabels) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @include('partials.chart', ['title' => __('Weight (:unit)', ['unit' => $weightUnit]), 'chart' => $weightChart, 'labels' => $chartLabels, 'color' => 'var(--color-accent)', 'areaColor' => 'var(--color-accent-soft)'])
            @include('partials.chart', ['title' => __('Reps'), 'chart' => $repsChart, 'labels' => $chartLabels, 'color' => 'var(--color-accent-2)', 'areaColor' => 'var(--color-accent-2-soft)'])
        </div>
    @else
        <p class="card-body">{{ __('Log a few sets to see progression charts here.') }}</p>
    @endif
</section>

<section>
    <div class="flex items-center justify-between mb-3.5">
        <span class="card-kicker">{{ __('Your workout plans') }}</span>
        <a href="{{ route('plans.index') }}" style="font-size:13px">{{ __('View all') }}</a>
    </div>
    <div class="grid gap-4" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
        @forelse ($plans as $plan)
            @include('partials.plan-card', ['plan' => $plan])
        @empty
            <a href="{{ route('plans.create') }}" class="card elev-sm" style="text-decoration:none;color:inherit;align-items:center;justify-content:center;text-align:center;gap:6px;min-height:104px">
                <svg width="20" height="20" viewBox="0 0 256 256" fill="none" stroke="var(--color-accent)" stroke-width="20" stroke-linecap="round"><path d="M128 40v176M40 128h176"/></svg>
                <span class="text-sm" style="color:var(--color-muted)">{{ __('Create your first workout plan') }}</span>
            </a>
        @endforelse
    </div>
</section>

<section>
    <div class="flex items-center justify-between mb-3.5">
        <span class="card-kicker">{{ __('Your exercises') }}</span>
    </div>
    <div class="grid gap-4" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
        @forelse ($exercises as $exercise)
            @include('partials.exercise-card', ['exercise' => $exercise])
        @empty
            <p class="card-body">{{ __('No exercises yet.') }}</p>
        @endforelse
    </div>
</section>

@endsection
