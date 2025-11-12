@extends('auth.app')

@section('titre', __('waiting.pending'))

@push('styles')
  <style>
        body{
          background-color: hsl(162, 79%, 13%) !important;
        }
  </style>
@endpush

@section('content')
  @include('backoffice.modal.logout')
  <section style="background: url('{{ asset(config('public_path.public_path').'utiles/login.jpg') }}') no-repeat center center/cover;">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-2 shadow-sm">
                    <div class="card-header bg-white text-dark fw-bold">
                        <i class="fas fa-sync text-warning"></i>&nbsp;{{ __('waiting.waiting_approval') }}
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                          <img src="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" class="img-fluid rounded-pill" alt="">
                        </div>
                        <div class="col-md-8 d-flex align-items-center justify-content-center">
                          <p class="text-muted">
                              {{ __('waiting.hello_user', ['name' => Auth::user()->pseudo]) }}<br>
                              {{ __('waiting.pending_message') }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end bg-white">
                      <button class="btn btn-outline-danger rounded-0" id="logout-link">
                          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                          {{ __('waiting.logout') }}
                      </button>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </section>
@endsection
