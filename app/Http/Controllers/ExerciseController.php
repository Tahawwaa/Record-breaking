<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    public function index(): View
    {
        return view('exercises.index', [
            'exercises' => Exercise::where('user_id', Auth::id())->with('records')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['name' => trim((string) $request->input('name'))]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [], [
            'name' => __('Exercise name'),
        ]);

        $exercise = Exercise::findOrCreateByName($validated['name']);

        return redirect()->back()->with('status', __('Added :name to your exercises.', ['name' => $exercise->name]));
    }
}
