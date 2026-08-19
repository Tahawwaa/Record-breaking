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
            <label>{{ __('Muscle groups') }}</label>
            <div class="flex flex-wrap gap-x-3 gap-y-1.5">
                @foreach (\App\Models\WorkoutPlan::muscleGroupOptions() as $value => $label)
                    <label class="flex items-center gap-1.5" style="font-size:13px;color:var(--color-muted)">
                        <input type="checkbox" name="muscle_groups[]" value="{{ $value }}" @checked(in_array($value, old('muscle_groups', [])))>
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>
        <div class="field">
            <label for="plan-description">{{ __('Description (optional)') }}</label>
            <textarea class="input" name="description" id="plan-description" rows="3" style="resize:vertical">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-xs mt-1" style="color:#ff8080">{{ $message }}</p>
            @enderror
        </div>

        <div class="field" style="margin:0">
            <label>{{ __('Exercises (optional)') }}</label>
            <p class="text-sm text-muted mb-2">{{ __('Pick from your existing exercises, or type a new name — you can also add more later.') }}</p>
        </div>

        <div id="plan-exercises-list" class="flex flex-col gap-3">
            @include('partials.plan-exercise-row', ['index' => 0, 'options' => $allExercises])
        </div>

        <template id="plan-exercise-row-template">
            @include('partials.plan-exercise-row', ['index' => '__IDX__', 'options' => $allExercises])
        </template>

        <button type="button" class="btn" style="align-self:flex-start" onclick="addPlanExerciseRow()">
            {{ __('Add another exercise') }}
        </button>

        <button type="submit" class="btn btn-primary btn-block">{{ __('Create plan') }}</button>
    </form>
</section>

<script>
    var planExerciseRowIndex = 1;

    function addPlanExerciseRow() {
        var template = document.getElementById('plan-exercise-row-template');
        var html = template.innerHTML
            .split('__IDX__').join(planExerciseRowIndex)
            .split('__NUM__').join(planExerciseRowIndex + 1);
        var wrapper = document.createElement('div');
        wrapper.innerHTML = html.trim();
        document.getElementById('plan-exercises-list').appendChild(wrapper.firstElementChild);
        planExerciseRowIndex++;
    }

    function removePlanExerciseRow(button) {
        var list = document.getElementById('plan-exercises-list');
        if (list.children.length <= 1) {
            button.closest('.plan-exercise-row').remove();
            addPlanExerciseRow();
            return;
        }
        button.closest('.plan-exercise-row').remove();
    }
</script>

@endsection
