<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    public function index(): View
    {
        return view('exercises.index', [
            'exercises' => Exercise::with('records')->get(),
        ]);
    }
}
