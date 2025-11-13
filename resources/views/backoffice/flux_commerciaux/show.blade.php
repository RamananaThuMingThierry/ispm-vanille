<div class="modal fade" id="fluxShowModal" tabindex="-1" aria-labelledby="fluxShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fluxShowModalLabel">
                    {{ __('sidebar.flux_commerciaux') ?? 'Flux commerciaux' }} - {{ __('form.details') ?? 'Détails' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Type</dt>
                    <dd class="col-sm-9" id="show_type"></dd>

                    <dt class="col-sm-3">Produit</dt>
                    <dd class="col-sm-9" id="show_produit"></dd>

                    <dt class="col-sm-3">{{ __('form.year') ?? 'Année' }}</dt>
                    <dd class="col-sm-9" id="show_annee"></dd>

                    <dt class="col-sm-3">Quantité</dt>
                    <dd class="col-sm-9" id="show_quantite"></dd>

                    <dt class="col-sm-3">{{ __('form.value') ?? 'Valeur (MGA)' }}</dt>
                    <dd class="col-sm-9" id="show_valeur"></dd>
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
