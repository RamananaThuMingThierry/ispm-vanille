<div class="modal fade" id="entrepriseImportatriceShowModal" tabindex="-1" aria-labelledby="entrepriseImportatriceShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="entrepriseImportatriceShowModalLabel">
                    {{ __('sidebar.entreprise_importatrice') }} - {{ __('form.details') ?? 'Détails' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">{{ __('form.name') }}</dt>
                    <dd class="col-sm-9" id="show_nom"></dd>

                    <dt class="col-sm-3">Pays</dt>
                    <dd class="col-sm-9" id="show_pays"></dd>

                    <dt class="col-sm-3">{{ __('form.address') }}</dt>
                    <dd class="col-sm-9" id="show_adresse"></dd>

                    <dt class="col-sm-3">{{ __('form.email') }}</dt>
                    <dd class="col-sm-9" id="show_email"></dd>

                    <dt class="col-sm-3">{{ __('form.phone') }}</dt>
                    <dd class="col-sm-9" id="show_telephone"></dd>

                    <dt class="col-sm-3">Responsable</dt>
                    <dd class="col-sm-9" id="show_responsable"></dd>

                    <dt class="col-sm-3">{{ __('form.description') }}</dt>
                    <dd class="col-sm-9" id="show_description"></dd>
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
