@extends('backoffice.admin')

@section('titre', __('default.my_profile'))

@push('styles')
    <style>
        .break-word {
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
        }
    </style>
@endpush

@section('content')
    @include('backoffice.profile.update')
    @include('backoffice.profile.edit_password')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm rounded-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>{{ __('default.my_profile') }}</h5>
                        <a href="{{ route('admin.dashboard') }}" class="text-danger text-decoration-none"><i class="fas fa-chevron-left"></i>&nbsp;{{ __('default.back') }}</a>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="{{ Auth::user()->avatar ? asset(config('public_path.public_path').'images/users/' . Auth::user()->avatar) : asset(config('public_path.public_path').'images/avatars/default.png') }}"
                                class="rounded-circle shadow"
                                width="120"
                                height="120"
                                alt="Avatar utilisateur">
                        </div>
                        <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editInfoModal">
                                <i class="fas fa-edit me-1"></i> {{ __('default.edit_info') }}
                            </button>

                            <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPasswordModal">
                                <i class="fas fa-key me-1"></i> {{ __('default.change_password') }}
                            </button>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ __('default.pseudo') }}</th>
                                <td class="break-word">{{ Auth::user()->pseudo }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('default.email') }}</th>
                                <td class="break-word">{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('default.contact') }}</th>
                                <td class="break-word">{{ Auth::user()->contact ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('default.address') }}</th>
                                <td class="break-word">{{ Auth::user()->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('default.role') }}</th>
                                <td>
                                    <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'info' : 'secondary' }}">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('default.status') }}</th>
                                <td>
                                    <span class="badge bg-{{ Auth::user()->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ Auth::user()->status === 'active' ? __('default.active') : __('default.inactive') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('default.registered_since') }}</th>
                                <td class="break-word">{{ Auth::user()->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
