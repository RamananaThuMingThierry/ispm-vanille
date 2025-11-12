<div class="modal fade" id="marcheShowModal" tabindex="-1" aria-labelledby="marcheShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="marcheShowModalLabel">
                    {{ __('sidebar.marches') }} - {{ __('form.details') ?? 'Détails' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">{{ __('form.date') }}</dt>
                    <dd class="col-sm-9" id="show_date"></dd>

                    <dt class="col-sm-3">Produit</dt>
                    <dd class="col-sm-9" id="show_produit"></dd>

                    <dt class="col-sm-3">{{ __('form.price') }}</dt>
                    <dd class="col-sm-9" id="show_prix"></dd>

                    <dt class="col-sm-3">Disponibilité</dt>
                    <dd class="col-sm-9" id="show_disponibilite"></dd>
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
