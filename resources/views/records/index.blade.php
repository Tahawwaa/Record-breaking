@extends('layouts.app')

@section('title', 'History · ' . config('app.name'))

@section('content')

<section class="card elev-sm p-5">
    <span class="card-kicker">History</span>
    <div class="card-title mb-2">All records</div>
    @include('partials.records-table', ['records' => $records])
</section>

@endsection
