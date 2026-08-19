<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanExercise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WorkoutPlanController extends Controller
{
    public function index(): View
    {
        return view('plans.index', [
            'plans' => WorkoutPlan::where('user_id', Auth::id())
                ->withCount('planExercises')
                ->with('planExercises.exercise')
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('plans.create', [
            'allExercises' => Exercise::where('user_id', Auth::id())->orderBy('name')->pluck('name'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePlan($request);

        $request->validate([
            'exercises.*.exercise' => ['nullable', 'string', 'max:255'],
            'exercises.*.target_sets' => ['nullable', 'integer', 'min:1', 'max:20'],
            'exercises.*.target_reps' => ['nullable', 'integer', 'min:1', 'max:200'],
        ]);

        $plan = WorkoutPlan::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        $this->syncExercisesFromRequest($request, $plan);

        return redirect()->route('plans.show', $plan)->with('status', __('Workout plan created.'));
    }

    public function show(WorkoutPlan $plan): View
    {
        $this->authorizePlan($plan);

        return view('plans.show', [
            'plan' => $plan->load('planExercises.exercise'),
            'allExercises' => Exercise::where('user_id', Auth::id())->orderBy('name')->pluck('name'),
        ]);
    }

    public function update(Request $request, WorkoutPlan $plan): RedirectResponse
    {
        $this->authorizePlan($plan);

        $plan->update($this->validatePlan($request));

        return redirect()->route('plans.show', $plan)->with('status', __('Workout plan updated.'));
    }

    public function destroy(WorkoutPlan $plan): RedirectResponse
    {
        $this->authorizePlan($plan);

        $plan->delete();

        return redirect()->route('plans.index')->with('status', __('Workout plan deleted.'));
    }

    public function addExercise(Request $request, WorkoutPlan $plan): RedirectResponse
    {
        $this->authorizePlan($plan);

        $request->merge(['exercise' => trim((string) $request->input('exercise'))]);

        $validated = $request->validate([
            'exercise' => ['required', 'string', 'max:255'],
            'target_sets' => ['required', 'integer', 'min:1', 'max:20'],
            'target_reps' => ['required', 'integer', 'min:1', 'max:200'],
        ]);

        $exercise = Exercise::findOrCreateByName($validated['exercise']);

        WorkoutPlanExercise::updateOrCreate(
            ['workout_plan_id' => $plan->id, 'exercise_id' => $exercise->id],
            [
                'target_sets' => $validated['target_sets'],
                'target_reps' => $validated['target_reps'],
                'position' => $plan->planExercises()->count(),
            ]
        );

        return redirect()->route('plans.show', $plan)
            ->with('status', __('Added :name to the plan.', ['name' => $exercise->name]));
    }

    public function removeExercise(WorkoutPlan $plan, WorkoutPlanExercise $planExercise): RedirectResponse
    {
        $this->authorizePlan($plan);
        abort_unless($planExercise->workout_plan_id === $plan->id, 404);

        $planExercise->delete();

        return redirect()->route('plans.show', $plan)->with('status', __('Removed from the plan.'));
    }

    /**
     * @return array{name: string, day_of_week: ?string, muscle_groups: ?array<int, string>, description: ?string}
     */
    private function validatePlan(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['nullable', 'string', 'in:'.implode(',', array_keys(WorkoutPlan::dayOptions()))],
            'muscle_groups' => ['nullable', 'array'],
            'muscle_groups.*' => ['string', 'in:'.implode(',', array_keys(WorkoutPlan::muscleGroupOptions()))],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'name' => __('Plan name'),
            'day_of_week' => __('Day'),
            'muscle_groups' => __('Muscle group'),
            'description' => __('Description (optional)'),
        ]);
    }

    private function authorizePlan(WorkoutPlan $plan): void
    {
        abort_unless($plan->user_id === Auth::id(), 404);
    }

    /**
     * Attaches the exercise rows submitted alongside a plan (from the "Exercises" section
     * on the create form). Rows with a blank exercise name are ignored, and blank
     * sets/reps fall back to sensible defaults so a name-only row still works.
     */
    private function syncExercisesFromRequest(Request $request, WorkoutPlan $plan): void
    {
        $rows = collect($request->input('exercises', []))
            ->map(fn ($row) => trim((string) ($row['exercise'] ?? '')) === '' ? null : [
                'exercise' => trim((string) $row['exercise']),
                'target_sets' => (int) ($row['target_sets'] ?: 3),
                'target_reps' => (int) ($row['target_reps'] ?: 10),
            ])
            ->filter()
            ->values();

        foreach ($rows as $position => $row) {
            $exercise = Exercise::findOrCreateByName($row['exercise']);

            WorkoutPlanExercise::updateOrCreate(
                ['workout_plan_id' => $plan->id, 'exercise_id' => $exercise->id],
                [
                    'target_sets' => max(1, min(20, $row['target_sets'])),
                    'target_reps' => max(1, min(200, $row['target_reps'])),
                    'position' => $position,
                ]
            );
        }
    }
}
