@extends('backoffice.admin')

@section('titre', __('title.producteurs'))

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path').'vendor/datatable/css/datatable.min.css') }}" />
    <link href="{{ asset(config('public_path.public_path').'vendor/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-success btn-sm" id="btn-add-producteur">
                <i class="fa fa-plus"></i> {{ __('form.add') }} Producteur
            </button>
        </div>
    </div>

    <div class="row mb-2 mt-3">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">{{ __('form.name') }}</th>
                            <th class="text-center">{{ __('form.firstname') }}</th>
                            <th class="text-center">{{ __('form.address') }}</th>
                            <th class="text-center">Quantité (kg)</th>
                            <th class="text-center">{{ __('form.phone') }}</th>
                            <th class="text-center">{{ __('form.email') }}</th>
                            <th class="text-center">Fokontany</th>
                            <th class="text-center">Commune</th>
                            <th class="text-center">District</th>
                            <th class="text-center">Région</th>
                            <th class="text-center">{{ __('form.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal CRUD --}}
    <div class="modal fade" id="producteurModal" tabindex="-1" aria-labelledby="producteurModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="producteurForm">
                    @csrf
                    <input type="hidden" id="producteur_id" name="producteur_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="producteurModalLabel">Nouveau producteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">{{ __('form.name') }} *</label>
                            <input type="text" name="nom" id="nom" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">{{ __('form.firstname') }}</label>
                            <input type="text" name="prenom" id="prenom" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="adresse" class="form-label">{{ __('form.address') }}</label>
                            <input type="text" name="adresse" id="adresse" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="quantite" class="form-label">Quantité (kg)</label>
                            <input type="number" step="0.01" name="quantite" id="quantite" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="telephone" class="form-label">{{ __('form.phone') }}</label>
                            <input type="text" name="telephone" id="telephone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">{{ __('form.email') }}</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="fokontany" class="form-label">Fokontany</label>
                            <input type="text" name="fokontany" id="fokontany" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="commune" class="form-label">Commune</label>
                            <input type="text" name="commune" id="commune" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="district" class="form-label">District</label>
                            <input type="text" name="district" id="district" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="region" class="form-label">Région</label>
                            <input type="text" name="region" id="region" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('form.close') }}
                        </button>
                        <button type="submit" class="btn btn-primary" id="btn-save-producteur">
                            {{ __('form.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/datatable/js/datatable.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            // CSRF pour AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // DataTable
            let table = $('#datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.producteurs.index') }}',
                columns: [
                    {data: 'nom', name: 'nom', className: 'text-center'},
                    {data: 'prenom', name: 'prenom', className: 'text-center'},
                    {data: 'adresse', name: 'adresse', className: 'text-center'},
                    {data: 'quantite', name: 'quantite', className: 'text-center'},
                    {data: 'telephone', name: 'telephone', className: 'text-center'},
                    {data: 'email', name: 'email', className: 'text-center'},
                    {data: 'fokontany', name: 'fokontany', className: 'text-center'},
                    {data: 'commune', name: 'commune', className: 'text-center'},
                    {data: 'district', name: 'district', className: 'text-center'},
                    {data: 'region', name: 'region', className: 'text-center'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
                ],
                order: [[0, 'asc']]
            });

            // Ouvrir modal "Nouveau producteur"
            $('#btn-add-producteur').on('click', function () {
                $('#producteurForm')[0].reset();
                $('#producteur_id').val('');
                $('#producteurModalLabel').text('Nouveau producteur');
                $('#producteurForm input, #producteurForm select, #producteurForm textarea').prop('disabled', false);
                $('#btn-save-producteur').show();
                $('#producteurModal').modal('show');
            });

            // Soumission form (create / update)
            $('#producteurForm').on('submit', function (e) {
                e.preventDefault();

                let encryptedId = $('#producteur_id').val();
                let formData = $(this).serialize();
                let url;

                if (encryptedId === '') {
                    // 🔹 CREATE → admin.producteurs.store (POST)
                    url = '{{ route("admin.producteurs.store") }}';
                } else {
                    // 🔹 UPDATE → admin.producteurs.update (PUT simulé en POST + _method)
                    url = '{{ route("admin.producteurs.update", ":id") }}';
                    url = url.replace(':id', encryptedId);
                    formData += '&_method=PUT';
                }

                $.ajax({
                    url: url,
                    type: 'POST', // toujours POST côté JS, _method gère PUT/POST côté Laravel
                    data: formData,
                    success: function (res) {
                        $('#producteurModal').modal('hide');
                        table.ajax.reload(null, false);
                        toastr.success(res.message || 'Opération réussie');
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let messages = [];
                            $.each(errors, function (k, v) {
                                messages.push(v.join('<br>'));
                            });
                            toastr.error(messages.join('<br>'));
                        } else {
                            toastr.error('Une erreur est survenue.');
                        }
                    }
                });
            });

            // Voir le détail d’un producteur (lecture seule)
            $(document).on('click', '#btn-show-producteur', function () {
                let encryptedId = $(this).data('id');

                // Utilisation du helper route() Laravel côté Blade
                let url = '{{ route("admin.producteurs.show", ":id") }}';
                url = url.replace(':id', encryptedId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#producteurModalLabel').text('Détails du producteur');
                        $('#producteur_id').val(''); // mode lecture seule

                        $('#nom').val(data.nom);
                        $('#prenom').val(data.prenom);
                        $('#adresse').val(data.adresse);
                        $('#quantite').val(data.quantite);
                        $('#telephone').val(data.telephone);
                        $('#email').val(data.email);
                        $('#fokontany').val(data.fokontany);
                        $('#commune').val(data.commune);
                        $('#district').val(data.district);
                        $('#region').val(data.region);

                        // désactiver les champs (lecture seule)
                        $('#producteurForm input, #producteurForm select, #producteurForm textarea').prop('disabled', true);
                        $('#btn-save-producteur').hide();

                        $('#producteurModal').modal('show');
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            toastr.error('Producteur introuvable.');
                        } else {
                            toastr.error('Impossible de charger le producteur.');
                        }
                    }
                });
            });

            // Éditer un producteur (pré-remplir le formulaire)
            $(document).on('click', '#btn-edit-producteur', function () {
                let encryptedId = $(this).data('id');

                // Générer l’URL de la route Laravel admin.producteurs.show
                let url = '{{ route("admin.producteurs.show", ":id") }}';
                url = url.replace(':id', encryptedId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#producteurModalLabel').text('Modifier le producteur');
                        $('#producteur_id').val(encryptedId);

                        // Remplir les champs
                        $('#nom').val(data.nom);
                        $('#prenom').val(data.prenom);
                        $('#adresse').val(data.adresse);
                        $('#quantite').val(data.quantite);
                        $('#telephone').val(data.telephone);
                        $('#email').val(data.email);
                        $('#fokontany').val(data.fokontany);
                        $('#commune').val(data.commune);
                        $('#district').val(data.district);
                        $('#region').val(data.region);

                        // Activer les champs pour édition
                        $('#producteurForm input, #producteurForm select, #producteurForm textarea').prop('disabled', false);

                        // Afficher le bouton "Enregistrer"
                        $('#btn-save-producteur').show();

                        // Afficher la modale
                        $('#producteurModal').modal('show');
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            toastr.error('Producteur introuvable.');
                        } else if (xhr.status === 400) {
                            toastr.error('Identifiant invalide.');
                        } else {
                            toastr.error('Impossible de charger les informations du producteur.');
                        }
                    }
                });
            });

            // Delete avec SweetAlert
            $(document).on('click', '#btn-delete-producteur-confirm', function () {
                let encryptedId = $(this).data('id');

                Swal.fire({
                    title: 'Supprimer ce producteur ?',
                    text: 'Cette action est irréversible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("admin.producteurs.destroy", ":id") }}'.replace(':id', encryptedId),
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (res) {
                                table.ajax.reload(null, false);
                                toastr.success(res.message || 'Producteur supprimé avec succès.');
                            },
                            error: function () {
                                toastr.error('Impossible de supprimer le producteur.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
