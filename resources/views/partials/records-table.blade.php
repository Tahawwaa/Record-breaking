<table class="table">
    <thead>
        <tr><th>Exercise</th><th>Weight</th><th>Reps</th><th>Set</th><th>Date</th><th></th></tr>
    </thead>
    <tbody>
        @forelse ($records as $record)
            <tr @if ($record->is_pr) style="box-shadow: inset 3px 0 0 var(--color-accent), inset 0 0 0 1000px color-mix(in srgb, var(--color-accent) 8%, transparent);" @endif>
                <td class="font-medium">{{ $record->exercise->name }}</td>
                <td>{{ $record->weight_label }} lb</td>
                <td>{{ $record->reps }}</td>
                <td>{{ $record->set_number }}</td>
                <td class="text-muted">{{ $record->date->format('M j, Y') }}</td>
                <td>
                    @if ($record->is_pr)
                        <span class="tag tag-accent gap-1">
                            <svg width="11" height="11" viewBox="0 0 256 256" fill="currentColor"><path d="M80 40h96v40a48 48 0 0 1-96 0V40Z"/><path d="M80 56H48a24 24 0 0 0 24 40"/><path d="M176 56h32a24 24 0 0 1-24 40"/><path d="M108 168h40l8 48H100l8-48Z"/><path d="M128 128v40"/><path d="M96 216h64"/></svg>
                            New PR
                        </span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted">No records logged yet.</td></tr>
        @endforelse
    </tbody>
</table>
