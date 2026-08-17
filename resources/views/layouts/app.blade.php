<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen">

    <nav class="nav border-b border-divider sticky top-0 bg-bg z-10 px-4 sm:px-7 h-auto min-h-16 py-3 flex-wrap gap-x-4 gap-y-2 sm:gap-7">
        <a href="{{ route('dashboard') }}" class="nav-brand whitespace-nowrap">Record-breaking</a>
        <a href="{{ route('dashboard') }}" @if (request()->routeIs('dashboard')) aria-current="page" @endif>{{ __('Dashboard') }}</a>
        <a href="{{ route('exercises.index') }}" @if (request()->routeIs('exercises.*')) aria-current="page" @endif>{{ __('Exercises') }}</a>
        <a href="{{ route('records.index') }}" @if (request()->routeIs('records.*')) aria-current="page" @endif>{{ __('History') }}</a>
        <div class="flex items-center gap-1" style="font-size:13px">
            <a href="{{ route('locale.switch', 'en') }}" style="{{ app()->getLocale() === 'en' ? 'color:var(--color-accent)' : '' }}">EN</a>
            <span class="text-muted">/</span>
            <a href="{{ route('locale.switch', 'fa') }}" style="{{ app()->getLocale() === 'fa' ? 'color:var(--color-accent)' : '' }}">فا</a>
        </div>
        <button type="button" class="btn btn-primary whitespace-nowrap" onclick="openAddExerciseModal()">
            <svg width="14" height="14" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="20" stroke-linecap="round"><path d="M128 40v176M40 128h176"/></svg>
            {{ __('Add Exercise') }}
        </button>
    </nav>

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

    <div class="max-w-[1360px] mx-auto px-7 pt-8 pb-16 flex flex-col gap-10">

        @if (session('status'))
            <div class="card elev-sm" style="border-color: var(--color-accent-2)">
                <p class="card-body" style="color: var(--color-text)">{{ session('status') }}</p>
            </div>
        @endif

        @yield('content')

    </div>

    <script>
        function openAddExerciseModal() {
            document.getElementById('add-exercise-modal').classList.remove('hidden');
            document.getElementById('new-exercise-name').focus();
        }

        function closeAddExerciseModal() {
            document.getElementById('add-exercise-modal').classList.add('hidden');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeAddExerciseModal();
        });

        function toggleDropdown(id, forceOpen) {
            var panel = document.getElementById(id + '-panel');
            var isOpen = !panel.classList.contains('hidden');
            document.querySelectorAll('.dropdown-panel').forEach(function (p) {
                p.classList.add('hidden');
            });
            if (forceOpen || !isOpen) panel.classList.remove('hidden');
        }

        function selectDropdownOption(id, optionEl) {
            var value = optionEl.dataset.value;
            var field = document.getElementById(id);
            field.value = value;

            var label = document.getElementById(id + '-label');
            if (label) label.textContent = value;

            document.getElementById(id + '-panel').classList.add('hidden');

            if (field.dataset.autosubmit === 'true') {
                field.closest('form').submit();
            }
        }

        document.addEventListener('click', function (e) {
            document.querySelectorAll('.dropdown-panel').forEach(function (panel) {
                var wrapper = panel.closest('.custom-dropdown');
                if (wrapper && !wrapper.contains(e.target)) panel.classList.add('hidden');
            });
        });

        @php
            $weekdayLabels = app()->getLocale() === 'fa'
                ? ['یک', 'دو', 'سه', 'چهار', 'پنج', 'جمعه', 'شنبه']
                : ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        @endphp
        var WEEKDAY_LABELS = @json($weekdayLabels);

        function updateWeekdayLabel(input) {
            var label = document.getElementById(input.id + '-weekday');
            if (!label) return;
            if (!input.value) {
                label.textContent = '';
                return;
            }
            var parts = input.value.split('-').map(Number);
            var date = new Date(Date.UTC(parts[0], parts[1] - 1, parts[2]));
            label.textContent = WEEKDAY_LABELS[date.getUTCDay()];
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="date"]').forEach(updateWeekdayLabel);
        });
    </script>

</body>
</html>
