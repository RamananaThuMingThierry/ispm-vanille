<!-- Modal Changement de mot de passe -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered rounded-1">
      <form action="{{ route('admin.profile.password.update') }}" method="POST" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editPasswordModalLabel"><i class="fas fa-edit"></i>&nbsp;{{ __('default.change_password') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label for="current_password" class="form-label">{{ __('default.current_password') }}</label>
              <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
              <label for="new_password" class="form-label">{{ __('default.new_password') }}</label>
              <input type="password" name="new_password" class="form-control" required>
          </div>
          <div class="mb-3">
              <label for="new_password_confirmation" class="form-label">{{ __('default.confirmation') }}</label>
              <input type="password" name="new_password_confirmation" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-lock"></i>&nbsp;{{ __('default.update') }}</button>
        </div>
      </form>
    </div>
  </div>
