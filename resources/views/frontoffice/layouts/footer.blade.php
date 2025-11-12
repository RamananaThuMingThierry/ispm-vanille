<footer id="mainFooter" class="bg-dark text-light pt-5 pb-3">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- Contact -->
            <div class="col-md-4 mb-4 text-center">
                <h5 class="text-uppercase fw-bold text-danger">{{ __('frontend.contact') }}</h5>
                <p>
                    <i class="fas fa-phone-alt me-2"></i>
                    <a href="tel:+261380913703" class="text-decoration-none text-light">+261 38 09 137 03</a>
                  </p>

                  <p>
                    <i class="fas fa-envelope me-2"></i>
                    <a href="mailto:contact@world-of-madagascar-tour.com" class="text-decoration-none text-light">contact@world-of-madagascar-tour.com</a>
                  </p>

            </div>

            <!-- Location -->
            <div class="col-md-4 mb-4 text-center">
                <h5 class="text-uppercase fw-bold text-danger">{{ __('frontend.location') }}</h5>
                <p><i class="fas fa-map-marker-alt me-2"></i> Antananarivo, Madagascar</p>
                <p>Ambavahaditokona, Antananarivo</p>
            </div>

            <!-- Social Media -->
            <div class="col-md-4 mb-4 text-center">
                <h5 class="text-uppercase fw-bold text-danger">{{ __('frontend.contect') }}</h5>
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://www.facebook.com/profile.php?id=100084179285857" class="fs-5" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Facebook" target="_blank">
                        <img src="{{ asset(config('public_path.public_path').'images/footer/facebook.png') }}" alt="Facebook" style="width:30px; height:auto;">
                    </a>
                    <a href="https://www.instagram.com/world_of_madagascar?igsh=MTRuNXR4bm9sNThkag==" class="fs-5" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="Instagram" target="_blank">
                        <img src="{{ asset(config('public_path.public_path').'images/footer/instagram.png') }}" alt="Instagram" style="width:30px; height:auto;">
                    </a>
                    <a href="https://youtube.com/@worldofmadagascartour?si=VZM6apbjNptx57aV" class="fs-5" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="YouTube" target="_blank">
                        <img src="{{ asset(config('public_path.public_path').'images/footer/youtube.png') }}" alt="YouTube" style="width:30px; height:auto;">
                    </a>
                    <a href="https://wa.me/261380913703" class="fs-5" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="WhatsApp" target="_blank">
                        <img src="{{ asset(config('public_path.public_path').'images/footer/whatsapp.png') }}" alt="WhatsApp" style="width:30px; height:auto;">
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center border-top pt-3 mt-3" style="font-size: 14px;">
            &copy; {{ now()->year }} {{ __('default.footer_text') }}
        </div>

        <button id="scrollToTopBtn" class="btn btn-danger shadow rounded-circle">
            <i class="fas fa-arrow-up"></i>
        </button>

    </div>
</footer>
