<!-- Modal édition utilisateur -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editUserForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-user-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Modifier l\'utilisateur') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('form.role') }}</label>
                        <select id="edit-user-role" class="form-select" required>
                            <option value="user">Utilisateur</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('form.status') }}</label>
                        <select id="edit-user-status" class="form-select" required>
                            <option value="active">Actif</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i>&nbsp;{{ __('form.cancel') }}</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="btn-update-user">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        <span class="btn-text"><i class="fa fa-save"></i>&nbsp;{{ __('form.save') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
