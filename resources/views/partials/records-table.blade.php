@php
    $weightUnit = \App\Support\Preferences::weightUnit();
@endphp
<div class="sm:hidden flex flex-col gap-2">
    @forelse ($records as $record)
        <div class="card elev-sm" style="padding:12px 14px;gap:4px;{{ $record->is_pr ? 'box-shadow: inset 3px 0 0 var(--color-accent), inset 0 0 0 1000px color-mix(in srgb, var(--color-accent) 8%, transparent);' : '' }}">
            <div class="flex items-center justify-between gap-2">
                <span class="font-medium">{{ $record->exercise->name }}</span>
                <bdi class="font-semibold" style="flex:none">{{ $record->weight_label }} {{ $weightUnit }}</bdi>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs text-muted">{{ __('Reps') }} {{ $record->reps }} · {{ __('Set') }} {{ $record->set_number }} · {{ $record->date_label }}</span>
                @if ($record->is_pr)
                    <span class="tag tag-accent gap-1" style="flex:none">
                        <svg width="10" height="10" viewBox="0 0 256 256" fill="currentColor"><path d="M80 40h96v40a48 48 0 0 1-96 0V40Z"/><path d="M80 56H48a24 24 0 0 0 24 40"/><path d="M176 56h32a24 24 0 0 1-24 40"/><path d="M108 168h40l8 48H100l8-48Z"/><path d="M128 128v40"/><path d="M96 216h64"/></svg>
                        {{ __('New PR') }}
                    </span>
                @endif
            </div>
        </div>
    @empty
        <p class="card-body">{{ __('No records logged yet.') }}</p>
    @endforelse
</div>

<div class="hidden sm:block overflow-x-auto">
    <table class="table" style="min-width:560px">
        <thead>
            <tr><th>{{ __('Exercise') }}</th><th>{{ __('Weight') }}</th><th>{{ __('Reps') }}</th><th>{{ __('Set') }}</th><th>{{ __('Date') }}</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($records as $record)
                <tr @if ($record->is_pr) style="box-shadow: inset 3px 0 0 var(--color-accent), inset 0 0 0 1000px color-mix(in srgb, var(--color-accent) 8%, transparent);" @endif>
                    <td class="font-medium">{{ $record->exercise->name }}</td>
                    <td><bdi>{{ $record->weight_label }} {{ $weightUnit }}</bdi></td>
                    <td>{{ $record->reps }}</td>
                    <td>{{ $record->set_number }}</td>
                    <td class="text-muted">{{ $record->date_label }}</td>
                    <td>
                        @if ($record->is_pr)
                            <span class="tag tag-accent gap-1">
                                <svg width="11" height="11" viewBox="0 0 256 256" fill="currentColor"><path d="M80 40h96v40a48 48 0 0 1-96 0V40Z"/><path d="M80 56H48a24 24 0 0 0 24 40"/><path d="M176 56h32a24 24 0 0 1-24 40"/><path d="M108 168h40l8 48H100l8-48Z"/><path d="M128 128v40"/><path d="M96 216h64"/></svg>
                                {{ __('New PR') }}
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">{{ __('No records logged yet.') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
