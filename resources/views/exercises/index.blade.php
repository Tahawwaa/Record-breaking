@extends('layouts.app')

@section('title', __('Exercises') . ' · ' . config('app.name'))

@section('content')

<section>
    <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
        <div>
            <span class="card-kicker block mb-1">{{ __('Exercises') }}</span>
            <div class="card-title">{{ __('All exercises') }}</div>
        </div>
        <button type="button" class="btn btn-primary whitespace-nowrap" onclick="openAddExerciseModal()">
            <svg width="14" height="14" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round"><path d="M128 40v176M40 128h176"/></svg>
            {{ __('Add Exercise') }}
        </button>
    </div>

    <div class="grid gap-4" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
        @forelse ($exercises as $exercise)
            @include('partials.exercise-card', ['exercise' => $exercise])
        @empty
            <p class="card-body">{{ __('No exercises yet.') }}</p>
        @endforelse
    </div>
</section>

<div id="add-exercise-modal" class="{{ $errors->has('name') ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.6)" onclick="if (event.target === this) closeAddExerciseModal()">
    <div class="card elev-sm w-full" style="max-width:360px">
        <div class="card-title mb-1">{{ __('Add Exercise') }}</div>
        <p class="card-body mb-4">{{ __('Give it a name to start tracking it.') }}</p>
        <form method="POST" action="{{ route('exercises.store') }}">
            @csrf
            <div class="field">
                <label for="new-exercise-name">{{ __('Exercise name') }}</label>
                <input class="input" type="text" name="name" id="new-exercise-name" placeholder="{{ __('e.g. Pull-ups') }}" value="{{ old('name') }}" required>
            </div>
            @error('name')
                <p class="text-xs mt-2" style="color:#ff8080">{{ $message }}</p>
            @enderror
            <div class="flex gap-2 justify-end mt-5">
                <button type="button" class="btn" style="background:transparent;border:1px solid var(--color-divider);color:var(--color-text)" onclick="closeAddExerciseModal()">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection
