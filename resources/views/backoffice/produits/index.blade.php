@extends('backoffice.admin')

@section('titre', __('sidebar.produits'))

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path').'vendor/datatable/css/datatable.min.css') }}" />
    <link href="{{ asset(config('public_path.public_path').'vendor/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.produits.show')
    @include('backoffice.produits.form')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-success btn-sm" id="btn-add-produit">
                <i class="fa fa-plus"></i> {{ __('form.add') }} Produit
            </button>
        </div>
    </div>

    <div class="row mb-2 mt-3">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables-produits" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">Nom</th>
                            <th class="text-center">Unité</th>
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
    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('vendor/datatable/js/datatable.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Datatable
            let table = $('#datatables-produits').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.produits.index') }}',
                columns: [
                    {data: 'nom', name: 'nom', className: 'text-center'},
                    {data: 'unite', name: 'unite', className: 'text-center'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
                ],
                order: [[0, 'asc']]
            });

            // Nouveau produit
            $('#btn-add-produit').on('click', function () {
                $('#produitForm')[0].reset();
                $('#produit_id').val('');
                $('#produitModalLabel').text('Nouveau produit');
                $('#btn-save-produit').show();
                $('#produitModal').modal('show');
            });

            // Sauvegarde (Create / Update)
            $('#produitForm').on('submit', function (e) {
                e.preventDefault();
                let encryptedId = $('#produit_id').val();
                let formData = $(this).serialize();
                let url;

                if (encryptedId === '') {
                    url = '{{ route('admin.produits.store') }}';
                } else {
                    url = '{{ route("admin.produits.update", ":id") }}'.replace(':id', encryptedId);
                    formData += '&_method=PUT';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        $('#produitModal').modal('hide');
                        table.ajax.reload(null, false);
                        toastr.success(res.message || 'Opération réussie.');
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

            // Afficher un produit
            $(document).on('click', '#btn-show-produit', function () {
                let encryptedId = $(this).data('id');
                let url = '{{ route("admin.produits.show", ":id") }}'.replace(':id', encryptedId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#show_nom').text(data.nom);
                        $('#show_unite').text(data.unite);
                        $('#produitShowModal').modal('show');
                    },
                    error: function (xhr) {
                        toastr.error('Impossible de charger le produit.');
                    }
                });
            });

            // Modifier un produit
            $(document).on('click', '#btn-edit-produit', function () {
                let encryptedId = $(this).data('id');
                let url = '{{ route("admin.produits.show", ":id") }}'.replace(':id', encryptedId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#produitModalLabel').text('Modifier le produit');
                        $('#produit_id').val(encryptedId);
                        $('#nom').val(data.nom);
                        $('#unite').val(data.unite);
                        $('#btn-save-produit').show();
                        $('#produitModal').modal('show');
                    },
                    error: function () {
                        toastr.error('Erreur lors du chargement du produit.');
                    }
                });
            });

            // Supprimer un produit
            $(document).on('click', '#btn-delete-produit-confirm', function () {
                let encryptedId = $(this).data('id');

                Swal.fire({
                    title: '{{ __("form.delete_confirm") }}',
                    text: 'Cette action est irréversible.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __("form.yes") }}',
                    cancelButtonText: '{{ __("form.no") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = '{{ route("admin.produits.destroy", ":id") }}'.replace(':id', encryptedId);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_method: 'DELETE'},
                            success: function (res) {
                                table.ajax.reload(null, false);
                                toastr.success(res.message || 'Produit supprimé avec succès.');
                            },
                            error: function () {
                                toastr.error('Erreur lors de la suppression.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
