@extends('auth.app')

@section('titre', 'Mot de passe oublier')

@push('styles')
    <style>
      @media (max-width: 767.98px) {
          .img-responsive {
              width: 25%;
              margin-bottom: 20px;
          }
      }
    </style>
@endpush 

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center align-items-center vh-100">
        <div class="col-lg-6 col-md-10 col-sm-10 col-offset-lg-3 col-offset-md-1 col-offset-sm-1">
          <form id="ForgetPasswordForm" method="post">
            @csrf
            @method('POST')
            <div class="card p-2 rounded-0 shadow-sm">
              <div class="card-header bg-white text-secondary"><i class="fas fa-key"></i>&nbsp;Mot de passe oublier</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4 col-md-5 d-flex justify-content-center align-items-center">
                    <img src="{{ asset(config('public_path.public_path').'images/logo.jpg') }}" class="img-fluid rounded-pill img-responsive" alt="">
                  </div>
                  <div class="col-lg-8 col-md-7">
                    <p>Nous comprenons, ça arrive. Entrez simplement votre adresse e-mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe !</p>
                    @include('widget.input', [
                      'column' => 'col-12',
                      'nom'    => 'email',
                      'type'   => 'email',
                      'placeholder'  => 'Entrer votre adresse email',
                      'error'  =>  'EmailUserError'
                    ])
                    <div class="row mt-3">
                      <p class="text-center">J'ai déjà un compte! <a href="{{ route('login') }}" class="text-info text-decoration-none">Se connecter</a></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-outline-primary rounded-0" id="btn-send" type="submit">
                    <i class="fas fa-envelope fa-sm fa-fw mr-2 text-primary"></i>
                    Envoyer
                </button>
              </div>
          </div>
          </form>
        </div>
    </div>
  </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ForgetPasswordForm').on('submit', function(e) {
                e.preventDefault();
                var button = $('#btn-send');
                var originalContent = button.html();
                var loadingContent = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> patientez...';

                // Change the button content to show the spinner
                button.html(loadingContent);
                button.prop('disabled', true);
                
                $.ajax({
                    url: "{{ route('password.email') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                    if(response.success){
                        Swal.fire(
                        'Réuissi!',
                        response.message,
                        'success'
                        );
                    }else{
                        Swal.fire(
                        'Avertissement',
                        response.message,
                        'error'
                        );
                    }
                    $('#EmailUserError').html('');
                    $('#ForgetPasswordForm')[0].reset();
                    button.html(originalContent);
                    button.prop('disabled', false);
                    },
                    error: function(error) {
                    if (error) {
                        $('#EmailUserError').html(error.responseJSON.errors.email);
                    }
                    button.html(originalContent);
                    button.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
