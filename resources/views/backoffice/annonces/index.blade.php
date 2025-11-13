@extends('backoffice.admin')

@section('titre', __('sidebar.annonces') ?? 'Annonces')

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path').'vendor/datatable/css/datatable.min.css') }}" />
    <link href="{{ asset(config('public_path.public_path').'vendor/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.annonces.show')
    @include('backoffice.annonces.form')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-success btn-sm" id="btn-add-annonce">
                <i class="fa fa-plus"></i> {{ __('form.add') }} Annonce
            </button>
        </div>
    </div>

    <div class="row mb-2 mt-3">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables-annonces" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">Catégorie</th>
                            <th class="text-center">Produit</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-center">{{ __('form.price') }}</th>
                            <th class="text-center">Localisation</th>
                            <th class="text-center">{{ __('form.phone') }}</th>
                            <th class="text-center">{{ __('form.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('#datatables-annonces').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.annonces.index') }}',
                columns: [
                    {
                        data: 'categorie',
                        name: 'categorie',
                        className: 'text-center',
                        render: function (data) {
                            if (data === 'offre') return '<span class="badge bg-success">Offre</span>';
                            if (data === 'demande') return '<span class="badge bg-primary">Demande</span>';
                            return data ?? '';
                        }
                    },
                    {data: 'produit_nom', name: 'produit.nom', className: 'text-center'},
                    {data: 'quantite_unite', name: 'quantite', className: 'text-center'},
                    {data: 'prix_unitaire', name: 'prix_unitaire', className: 'text-center'},
                    {data: 'localisation', name: 'localisation', className: 'text-center', orderable:false, searchable:false},
                    {data: 'contact', name: 'contact', className: 'text-center'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
                ],
                order: [[0, 'asc']]
            });

            // Nouveau
            $('#btn-add-annonce').on('click', function () {
                $('#annonceForm')[0].reset();
                $('#annonce_id').val('');
                $('#annonceModalLabel').text('Nouvelle annonce');
                $('#annonceForm input, #annonceForm select, #annonceForm textarea').prop('disabled', false);
                $('#btn-save-annonce').show();
                $('#annonceModal').modal('show');
            });

            // Submit (create/update)
            $('#annonceForm').on('submit', function (e) {
                e.preventDefault();

                let id = $('#annonce_id').val();
                let formData = $(this).serialize();
                let url;

                if (id === '') {
                    url = '{{ route('admin.annonces.store') }}';
                } else {
                    url = '{{ route("admin.annonces.update", ":id") }}'.replace(':id', id);
                    formData += '&_method=PUT';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        $('#annonceModal').modal('hide');
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

            // Show
            $(document).on('click', '#btn-show-annonce', function () {
                let id = $(this).data('id');
                let url = '{{ route("admin.annonces.show", ":id") }}'.replace(':id', id);

                $.get(url, function (data) {
                    $('#show_categorie').text(data.categorie === 'offre' ? 'Offre' : 'Demande');
                    $('#show_produit').text(data.produit ? data.produit.nom : '');
                    let q = data.quantite;
                    let u = data.produit ? data.produit.unite : '';
                    $('#show_quantite').text(q !== null ? (q + (u ? ' ' + u : '')) : '');
                    $('#show_prix').text(data.prix_formatted || '');
                    let locParts = [];
                    if (data.commune) locParts.push(data.commune);
                    if (data.district) locParts.push(data.district);
                    if (data.region) locParts.push(data.region);
                    $('#show_localisation').text(locParts.join(' - '));
                    $('#show_contact').text(data.contact || '');
                    $('#annonceShowModal').modal('show');
                }).fail(function () {
                    toastr.error('Impossible de charger l’annonce.');
                });
            });

            // Edit
            $(document).on('click', '#btn-edit-annonce', function () {
                let id = $(this).data('id');
                let url = '{{ route("admin.annonces.show", ":id") }}'.replace(':id', id);

                $.get(url, function (data) {
                    $('#annonceModalLabel').text('Modifier l’annonce');
                    $('#annonce_id').val(id);

                    $('#categorie').val(data.categorie);
                    $('#produit_id').val(data.produit_id);
                    $('#quantite').val(data.quantite);
                    $('#prix_unitaire').val(data.prix_unitaire);
                    $('#commune').val(data.commune);
                    $('#district').val(data.district);
                    $('#region').val(data.region);
                    $('#contact').val(data.contact);

                    $('#annonceForm input, #annonceForm select, #annonceForm textarea').prop('disabled', false);
                    $('#btn-save-annonce').show();
                    $('#annonceModal').modal('show');
                }).fail(function () {
                    toastr.error('Impossible de charger l’annonce.');
                });
            });

            // Delete
            $(document).on('click', '#btn-delete-annonce-confirm', function () {
                let id = $(this).data('id');

                Swal.fire({
                    title: '{{ __("form.delete_confirm") }}',
                    text: 'Cette action est irréversible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __("form.yes") }}',
                    cancelButtonText: '{{ __("form.no") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = '{{ route("admin.annonces.destroy", ":id") }}'.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_method: 'DELETE'},
                            success: function (res) {
                                table.ajax.reload(null, false);
                                toastr.success(res.message || 'Annonce supprimée avec succès.');
                            },
                            error: function () {
                                toastr.error('Impossible de supprimer l’annonce.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
