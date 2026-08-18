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
        return view('plans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePlan($request);

        $plan = WorkoutPlan::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

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
     * @return array{name: string, day_of_week: ?string, muscle_group: ?string, description: ?string}
     */
    private function validatePlan(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['nullable', 'string', 'in:'.implode(',', array_keys(WorkoutPlan::dayOptions()))],
            'muscle_group' => ['nullable', 'string', 'in:'.implode(',', array_keys(WorkoutPlan::muscleGroupOptions()))],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'name' => __('Plan name'),
            'day_of_week' => __('Day'),
            'muscle_group' => __('Muscle group'),
            'description' => __('Description (optional)'),
        ]);
    }

    private function authorizePlan(WorkoutPlan $plan): void
    {
        abort_unless($plan->user_id === Auth::id(), 404);
    }
}
