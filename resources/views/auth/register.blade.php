@extends('auth.app')

@section('titre', __('register.register'))

@section('content')
    <section id="login-register" class="vh-100" style="background: url('{{ asset(config('public_path.public_path').'utiles/login.jpg') }}') no-repeat center center/cover;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-8">
                <div class="card rounded-1 shadow-sm">
                    <div class="row g-0">
                    <div class="col-md-6 col-lg-4 d-none d-md-block">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="{{ asset(config('public_path.public_path'). 'utiles/logo.png') }}"
                            alt="login form" class="img-fluid" />
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8 d-flex align-items-center">
                        <div class="card-body p-3 text-black">
                          <form id="register-form">
                            @csrf
                            <div class="d-flex align-items-center mb-3 pb-1">
                              <div class="d-flex justify-content-center align-items-center h-100">
                                <!-- Icon visible sur les écrans plus grands -->
                                <i class="fas fa-sign-in-alt fa-2x me-3 d-none d-md-block" style="color: #af8511;"></i>

                                <!-- Logo visible sur les petits écrans (smartphone) -->
                                <img src="{{ asset(config('public_path.public_path'). 'utiles/logo.png') }}"
                                     alt="login form"
                                     class="img-fluid d-block d-md-none"
                                     style="width:50px;"
                                     />
                            </div>

                              <span class="h1 fw-bold mb-0">{{ __('register.register') }}</span>
                            </div>
                            <div class="form-group mb-2">
                              <label for="pseudo">{{ __('register.pseudo') }} <span cla  ss="text-danger">*</span></label>
                              <input type="text" class="form-control" id="pseudo" name="pseudo" required autofocus>
                              <div class="invalid-feedback">{{ __('register.required_pseudo') }}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group mb-2">
                                  <label for="email">{{ __('register.email') }}<span class="text-danger">*</span></label>
                                  <input type="email" class="form-control" id="email" name="email" required>
                                  <div class="invalid-feedback">{{ __('register.required_email') }}</div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group mb-2">
                                  <label for="contact">{{ __('register.contact') }}<span class="text-danger">*</span></label>
                                  <input type="number" class="form-control" id="contact" name="contact" required>
                                  <div class="invalid-feedback">{{ __('register.required_contact') }}</div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group mb-2">
                              <label for="address">{{ __('register.address') }}<span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="address" name="address" required>
                              <div class="invalid-feedback">{{ __('register.required_address') }}</div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group mb-2">
                                  <label for="password">{{ __('register.password') }}<span class="text-danger">*</span></label>
                                  <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="toggle-password" style="height: 38px;">
                                      <i class="fas fa-eye" id="eye-icon"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="generate-password" style="height: 38px;"> <i class="fas fa-key"></i></button>
                                  </div>
                                  <div class="invalid-feedback">{{ __('register.required_password') }}</div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group mb-2">
                                  <label for="password-confirm">{{ __('register.confirm_password') }}<span class="text-danger">*</span></label>
                                  <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                                  <div class="invalid-feedback">{{ __('register.passwords_not_matching') }}</div>
                                </div>
                              </div>
                            </div>

                            <button type="button" class="btn btn-success mt-2 w-100 text-uppercase" id="register-btn">{{ __('register.register_button') }}</button>

                            <div class="customer-option mt-4 text-center">
                              <span class="text-secondary">{{ __('register.have_account') }}</span>
                              <a href="{{ route('login') }}" class="btn-text text-decoration-none text-warning js-show-register">{{ __('register.login') }}</a>
                            </div>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      // Fonction pour générer un mot de passe fort
      function generateStrongPassword() {
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-+=<>?";
        let password = '';
        for (let i = 0; i < 16; i++) {
          const randomIndex = Math.floor(Math.random() * charset.length);
          password += charset[randomIndex];
        }
        return password;
      }
    $(document).ready(function() {
      // Lorsque l'utilisateur clique sur le bouton pour générer un mot de passe
      $('#generate-password').on('click', function() {
        const password = generateStrongPassword();
        $('#password').val(password); // Remplir le champ mot de passe avec le mot généré
      });

      // Basculer la visibilité du mot de passe
      $('#toggle-password').on('click', function() {
        const passwordField = $('#password');
        const eyeIcon = $('#eye-icon');

        // Vérifie si le mot de passe est actuellement masqué ou non
        if (passwordField.attr('type') === 'password') {
          // Si masqué, afficher le mot de passe
          passwordField.attr('type', 'text');
          eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash'); // Change l'icône de l'œil
        } else {
          // Si visible, masquer le mot de passe
          passwordField.attr('type', 'password');
          eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye'); // Change l'icône de l'œil
        }
      });

      $('#register-btn').on('click', function() {
        var button = $(this);
        var form = $('#register-form');
        var originalContent = button.html();
        var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("register.loading") }}';

        // Change the button content to show the spinner
        button.html(loadingContent);
        button.prop('disabled', true);
        var valid = true;

        // Client-side validation for empty fields
        form.find('.form-control').each(function() {
          var input = $(this);
          if (!input.val()) {
            valid = false;
            input.addClass('is-invalid');
            input.next('.invalid-feedback').show();
          } else {
            input.removeClass('is-invalid');
            input.next('.invalid-feedback').hide();
          }
        });

        if (!valid) {
          button.html(originalContent);
          button.prop('disabled', false);
          return; // Stop submission if client-side validation fails
        }

        // Clear existing errors
        form.find('.invalid-feedback').hide();
        form.find('.form-control').removeClass('is-invalid');

        // Submit form via Ajax
        var formData = form.serialize();

        $.ajax({
          url: "{{ route('register.post') }}",
          method: "POST",
          data: formData,
          headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
          },
          success: function(response) {
            // Réactiver le bouton et remettre le texte original
            button.html(originalContent);
            button.prop('disabled', false);

            if (response.errors) {
              // Display server-side validation errors
              $.each(response.errors, function(field, messages) {
                var input = form.find('[name="' + field + '"]');
                input.addClass('is-invalid');
                input.next('.invalid-feedback').text(messages.join(', ')).show();
              });
            } else if (response.success) {
              window.location.href = "{{ route('admin.dashboard') }}";
              Swal.fire(
                  '{{ __("register.success") }}!',
                  response.message,
                  'success'
              );
              $('#registerForm')[0].reset();
            }
          },
          error: function(xhr) {
            // Réactiver le bouton et remettre le texte original
            button.html(originalContent);
            button.prop('disabled', false);

            if (xhr.status === 422) { // Validation error
              var response = xhr.responseJSON;
              $.each(response.errors, function(field, messages) {
                var input = form.find('[name="' + field + '"]');
                input.addClass('is-invalid');
                input.next('.invalid-feedback').text(messages.join(', ')).show();
              });
            } else {
                Swal.fire(
                    '{{ __("register.error_title") }}',
                    '{{ __("register.unexpected_error") }}',
                    'error'
                );

            }
          }
        });
      });
    });
  </script>
@endpush
