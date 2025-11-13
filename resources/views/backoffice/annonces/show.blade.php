= <div class="modal fade" id="annonceShowModal" tabindex="-1" aria-labelledby="annonceShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="annonceShowModalLabel">
                    {{ __('sidebar.annonces') ?? 'Annonces' }} - {{ __('form.details') ?? 'Détails' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Catégorie</dt>
                    <dd class="col-sm-9" id="show_categorie"></dd>

                    <dt class="col-sm-3">Produit</dt>
                    <dd class="col-sm-9" id="show_produit"></dd>

                    <dt class="col-sm-3">Quantité</dt>
                    <dd class="col-sm-9" id="show_quantite"></dd>

                    <dt class="col-sm-3">{{ __('form.price') }}</dt>
                    <dd class="col-sm-9" id="show_prix"></dd>

                    <dt class="col-sm-3">Localisation</dt>
                    <dd class="col-sm-9" id="show_localisation"></dd>

                    <dt class="col-sm-3">{{ __('form.phone') }}</dt>
                    <dd class="col-sm-9" id="show_contact"></dd>
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
