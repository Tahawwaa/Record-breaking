<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $category = is_string($category) && array_key_exists($category, Exercise::categoryOptions()) ? $category : null;

        $exercises = Exercise::where('user_id', Auth::id())
            ->with('records')
            ->when($category, fn ($query) => $query->whereJsonContains('categories', $category))
            ->orderBy('name')
            ->paginate(24)
            ->withQueryString();

        return view('exercises.index', [
            'exercises' => $exercises,
            'selectedCategory' => $category,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['name' => trim((string) $request->input('name'))]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['string', 'in:'.implode(',', array_keys(Exercise::categoryOptions()))],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [], [
            'name' => __('Exercise name'),
        ]);

        $exercise = Exercise::findOrCreateByName($validated['name']);

        if (! empty($validated['categories'])) {
            $exercise->categories = $validated['categories'];
        }

        if ($request->hasFile('image')) {
            $exercise->image_path = $request->file('image')->store('exercise-images', 'public');
        }

        $exercise->save();

        return redirect()->back()->with('status', __('Added :name to your exercises.', ['name' => $exercise->name]));
    }
}
