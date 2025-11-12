<div class="modal fade" id="actualiteShowModal" tabindex="-1" aria-labelledby="actualiteShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualiteShowModalLabel">
                    {{ __('sidebar.actualites') }} - {{ __('form.details') ?? 'Détails' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
            </div>
            <div class="modal-body">
                <h4 id="show_titre" class="mb-3"></h4>

                <p>
                    <strong>À la une :</strong>
                    <span id="show_ala_une"></span>
                </p>

                <div class="mb-3">
                    <strong>{{ __('form.image') }} :</strong><br>
                    <img id="show_image" src="" alt="Image" style="width: 300px; height: 300px;" class="img-thumbnail">
                </div>

                <hr>

                <div id="show_contenu" style="white-space: pre-line;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('form.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
