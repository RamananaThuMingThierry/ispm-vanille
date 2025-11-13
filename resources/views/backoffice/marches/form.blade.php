<div class="modal fade" id="marcheModal" tabindex="-1" aria-labelledby="marcheModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="marcheForm">
                @csrf
                <input type="hidden" id="marche_id" name="marche_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="marcheModalLabel">Nouveau marché</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label for="date" class="form-label">{{ __('form.date') }} *</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="produit_id" class="form-label">Produit *</label>
                        <select name="produit_id" id="produit_id" class="form-select" required>
                            <option value="">{{ __('form.choose') ?? 'Choisir…' }}</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="prix" class="form-label">{{ __('form.price') }} *</label>
                        <input type="number" step="0.01" min="0" name="prix" id="prix" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="disponibilite" class="form-label">Disponibilité</label>
                        <input type="number" min="0" name="disponibilite" id="disponibilite" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('form.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-marche">
                        {{ __('form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
