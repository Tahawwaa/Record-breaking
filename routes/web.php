<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WorkoutPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'fa'], true), 404);

    session(['locale' => $locale]);

    return redirect()->back();
})->name('locale.switch');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercises.store');
    Route::get('/history', [RecordController::class, 'index'])->name('records.index');
    Route::post('/records', [RecordController::class, 'store'])->name('records.store');

    Route::get('/plans', [WorkoutPlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [WorkoutPlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [WorkoutPlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}', [WorkoutPlanController::class, 'show'])->name('plans.show');
    Route::patch('/plans/{plan}', [WorkoutPlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [WorkoutPlanController::class, 'destroy'])->name('plans.destroy');
    Route::post('/plans/{plan}/exercises', [WorkoutPlanController::class, 'addExercise'])->name('plans.exercises.store');
    Route::delete('/plans/{plan}/exercises/{planExercise}', [WorkoutPlanController::class, 'removeExercise'])->name('plans.exercises.destroy');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
