@php
    $best = $exercise->bestRecord();
@endphp
<div class="card elev-sm">
    <div class="flex items-center gap-2.5">
        <div class="flex items-center justify-center flex-none" style="width:34px;height:34px;border-radius:10px;background:var(--color-accent-soft)">
            <svg width="17" height="17" viewBox="0 0 256 256" fill="none" stroke="var(--color-accent)" stroke-width="16" stroke-linecap="round"><line x1="46" y1="128" x2="210" y2="128"/><rect x="30" y="96" width="16" height="64" rx="4" fill="var(--color-accent)" stroke="none"/><rect x="10" y="80" width="16" height="96" rx="4" fill="var(--color-accent)" stroke="none"/><rect x="210" y="96" width="16" height="64" rx="4" fill="var(--color-accent)" stroke="none"/><rect x="230" y="80" width="16" height="96" rx="4" fill="var(--color-accent)" stroke="none"/></svg>
        </div>
        <div class="card-title" style="font-size:16px">{{ $exercise->name }}</div>
    </div>
    <p class="card-body mt-1.5">
        @if ($best)
            Current best: <span style="color:var(--color-text);font-weight:500">{{ $best->weight_label }} lb &times; {{ $best->reps }}</span>
        @else
            No records yet
        @endif
    </p>
    <div class="card-meta">{{ $exercise->monthlyTrendLabel() }}</div>
</div>
