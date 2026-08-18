<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('settings.edit');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => ['required', 'in:en,fa'],
            'date_format' => ['required', 'in:gregorian,jalali'],
            'weight_unit' => ['required', 'in:kg,lb'],
            'theme' => ['required', 'in:default,emerald,sunset,ocean'],
        ]);

        $request->user()->update($validated);

        // Apply immediately, without waiting for the next request.
        session(['locale' => $validated['locale']]);
        app()->setLocale($validated['locale']);

        return redirect()->route('settings.edit')->with('status', __('Settings saved.'));
    }
}
