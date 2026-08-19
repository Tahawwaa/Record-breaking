@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __("We're down for maintenance. Please check back shortly."))
