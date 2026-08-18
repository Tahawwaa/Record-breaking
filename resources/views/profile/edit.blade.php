@extends('layouts.app')

@section('title', __('Profile') . ' · ' . config('app.name'))

@section('content')

<section class="flex flex-col gap-6" style="max-width:520px">
    <div class="card elev-sm p-5">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="card elev-sm p-5">
        @include('profile.partials.update-password-form')
    </div>

    <div class="card elev-sm p-5">
        @include('profile.partials.delete-user-form')
    </div>
</section>

@endsection
