@extends('errors::minimal')

@section('title', __('Request Error'))
@section('code', $exception->getStatusCode())
@section('message', __($exception->getMessage() ?: 'Something about that request was invalid.'))
