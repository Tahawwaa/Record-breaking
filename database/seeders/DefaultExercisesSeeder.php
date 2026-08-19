<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultExercisesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * The starter library every user gets so they don't begin with an empty
     * list. Categories here are curated by us; anything a user adds
     * afterward gets categorized by the user instead (see the "Add Exercise"
     * form), never hardcoded like this.
     */
    private const DEFAULT_EXERCISES = [
        'Bench Press' => ['strength', 'compound', 'powerlifting'],
        'Squat' => ['strength', 'compound', 'powerlifting'],
        'Deadlift' => ['strength', 'compound', 'powerlifting'],
        'Overhead Press' => ['strength', 'compound'],
        'Pull-Up' => ['bodyweight', 'compound'],
        'Push-Up' => ['bodyweight', 'compound'],
        'Plank' => ['bodyweight', 'balance'],
        'Bicep Curl' => ['strength', 'isolation'],
        'Standing Hamstring Stretch' => ['stretching'],
        'Jump Rope' => ['cardio', 'plyometric'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(User $user): void
    {
        foreach (self::DEFAULT_EXERCISES as $name => $categories) {
            // Case-insensitive lookup (mirrors Exercise::findOrCreateByName) so a user who
            // already logged "deadlift" lowercase doesn't end up with a near-duplicate "Deadlift".
            $exercise = Exercise::where('user_id', $user->id)
                ->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])
                ->first()
                ?? Exercise::create(['user_id' => $user->id, 'name' => $name]);

            if (empty($exercise->categories)) {
                $exercise->update(['categories' => $categories]);
            }
        }
    }
}
