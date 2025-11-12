<div class="modal fade" id="entrepriseModal" tabindex="-1" aria-labelledby="entrepriseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="entrepriseForm">
                @csrf
                <input type="hidden" id="entreprise_id" name="entreprise_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="entrepriseModalLabel">Nouvelle entreprise exportatrice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label for="nom" class="form-label">{{ __('form.name') }} *</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="pays" class="form-label">Pays</label>
                        <input type="text" name="pays" id="pays" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="adresse" class="form-label">{{ __('form.address') }}</label>
                        <input type="text" name="adresse" id="adresse" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ __('form.email') }}</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="telephone" class="form-label">{{ __('form.phone') }}</label>
                        <input type="text" name="telephone" id="telephone" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="responsable" class="form-label">Responsable</label>
                        <input type="text" name="responsable" id="responsable" class="form-control">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">{{ __('form.description') }}</label>
                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('form.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-entreprise">
                        {{ __('form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
