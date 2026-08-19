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

// Public for guests (shows a landing page); authenticated visitors get their
// dashboard instead. Every other route below stays behind 'auth', so any
// action a guest tries still bounces them to the login page as usual.
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
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

// A real, matched route (unlike a bare unmatched URL) so 404s still go through
// the 'web' middleware group — otherwise the error page loses session state
// entirely: no locale preference, and `Auth::check()` reads as a guest even
// when signed in.
Route::fallback(fn () => abort(404));
