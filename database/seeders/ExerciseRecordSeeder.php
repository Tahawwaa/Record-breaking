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
                'weight' => [155, 160, 165, 170, 175, 185],
                'reps' => [8, 8, 6, 6, 5, 5],
            ],
            'Squat' => [
                'weight' => [225, 235, 245, 255, 265, 275],
                'reps' => [6, 6, 5, 5, 5, 5],
            ],
            'Deadlift' => [
                'weight' => [275, 285, 295, 305, 300, 315],
                'reps' => [5, 5, 4, 4, 3, 3],
            ],
            'Overhead Press' => [
                'weight' => [95, 100, 105, 110, 112, 115],
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
