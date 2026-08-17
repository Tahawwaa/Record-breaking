@extends('layouts.app')

@section('title', __('History') . ' · ' . config('app.name'))

@section('content')

<section class="card elev-sm p-5">
    <span class="card-kicker">{{ __('History') }}</span>
    <div class="card-title mb-2">{{ __('All records') }}</div>
    @include('partials.records-table', ['records' => $records])
</section>

@endsection
