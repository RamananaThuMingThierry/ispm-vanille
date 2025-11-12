@extends('errors.app')

@section('titre', 'Page non trouvée')

@section('content')
    <img class="img-fluid mb-4 img-width" src="{{ asset(config('public_path.public_path').'img/undraw_page_not_found_re_e9o6.svg') }}" alt="Page non trouvée">
    <p class="lead">{{ __('error.404') }}</p>
@endsection
