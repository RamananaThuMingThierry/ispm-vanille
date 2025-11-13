<div class="modal fade" id="produitShowModal" tabindex="-1" aria-labelledby="produitShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="produitShowModalLabel">
                    {{ __('sidebar.produits') }} - {{ __('form.details') ?? 'Détails' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nom</dt>
                    <dd class="col-sm-8" id="show_nom"></dd>

                    <dt class="col-sm-4">Unité</dt>
                    <dd class="col-sm-8" id="show_unite"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('form.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
