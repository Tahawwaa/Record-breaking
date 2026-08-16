<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
Route::get('/history', [RecordController::class, 'index'])->name('records.index');
Route::post('/records', [RecordController::class, 'store'])->name('records.store');
