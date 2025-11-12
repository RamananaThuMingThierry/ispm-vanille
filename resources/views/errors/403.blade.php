@extends('admin.admin')

@section('content')
    <img class="img-fluid p-4 img-width" src="{{ asset(config('public_path.public_path').'img/undraw_access_denied_re_awnf.svg') }}">
    <p class="lead">{{ __('error.403') }}</p>
@endsection
