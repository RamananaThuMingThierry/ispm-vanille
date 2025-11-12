@extends('admin.admin')

@section('content')
    <img class="img-fluid mb-4 img-width" src="{{ asset(config('public_path.public_path').'img/undraw_under_construction.svg') }}">
    <p class="lead">{{ __('error.204') }}</p>
@endsection
