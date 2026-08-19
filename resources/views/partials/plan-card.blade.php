@php
    $totalSets = $plan->planExercises->sum('target_sets');
    $exerciseNames = $plan->planExercises->pluck('exercise.name')->filter();
    $preview = $exerciseNames->take(3)->implode('، ');
    if ($exerciseNames->count() > 3) {
        $preview .= ' ' . __('+:count more', ['count' => $exerciseNames->count() - 3]);
    }
@endphp
<a href="{{ route('plans.show', $plan) }}" class="card elev-sm" style="text-decoration:none;color:inherit">
    <div class="flex items-center justify-between gap-2">
        <div class="card-title" style="font-size:16px">{{ $plan->name }}</div>
    </div>

    @if ($plan->day_label || $plan->muscle_group_labels)
        <div class="flex flex-wrap gap-1.5 mt-1.5">
            @if ($plan->day_label)
                <span class="tag" style="background:var(--color-accent-soft);color:var(--color-accent)">{{ $plan->day_label }}</span>
            @endif
            @foreach ($plan->muscle_group_labels as $label)
                <span class="tag" style="background:var(--color-divider);color:var(--color-muted)">{{ $label }}</span>
            @endforeach
        </div>
    @endif

    @if ($preview)
        <p class="card-body mt-1.5" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $preview }}</p>
    @elseif ($plan->description)
        <p class="card-body mt-1.5" style="overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $plan->description }}</p>
    @endif

    <div class="card-meta">
        {{ trans_choice(':count exercise|:count exercises', $plan->plan_exercises_count, ['count' => $plan->plan_exercises_count]) }}
        @if ($totalSets > 0)
            · {{ trans_choice(':count set|:count sets', $totalSets, ['count' => $totalSets]) }}
        @endif
    </div>
</a>
