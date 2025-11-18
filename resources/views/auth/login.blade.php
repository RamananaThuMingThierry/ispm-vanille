@extends('auth.app')

@section('titre', "Connexion")

@section('content')
    <section id="login-register" class="vh-100" style="background: url('{{ asset(config('public_path.public_path').'images/V6.jpg') }}') no-repeat center center/cover;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-6">
                    <div class="card rounded-1">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                    <img style="width:150px;height:150px;" src="{{ asset(config('public_path.public_path').'utiles/logo.png') }}"
                                        alt="login form"
                                        class="img-fluid mb-3" />

                                    <img style="width:150px;height:150px;" src="{{ asset(config('public_path.public_path').'utiles/ccia.jpg') }}"
                                        alt="login form"
                                        class="img-fluid" />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body text-black">

                                    <form id="login-form" method="POST" action="{{ route('login.post') }}" class="needs-validation" novalidate>
                                        @csrf

                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-sign-in-alt fa-2x me-3 d-none d-md-block text-warning"></i>
                                            <img src="{{ asset(config('public_path.public_path').'utiles/logo.png') }}"
                                                alt="login form"
                                                class="img-fluid d-block d-md-none"
                                                style="width:50px;" />
                                            <span class="h2 fw-bold mb-0">{{ __('login.login') }}</span>
                                        </div>

                                        <h5 class="fw-normal pb-1" style="letter-spacing: 1px;">{{ __('login.login_subtitle') }}</h5>

                                        <div class="form-outline mb-2">
                                            <label class="form-label" for="email">{{ __('login.email') }}</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                required autocomplete="off"/>
                                            <div class="invalid-feedback">
                                                @error('email')
                                                    {{ $message }}
                                                @else
                                                    {{ __('login.email_required') }}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label class="form-label mb-1" for="password">{{ __('login.password') }}</label>
                                            <input type="password" id="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                required autocomplete="off"/>
                                            <div class="invalid-feedback">
                                                @error('password')
                                                    {{ $message }}
                                                @else
                                                    {{ __('login.password_required') }}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="my-2">
                                            <button id="login-btn" class="btn text-uppercase btn-sm btn-success w-100" type="submit">
                                                {{ __('login.log_in') }}
                                            </button>
                                        </div>

                                        <p>{{ __('login.do_not_have_an_account') }}
                                            <a href="{{ route('register') }}" class="text-warning text-decoration-none">
                                                {{ __('login.sign_up') }}
                                            </a>
                                        </p>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    @if(session('info'))
        <script>
            $(document).ready(function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: "{{ session('info') }}",
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
    <script>
        $(document).ready(function () {
            $('#login-form').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                var button = $('#login-btn');
                var originalContent = button.html();
                var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("loading.loading") }}';

                // Désactiver le bouton et afficher un spinner
                button.html(loadingContent).prop('disabled', true);

                // Envoyer le formulaire avec AJAX
                $.ajax({
                    url: form.attr('action'),
                    method: "POST",
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        if (response.success) {
                            // Swal.fire({
                            //     title: '{{ __("login.success_connection") }}',
                            //     text: '{{ __("login.redirected_dashboard") }}',
                            //     icon: 'success',
                            // });
                            button.html(originalContent).prop('disabled', false);
                            window.location.href = "{{ route('admin.dashboard') }}";
                        }
                    },
                    error: function (xhr) {
                        button.html(originalContent).prop('disabled', false);

                        if (xhr.status === 422) {
                            var response = xhr.responseJSON;

                            // Afficher les erreurs
                            if (response.errors && response.errors["g-recaptcha-response"]) {
                                $('#recaptcha-error').text(response.errors["g-recaptcha-response"][0]).show();
                            }
                        } else {
                            Swal.fire({
                                title: '{{ __("login.error") }}',
                                text: '{{ __("login.error_text") }}',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
