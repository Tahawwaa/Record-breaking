<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" data-theme="{{ \Illuminate\Support\Facades\Auth::user()->theme ?? 'default' }}">
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

    <nav class="nav border-b border-divider sticky top-0 bg-bg z-10 px-4 sm:px-7 h-16">
        <a href="{{ route('dashboard') }}" class="nav-brand whitespace-nowrap">
            <svg width="36" height="36" viewBox="0 0 500 500" style="flex:none;color:var(--color-accent)">
                <g fill="none" stroke="currentColor" stroke-width="26" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="40" y="165" width="90" height="170" rx="44"/>
                    <rect x="130" y="200" width="48" height="100" rx="14"/>
                    <line x1="178" y1="250" x2="322" y2="250"/>
                    <rect x="322" y="200" width="48" height="100" rx="14"/>
                    <rect x="370" y="165" width="90" height="170" rx="44"/>
                </g>
            </svg>
            <span style="font-size:19px;letter-spacing:-0.01em">Record<span style="color:var(--color-accent)">breaking</span></span>
        </a>
        <a href="{{ route('dashboard') }}" class="hidden sm:inline" @if (request()->routeIs('dashboard')) aria-current="page" @endif>{{ __('Dashboard') }}</a>
        <a href="{{ route('exercises.index') }}" class="hidden sm:inline" @if (request()->routeIs('exercises.*')) aria-current="page" @endif>{{ __('Exercises') }}</a>
        <a href="{{ route('records.index') }}" class="hidden sm:inline" @if (request()->routeIs('records.*')) aria-current="page" @endif>{{ __('History') }}</a>
        <a href="{{ route('plans.index') }}" class="hidden sm:inline" @if (request()->routeIs('plans.*')) aria-current="page" @endif>{{ __('Plans') }}</a>

        <div class="flex items-center gap-1" style="font-size:13px">
            <a href="{{ route('locale.switch', 'en') }}" style="{{ app()->getLocale() === 'en' ? 'color:var(--color-accent)' : '' }}">EN</a>
            <span class="text-muted">/</span>
            <a href="{{ route('locale.switch', 'fa') }}" style="{{ app()->getLocale() === 'fa' ? 'color:var(--color-accent)' : '' }}">فا</a>
        </div>

        @if (\Illuminate\Support\Facades\Auth::user()->is_admin)
            <a href="{{ url('/admin') }}" class="flex items-center" aria-label="{{ __('Admin panel') }}" title="{{ __('Admin panel') }}" style="color:#f59e0b">
                <svg width="18" height="18" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"><path d="M128 24l88 32v64c0 66-37.6 110-88 112-50.4-2-88-46-88-112V56z"/><path d="M96 132l24 24 40-48"/></svg>
            </a>
        @endif

        <a href="{{ route('settings.edit') }}" class="flex items-center" aria-label="{{ __('Settings') }}" @if (request()->routeIs('settings.*')) aria-current="page" @endif>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/><circle cx="12" cy="12" r="3"/></svg>
        </a>

        <a href="{{ route('profile.edit') }}" class="flex items-center" aria-label="{{ __('Profile') }}" @if (request()->routeIs('profile.*')) aria-current="page" @endif>
            <svg width="18" height="18" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"><circle cx="128" cy="96" r="48"/><path d="M40 216c14-40 50-64 88-64s74 24 88 64"/></svg>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="flex items-center">
            @csrf
            <button type="submit" aria-label="{{ __('Log out') }}" style="background:none;border:none;cursor:pointer;color:var(--color-muted);display:flex;align-items:center">
                <svg width="18" height="18" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"><path d="M96 216H56a16 16 0 0 1-16-16V56a16 16 0 0 1 16-16h40"/><path d="M176 176l48-48-48-48"/><path d="M224 128H104"/></svg>
            </button>
        </form>
    </nav>

    <nav class="bottom-tabs sm:hidden">
        <a href="{{ route('dashboard') }}" class="bottom-tab" @if (request()->routeIs('dashboard')) aria-current="page" @endif>
            <svg width="20" height="20" viewBox="0 0 256 256" fill="currentColor"><rect x="32" y="32" width="88" height="88" rx="14"/><rect x="136" y="32" width="88" height="88" rx="14"/><rect x="32" y="136" width="88" height="88" rx="14"/><rect x="136" y="136" width="88" height="88" rx="14"/></svg>
            <span>{{ __('Dashboard') }}</span>
        </a>
        <a href="{{ route('exercises.index') }}" class="bottom-tab" @if (request()->routeIs('exercises.*')) aria-current="page" @endif>
            <svg width="20" height="20" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round"><line x1="46" y1="128" x2="210" y2="128"/><rect x="30" y="96" width="16" height="64" rx="4" fill="currentColor" stroke="none"/><rect x="10" y="80" width="16" height="96" rx="4" fill="currentColor" stroke="none"/><rect x="210" y="96" width="16" height="64" rx="4" fill="currentColor" stroke="none"/><rect x="230" y="80" width="16" height="96" rx="4" fill="currentColor" stroke="none"/></svg>
            <span>{{ __('Exercises') }}</span>
        </a>
        <a href="{{ route('records.index') }}" class="bottom-tab" @if (request()->routeIs('records.*')) aria-current="page" @endif>
            <svg width="20" height="20" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"><circle cx="128" cy="128" r="96"/><path d="M128 72v56l40 40"/></svg>
            <span>{{ __('History') }}</span>
        </a>
        <a href="{{ route('plans.index') }}" class="bottom-tab" @if (request()->routeIs('plans.*')) aria-current="page" @endif>
            <svg width="20" height="20" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="16" stroke-linecap="round" stroke-linejoin="round"><rect x="40" y="32" width="176" height="192" rx="12"/><path d="M84 76h88M84 124h88M84 172h48"/></svg>
            <span>{{ __('Plans') }}</span>
        </a>
    </nav>

    <div class="max-w-[1360px] mx-auto px-4 sm:px-7 pt-8 pb-24 sm:pb-16 flex flex-col gap-10">

        @if (session('status') && ! in_array(session('status'), ['profile-updated', 'password-updated']))
            <div class="card elev-sm" style="border-color: var(--color-accent-2)">
                <p class="card-body" style="color: var(--color-text)">{{ session('status') }}</p>
            </div>
        @endif

        @yield('content')

    </div>

    <script>
        function openAddExerciseModal() {
            var modal = document.getElementById('add-exercise-modal');
            if (!modal) return;
            modal.classList.remove('hidden');
            document.getElementById('new-exercise-name').focus();
        }

        function closeAddExerciseModal() {
            var modal = document.getElementById('add-exercise-modal');
            if (modal) modal.classList.add('hidden');
        }

        function openDeleteAccountModal() {
            var modal = document.getElementById('delete-account-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeDeleteAccountModal() {
            var modal = document.getElementById('delete-account-modal');
            if (modal) modal.classList.add('hidden');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAddExerciseModal();
                closeDeleteAccountModal();
            }
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

        function closeDropdownDelayed(id) {
            // Delayed so a click on a dropdown-option (which blurs the input first) still registers.
            setTimeout(function () {
                var panel = document.getElementById(id + '-panel');
                if (panel) panel.classList.add('hidden');
            }, 150);
        }

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
