@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', $exception->getStatusCode())
@section('message', __('Something went wrong on our end. Please try again in a moment.'))
