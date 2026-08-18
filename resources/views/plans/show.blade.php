@extends('layouts.app')

@section('title', $plan->name . ' · ' . config('app.name'))

@php
    $totalSets = $plan->planExercises->sum('target_sets');
@endphp

@section('content')

<section class="grid grid-cols-1 lg:grid-cols-[1.6fr_1fr] gap-4 items-start">

    <div class="flex flex-col gap-4">

        <div class="card elev-sm p-5">
            <div class="flex items-start justify-between gap-3 mb-3">
                <span class="card-kicker">{{ __('Plan') }}</span>
                <form method="POST" action="{{ route('plans.destroy', $plan) }}" onsubmit="return confirm('{{ __('Delete this plan? This cannot be undone.') }}')">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn" style="background:#3a1c1c;color:#ff8080;flex:none" aria-label="{{ __('Delete plan') }}">
                        <svg width="14" height="14" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round" stroke-linejoin="round"><path d="M56 64h144M104 40h48M96 64v128M160 64v128M64 64l8 136a16 16 0 0 0 16 16h80a16 16 0 0 0 16-16l8-136"/></svg>
                    </button>
                </form>
            </div>

            @if ($errors->any() && $errors->hasAny(['name', 'day_of_week', 'muscle_group', 'description']))
                <div class="text-sm mb-3" style="color:#ff6a6a">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('plans.update', $plan) }}" class="flex flex-col gap-3.5">
                @csrf
                @method('patch')
                <div class="field">
                    <label for="plan-name">{{ __('Plan name') }}</label>
                    <input class="input" type="text" name="name" id="plan-name" value="{{ old('name', $plan->name) }}" required>
                </div>
                <div class="grid grid-cols-2 gap-2.5">
                    <div class="field">
                        <label for="plan-day">{{ __('Day') }}</label>
                        <select class="input" name="day_of_week" id="plan-day">
                            <option value="">{{ __('Any day') }}</option>
                            @foreach (\App\Models\WorkoutPlan::dayOptions() as $value => $label)
                                <option value="{{ $value }}" @selected(old('day_of_week', $plan->day_of_week) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="plan-muscle-group">{{ __('Muscle group') }}</label>
                        <select class="input" name="muscle_group" id="plan-muscle-group">
                            <option value="">{{ __('Not set') }}</option>
                            @foreach (\App\Models\WorkoutPlan::muscleGroupOptions() as $value => $label)
                                <option value="{{ $value }}" @selected(old('muscle_group', $plan->muscle_group) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label for="plan-description">{{ __('Description (optional)') }}</label>
                    <textarea class="input" name="description" id="plan-description" rows="2" style="resize:vertical">{{ old('description', $plan->description) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="align-self:flex-start">{{ __('Save changes') }}</button>
            </form>
        </div>

        <div class="card elev-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="card-kicker">{{ __('Exercises') }}</span>
                <span class="card-meta" style="margin:0">
                    {{ trans_choice(':count exercise|:count exercises', $plan->planExercises->count(), ['count' => $plan->planExercises->count()]) }}
                    @if ($totalSets > 0)
                        · {{ trans_choice(':count set|:count sets', $totalSets, ['count' => $totalSets]) }}
                    @endif
                </span>
            </div>

            <div class="flex flex-col gap-2">
                @forelse ($plan->planExercises as $entry)
                    <div class="flex items-center justify-between gap-3" style="padding:10px 0;border-bottom:1px solid var(--color-divider)">
                        <span class="font-medium">{{ $entry->exercise->name }}</span>
                        <div class="flex items-center gap-3" style="flex:none">
                            <span class="text-sm text-muted">{{ $entry->target_sets }} × {{ $entry->target_reps }}</span>
                            <form method="POST" action="{{ route('plans.exercises.destroy', [$plan, $entry]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" aria-label="{{ __('Remove') }}" style="background:none;border:none;cursor:pointer;color:var(--color-muted);display:flex">
                                    <svg width="16" height="16" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round"><path d="M64 64l128 128M192 64L64 192"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="card-body">{{ __('No exercises in this plan yet.') }}</p>
                @endforelse
            </div>
        </div>

    </div>

    <div class="card elev-sm p-5 gap-3.5">
        <span class="card-kicker">{{ __('Add to plan') }}</span>
        <div class="card-title">{{ __('Add exercise') }}</div>

        @if ($errors->any() && $errors->hasAny(['exercise', 'target_sets', 'target_reps']))
            <div class="text-sm" style="color:#ff6a6a">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('plans.exercises.store', $plan) }}" class="flex flex-col gap-3.5">
            @csrf
            <div class="field">
                <label for="plan-exercise">{{ __('Exercise') }}</label>
                @include('partials.exercise-select', ['id' => 'plan-exercise', 'name' => 'exercise', 'options' => $allExercises, 'selected' => old('exercise'), 'freeText' => true])
            </div>
            <div class="grid grid-cols-2 gap-2.5">
                <div class="field"><label for="plan-target-sets">{{ __('Target sets') }}</label><input class="input" id="plan-target-sets" name="target_sets" type="number" min="1" placeholder="3" value="{{ old('target_sets') }}" required></div>
                <div class="field"><label for="plan-target-reps">{{ __('Target reps') }}</label><input class="input" id="plan-target-reps" name="target_reps" type="number" min="1" placeholder="10" value="{{ old('target_reps') }}" required></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">{{ __('Add to plan') }}</button>
        </form>
    </div>

</section>

@endsection
