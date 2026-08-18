@extends('layouts.app')

@section('title', __('Settings') . ' · ' . config('app.name'))

@section('content')

<section class="card elev-sm p-5" style="max-width:480px">
    <span class="card-kicker">{{ __('Settings') }}</span>
    <div class="card-title mb-4">{{ __('Preferences') }}</div>

    @if ($errors->any())
        <div class="text-sm mb-3" style="color:#ff6a6a">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('settings.update') }}" class="flex flex-col gap-4">
        @csrf
        @method('patch')

        <div class="field">
            <label for="settings-locale">{{ __('Language') }}</label>
            <select class="input" name="locale" id="settings-locale">
                <option value="en" @selected(old('locale', auth()->user()->locale ?? app()->getLocale()) === 'en')>English</option>
                <option value="fa" @selected(old('locale', auth()->user()->locale ?? app()->getLocale()) === 'fa')>فارسی</option>
            </select>
        </div>

        <div class="field">
            <label for="settings-date-format">{{ __('Calendar') }}</label>
            <select class="input" name="date_format" id="settings-date-format">
                <option value="gregorian" @selected(old('date_format', auth()->user()->date_format) === 'gregorian')>{{ __('Gregorian') }}</option>
                <option value="jalali" @selected(old('date_format', auth()->user()->date_format) === 'jalali')>{{ __('Jalali (Persian)') }}</option>
            </select>
            <p class="card-meta">{{ __('Dates are stored the same either way — this only changes how they’re displayed. The date picker itself stays Gregorian.') }}</p>
        </div>

        <div class="field">
            <label for="settings-weight-unit">{{ __('Weight unit') }}</label>
            <select class="input" name="weight_unit" id="settings-weight-unit">
                <option value="kg" @selected(old('weight_unit', auth()->user()->weight_unit) === 'kg')>{{ __('Kilograms (kg)') }}</option>
                <option value="lb" @selected(old('weight_unit', auth()->user()->weight_unit) === 'lb')>{{ __('Pounds (lb)') }}</option>
            </select>
        </div>

        <div class="field">
            <label>{{ __('Theme') }}</label>
            <div class="flex gap-3 mt-1">
                @foreach ([
                    'default' => '#7c74e8',
                    'emerald' => '#34d399',
                    'sunset' => '#fb923c',
                    'ocean' => '#38bdf8',
                ] as $themeKey => $swatchColor)
                    <label class="theme-swatch-label">
                        <input type="radio" name="theme" value="{{ $themeKey }}" class="theme-swatch-input" @checked(old('theme', auth()->user()->theme) === $themeKey)>
                        <span class="theme-swatch" style="background:{{ $swatchColor }}"></span>
                        <span class="theme-swatch-name">{{ __(ucfirst($themeKey)) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block mt-1.5">{{ __('Save settings') }}</button>
    </form>
</section>

@endsection
