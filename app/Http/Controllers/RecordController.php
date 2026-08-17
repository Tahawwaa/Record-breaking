<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Record;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecordController extends Controller
{
    public function index(): View
    {
        return view('records.index', [
            'records' => Record::withPersonalRecords()->reverse()->values(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['exercise' => trim((string) $request->input('exercise'))]);

        $validated = $request->validate([
            'exercise' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'reps' => ['required', 'integer', 'min:1'],
            'set_number' => ['required', 'integer', 'min:1'],
            'date' => ['required', 'date'],
        ]);

        $exercise = Exercise::findOrCreateByName($validated['exercise']);

        $exercise->records()->create([
            'weight' => $validated['weight'],
            'reps' => $validated['reps'],
            'set_number' => $validated['set_number'],
            'date' => $validated['date'],
        ]);

        return redirect()
            ->route('dashboard', ['exercise' => $exercise->name])
            ->with('status', __('Logged :weight kg x :reps for :name.', [
                'weight' => $validated['weight'],
                'reps' => $validated['reps'],
                'name' => $exercise->name,
            ]));
    }
}
