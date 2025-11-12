<!-- Modal Details User -->
<div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content rounded-1">
        <div class="modal-header">
          <h5 class="modal-title" id="showUserModalLabel"><i class="fas fa-info-circle text-danger"></i>&nbsp;{{ __('Détails de l\'utilisateur') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
            <img id="show-avatar" src="" class="rounded-circle shadow" width="200" height="200" alt="Avatar">
          </div>
          <ul class="list-group">
            <li class="list-group-item"><span class="fw-bold">Pseudo :</span> <span id="show-pseudo"></span></li>
            <li class="list-group-item"><span class="fw-bold">Email :</span> <span id="show-email"></span></li>
            <li class="list-group-item"><span class="fw-bold">Contact :</span> <span id="show-contact"></span></li>
            <li class="list-group-item"><span class="fw-bold">Adresse :</span> <span id="show-address"></span></li>
            <li class="list-group-item"><span class="fw-bold">Rôle :</span> <span id="show-role" class="badge"></span></li>
            <li class="list-group-item"><span class="fw-bold">Statut :</span> <span id="show-status" class="badge"></span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
