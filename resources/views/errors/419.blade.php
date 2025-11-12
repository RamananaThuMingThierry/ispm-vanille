@extends('errors.app')

@section('titre', 'Page expirée')

@section('content')
    <img class="img-fluid p-4 img-width" src="{{ asset(config('public_path.public_path').'img/undraw_cancel_re_pkdm.svg') }}">
    <p class="lead">{{ __('error.419') }}</p>
@endsection
