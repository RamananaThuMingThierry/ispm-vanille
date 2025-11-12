<div class="modal fade" id="ContactUs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ContactUsLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title text-success text-center" id="ContactUsLabel">{{ __('contact.title') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <p class="text-center">{{ __('contact.description') }}</p>
          </div>
          <div class="row">
            <div class="col-lg-4 text-center text-lg-start">
              <img src="{{ asset(config('public_path.public_path').'img/undraw_contact_us_re_4qqt.svg') }}" alt="Contact illustration" class="img-fluid">
            </div>
            <div class="col-lg-8 d-flex flex-column align-items-center align-items-lg-start mt-4 mt-lg-0">
              <a href="tel:+261380913703" class="text-decoration-none text-muted">
                <i class="fas fa-phone text-danger"></i>&nbsp;+261 38 09 137 03
              </a>
              <a class="text-muted" href="https://www.facebook.com/search/top/?q=Cardo Ricky" target="_blank">
                <i class="fab fa-facebook text-primary"></i>&nbsp;Cardo Ricky
              </a>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">
            <i class="fas fa-sign-out-alt"></i>&nbsp;{{ __('contact.close') }}
          </button>
        </div>
      </div>
    </div>
  </div>
