<div class="modal fade" id="actualiteModal" tabindex="-1" aria-labelledby="actualiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="actualiteForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="actualite_id" name="actualite_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="actualiteModalLabel">Nouvelle actualité</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-12">
                        <label for="titre" class="form-label">{{ __('form.name') }} *</label>
                        <input type="text" name="titre" id="titre" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label for="contenu" class="form-label">{{ __('form.description') }}</label>
                        <textarea name="contenu" id="contenu" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">{{ __('form.image') }}</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <small class="text-muted">JPEG, PNG, GIF, WEBP &lt;= 2 Mo</small>
                    </div>

                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" value="1" id="ala_une" name="ala_une">
                            <label class="form-check-label" for="ala_une">
                                À la une
                            </label>
                        </div>
                    </div>

                    <div class="col-12" id="image-preview-container" style="display:none;">
                        <label class="form-label">Image actuelle :</label><br>
                        <img id="image-preview" src="" alt="Aperçu" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('form.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-actualite">
                        {{ __('form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
