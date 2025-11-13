<div class="modal fade" id="annonceModal" tabindex="-1" aria-labelledby="annonceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="annonceForm">
                @csrf
                <input type="hidden" id="annonce_id" name="annonce_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="annonceModalLabel">Nouvelle annonce</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label for="categorie" class="form-label">Catégorie *</label>
                        <select name="categorie" id="categorie" class="form-select" required>
                            <option value="">-- Choisir --</option>
                            <option value="offre">Offre</option>
                            <option value="demande">Demande</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="produit_id" class="form-label">Produit *</label>
                        <select name="produit_id" id="produit_id" class="form-select" required>
                            <option value="">{{ __('form.choose') ?? 'Choisir…' }}</option>
                            @foreach($produits as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->nom }}{{ $p->unite ? ' ('.$p->unite.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" step="0.01" min="0" name="quantite" id="quantite" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="prix_unitaire" class="form-label">{{ __('form.price') }}</label>
                        <input type="number" step="0.01" min="0" name="prix_unitaire" id="prix_unitaire" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label for="commune" class="form-label">Commune</label>
                        <input type="text" name="commune" id="commune" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label for="district" class="form-label">District</label>
                        <input type="text" name="district" id="district" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label for="region" class="form-label">Région</label>
                        <input type="text" name="region" id="region" class="form-control">
                    </div>

                    <div class="col-12">
                        <label for="contact" class="form-label">{{ __('form.phone') }}</label>
                        <input type="text" name="contact" id="contact" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('form.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-annonce">
                        {{ __('form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
