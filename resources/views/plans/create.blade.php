@extends('layouts.app')

@section('title', __('New plan') . ' · ' . config('app.name'))

@section('content')

<section class="card elev-sm p-5" style="max-width:480px">
    <span class="card-kicker">{{ __('Plans') }}</span>
    <div class="card-title mb-4">{{ __('New plan') }}</div>

    <form method="POST" action="{{ route('plans.store') }}" class="flex flex-col gap-3.5">
        @csrf
        <div class="field">
            <label for="plan-name">{{ __('Plan name') }}</label>
            <input class="input" type="text" name="name" id="plan-name" placeholder="{{ __('e.g. Push Day') }}" value="{{ old('name') }}" required autofocus>
            @error('name')
                <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-2 gap-2.5">
            <div class="field">
                <label for="plan-day">{{ __('Day') }}</label>
                <select class="input" name="day_of_week" id="plan-day">
                    <option value="">{{ __('Any day') }}</option>
                    @foreach (\App\Models\WorkoutPlan::dayOptions() as $value => $label)
                        <option value="{{ $value }}" @selected(old('day_of_week') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="plan-muscle-group">{{ __('Muscle group') }}</label>
                <select class="input" name="muscle_group" id="plan-muscle-group">
                    <option value="">{{ __('Not set') }}</option>
                    @foreach (\App\Models\WorkoutPlan::muscleGroupOptions() as $value => $label)
                        <option value="{{ $value }}" @selected(old('muscle_group') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="field">
            <label for="plan-description">{{ __('Description (optional)') }}</label>
            <textarea class="input" name="description" id="plan-description" rows="3" style="resize:vertical">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">{{ __('Create plan') }}</button>
    </form>
</section>

@endsection
