@php
    $autosubmitAttr = ($autosubmit ?? false) ? 'true' : 'false';
    $freeText = $freeText ?? false;
@endphp
<div class="custom-dropdown relative" style="{{ $style ?? '' }}">
    @if ($freeText)
        <input type="text" class="input" name="{{ $name }}" id="{{ $id }}" value="{{ $selected }}" placeholder="{{ __('Select or type an exercise') }}" autocomplete="off" required onfocus="toggleDropdown('{{ $id }}', true)">
    @else
        <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $selected }}" data-autosubmit="{{ $autosubmitAttr }}">
        <button type="button" class="input flex items-center justify-between gap-2" style="cursor:pointer;text-align:start" onclick="toggleDropdown('{{ $id }}')">
            <span id="{{ $id }}-label">{{ $selected ?: __('Select exercise') }}</span>
            <svg width="12" height="12" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" style="flex:none;opacity:.6"><path d="M64 96l64 64 64-64"/></svg>
        </button>
    @endif
    <div id="{{ $id }}-panel" class="dropdown-panel hidden absolute z-20 card elev-sm" style="top:calc(100% + 6px);left:0;right:0;padding:6px">
        @forelse ($options as $option)
            <div class="dropdown-option" data-value="{{ $option }}" onclick="selectDropdownOption('{{ $id }}', this)">{{ $option }}</div>
        @empty
            <div class="text-muted" style="padding:8px 10px;font-size:13px">{{ $freeText ? __('No exercises yet — type a name to add one') : __('No exercises yet') }}</div>
        @endforelse
    </div>
</div>
