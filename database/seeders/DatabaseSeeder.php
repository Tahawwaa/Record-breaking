<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'phone' => '09120000000',
            'email' => 'test@example.com',
        ]);

        $this->call(DefaultExercisesSeeder::class, parameters: ['user' => $user]);
        $this->call(ExerciseRecordSeeder::class, parameters: ['user' => $user]);
    }
}
