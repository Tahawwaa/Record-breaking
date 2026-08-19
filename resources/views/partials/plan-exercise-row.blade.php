@php
    $rowId = 'plan-exercise-' . $index;
    $displayNumber = is_numeric($index) ? $index + 1 : '__NUM__';
@endphp
<div class="plan-exercise-row card elev-sm p-3.5" style="gap:10px">
    <div class="flex items-center justify-between">
        <span class="text-sm font-medium plan-exercise-row-label">{{ __('Exercise') }} {{ $displayNumber }}</span>
        <button type="button" onclick="removePlanExerciseRow(this)" aria-label="{{ __('Remove') }}" style="background:none;border:none;cursor:pointer;color:var(--color-muted);display:flex">
            <svg width="14" height="14" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round"><path d="M64 64l128 128M192 64L64 192"/></svg>
        </button>
    </div>
    <div class="field" style="margin:0">
        @include('partials.exercise-select', [
            'id' => $rowId,
            'name' => "exercises[{$index}][exercise]",
            'options' => $options,
            'selected' => null,
            'freeText' => true,
            'required' => false,
        ])
    </div>
    <div class="grid grid-cols-2 gap-2.5">
        <div class="field" style="margin:0">
            <label for="{{ $rowId }}-sets">{{ __('Target sets') }}</label>
            <input class="input" type="number" min="1" max="20" placeholder="3" id="{{ $rowId }}-sets" name="exercises[{{ $index }}][target_sets]">
        </div>
        <div class="field" style="margin:0">
            <label for="{{ $rowId }}-reps">{{ __('Target reps') }}</label>
            <input class="input" type="number" min="1" max="200" placeholder="10" id="{{ $rowId }}-reps" name="exercises[{{ $index }}][target_reps]">
        </div>
    </div>
</div>
