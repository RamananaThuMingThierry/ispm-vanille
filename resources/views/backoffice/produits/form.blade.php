<div class="modal fade" id="produitModal" tabindex="-1" aria-labelledby="produitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="produitForm">
                @csrf
                <input type="hidden" id="produit_id" name="produit_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="produitModalLabel">Nouveau produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-12">
                        <label for="nom" class="form-label">Nom du produit *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label for="unite" class="form-label">Unité de mesure *</label>
                        <input type="text" name="unite" id="unite" class="form-control" value="kg" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('form.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-produit">
                        {{ __('form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
