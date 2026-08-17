<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseRecordSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daysAgo = [27, 20, 13, 6, 3, 1];

        $series = [
            'Bench Press' => [
                'weight' => [70, 73, 75, 77, 79, 84],
                'reps' => [8, 8, 6, 6, 5, 5],
            ],
            'Squat' => [
                'weight' => [102, 107, 111, 116, 120, 125],
                'reps' => [6, 6, 5, 5, 5, 5],
            ],
            'Deadlift' => [
                'weight' => [125, 129, 134, 138, 136, 143],
                'reps' => [5, 5, 4, 4, 3, 3],
            ],
            'Overhead Press' => [
                'weight' => [43, 45, 48, 50, 51, 52],
                'reps' => [8, 8, 7, 7, 6, 6],
            ],
        ];

        foreach ($series as $name => $data) {
            $exercise = Exercise::firstOrCreate(['name' => $name]);

            foreach ($daysAgo as $i => $offset) {
                $exercise->records()->create([
                    'weight' => $data['weight'][$i],
                    'reps' => $data['reps'][$i],
                    'set_number' => 1,
                    'date' => now()->subDays($offset)->toDateString(),
                ]);
            }
        }
    }
}
