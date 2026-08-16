<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $records = Record::withPersonalRecords();

        $exercises = Exercise::with('records')->get();

        $selectedExercise = $exercises->firstWhere('name', $request->query('exercise'))
            ?? $exercises->first();

        return view('dashboard', [
            'totalWorkouts' => $records->count(),
            'personalRecordsThisMonth' => $this->personalRecordsThisMonth($records),
            'currentStreak' => $this->currentStreak($records),
            'favoriteExercise' => $this->favoriteExercise($records),
            'recentRecords' => $records->reverse()->values()->take(6),
            'exercises' => $exercises,
            'allExercises' => $exercises,
            'selectedExercise' => $selectedExercise,
            'chartLabels' => $selectedExercise ? $this->chartLabels($selectedExercise) : [],
            'weightChart' => $this->buildSeries($selectedExercise, 'weight'),
            'repsChart' => $this->buildSeries($selectedExercise, 'reps'),
        ]);
    }

    private function personalRecordsThisMonth(Collection $records): int
    {
        return $records
            ->filter(fn (Record $record) => $record->is_pr && $record->date->isSameMonth(now()))
            ->count();
    }

    private function currentStreak(Collection $records): int
    {
        $loggedDates = $records->pluck('date')->map->toDateString()->unique()->sort()->values();

        if ($loggedDates->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $cursor = Carbon::parse($loggedDates->last());

        foreach ($loggedDates->reverse() as $date) {
            if ($cursor->toDateString() !== $date) {
                break;
            }

            $streak++;
            $cursor->subDay();
        }

        return $streak;
    }

    private function favoriteExercise(Collection $records): ?string
    {
        return $records
            ->groupBy('exercise_id')
            ->sortByDesc(fn ($group) => $group->count())
            ->first()?->first()?->exercise?->name;
    }

    private function chartLabels(Exercise $exercise): array
    {
        return $exercise->records->sortBy('date')->values()
            ->map(fn (Record $record) => $record->date->format('M j'))
            ->all();
    }

    private function buildSeries(?Exercise $exercise, string $field): array
    {
        if (! $exercise) {
            return ['points' => [], 'linePoints' => '', 'areaPath' => '', 'hi' => 0, 'mid' => 0, 'lo' => 0];
        }

        $values = $exercise->records->sortBy('date')->values()
            ->map(fn (Record $record) => (float) $record->{$field})
            ->all();

        if (empty($values)) {
            return ['points' => [], 'linePoints' => '', 'areaPath' => '', 'hi' => 0, 'mid' => 0, 'lo' => 0];
        }

        $min = min($values);
        $max = max($values);
        $pad = max(1, (int) round(($max - $min) * 0.3));
        $lo = $min - $pad;
        $hi = $max + $pad;
        $n = count($values);

        $points = [];
        foreach ($values as $i => $value) {
            $points[] = [
                'x' => $n > 1 ? round($i * (100 / ($n - 1)), 1) : 50.0,
                'y' => round(100 - (($value - $lo) / ($hi - $lo)) * 100, 1),
                'value' => rtrim(rtrim(number_format($value, 2), '0'), '.'),
            ];
        }

        $linePoints = implode(' ', array_map(fn ($p) => "{$p['x']},{$p['y']}", $points));

        return [
            'points' => $points,
            'linePoints' => $linePoints,
            'areaPath' => "M0,100 L{$linePoints} L100,100 Z",
            'hi' => $hi,
            'mid' => (int) round(($hi + $lo) / 2),
            'lo' => $lo,
        ];
    }
}
