@extends('layouts.app')

@section('title', __('Exercises') . ' · ' . config('app.name'))

@section('content')

<section>
    <span class="card-kicker block mb-1">{{ __('Exercises') }}</span>
    <div class="card-title mb-4">{{ __('All exercises') }}</div>
    <div class="grid gap-4" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
        @forelse ($exercises as $exercise)
            @include('partials.exercise-card', ['exercise' => $exercise])
        @empty
            <p class="card-body">{{ __('No exercises yet.') }}</p>
        @endforelse
    </div>
</section>

@endsection
