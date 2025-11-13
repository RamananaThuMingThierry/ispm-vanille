<div class="modal fade" id="fluxModal" tabindex="-1" aria-labelledby="fluxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="fluxForm">
                @csrf
                <input type="hidden" id="flux_id" name="flux_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="fluxModalLabel">Nouveau flux commercial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('form.close') }}"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-4">
                        <label for="type" class="form-label">Type *</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="">-- Choisir --</option>
                            <option value="import">Import</option>
                            <option value="export">Export</option>
                        </select>
                    </div>

                    <div class="col-md-4">
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

                    <div class="col-md-4">
                        <label for="annee" class="form-label">{{ __('form.year') ?? 'Année' }} *</label>
                        <input type="number" name="annee" id="annee" class="form-control" required min="1900" max="2100">
                    </div>

                    <div class="col-md-6">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" step="0.01" min="0" name="quantite" id="quantite" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="valeur" class="form-label">{{ __('form.value') ?? 'Valeur (MGA)' }}</label>
                        <input type="number" step="0.01" min="0" name="valeur" id="valeur" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('form.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-flux">
                        {{ __('form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
