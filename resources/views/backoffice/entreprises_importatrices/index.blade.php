@extends('backoffice.admin')

@section('titre', __('sidebar.entreprise_importatrice'))

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path').'vendor/datatable/css/datatable.min.css') }}" />
    <link href="{{ asset(config('public_path.public_path').'vendor/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    {{-- Modals --}}
    @include('backoffice.entreprises_importatrices.show')
    @include('backoffice.entreprises_importatrices.form')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-success btn-sm" id="btn-add-entreprise-importatrice">
                <i class="fa fa-plus"></i> {{ __('form.add') }} {{ __('sidebar.entreprise_importatrice') }}
            </button>
        </div>
    </div>

    <div class="row mb-2 mt-3">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables-entreprises-importatrices" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">{{ __('form.name') }}</th>
                            <th class="text-center">Pays</th>
                            <th class="text-center">{{ __('form.address') }}</th>
                            <th class="text-center">{{ __('form.email') }}</th>
                            <th class="text-center">{{ __('form.phone') }}</th>
                            <th class="text-center">Responsable</th>
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

            let table = $('#datatables-entreprises-importatrices').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.entreprises_importatrices.index') }}',
                columns: [
                    {data: 'nom', name: 'nom', className: 'text-center'},
                    {data: 'pays', name: 'pays', className: 'text-center'},
                    {data: 'adresse', name: 'adresse', className: 'text-center'},
                    {data: 'email', name: 'email', className: 'text-center'},
                    {data: 'telephone', name: 'telephone', className: 'text-center'},
                    {data: 'responsable', name: 'responsable', className: 'text-center'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
                ],
                order: [[0, 'asc']]
            });

            // Nouveau
            $('#btn-add-entreprise-importatrice').on('click', function () {
                $('#entrepriseImportatriceForm')[0].reset();
                $('#entreprise_importatrice_id').val('');
                $('#entrepriseImportatriceModalLabel').text('Nouvelle entreprise importatrice');
                $('#entrepriseImportatriceForm input, #entrepriseImportatriceForm textarea').prop('disabled', false);
                $('#btn-save-entreprise-importatrice').show();
                $('#entrepriseImportatriceModal').modal('show');
            });

            // Submit (create/update)
            $('#entrepriseImportatriceForm').on('submit', function (e) {
                e.preventDefault();

                let encryptedId = $('#entreprise_importatrice_id').val();
                let formData = $(this).serialize();
                let url;

                if (encryptedId === '') {
                    url = '{{ route('admin.entreprises_importatrices.store') }}';
                } else {
                    url = '{{ route("admin.entreprises_importatrices.update", ":id") }}';
                    url = url.replace(':id', encryptedId);
                    formData += '&_method=PUT';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        $('#entrepriseImportatriceModal').modal('hide');
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
            $(document).on('click', '#btn-show-entreprise-importatrice', function () {
                let encryptedId = $(this).data('id');
                let url = '{{ route("admin.entreprises_importatrices.show", ":id") }}'.replace(':id', encryptedId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#show_nom').text(data.nom);
                        $('#show_raison_sociale').text(data.raison_sociale);
                        $('#show_pays').text(data.pays);
                        $('#show_adresse').text(data.adresse);
                        $('#show_email').text(data.email);
                        $('#show_telephone').text(data.telephone);
                        $('#show_responsable').text(data.responsable);
                        $('#show_activite').text(data.activite);
                        $('#show_description').text(data.description);

                        $('#entrepriseImportatriceShowModal').modal('show');
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            toastr.error('Entreprise introuvable.');
                        } else {
                            toastr.error('Impossible de charger l’entreprise.');
                        }
                    }
                });
            });

            // Edit
            $(document).on('click', '#btn-edit-entreprise-importatrice', function () {
                let encryptedId = $(this).data('id');
                let url = '{{ route("admin.entreprises_importatrices.show", ":id") }}'.replace(':id', encryptedId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#entrepriseImportatriceModalLabel').text('Modifier l’entreprise importatrice');
                        $('#entreprise_importatrice_id').val(encryptedId);

                        $('#nom').val(data.nom);
                        $('#raison_sociale').val(data.raison_sociale);
                        $('#pays').val(data.pays);
                        $('#adresse').val(data.adresse);
                        $('#email').val(data.email);
                        $('#telephone').val(data.telephone);
                        $('#responsable').val(data.responsable);
                        $('#activite').val(data.activite);
                        $('#description').val(data.description);

                        $('#entrepriseImportatriceForm input, #entrepriseImportatriceForm textarea').prop('disabled', false);
                        $('#btn-save-entreprise-importatrice').show();
                        $('#entrepriseImportatriceModal').modal('show');
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            toastr.error('Entreprise introuvable.');
                        } else {
                            toastr.error('Impossible de charger l’entreprise.');
                        }
                    }
                });
            });

            // Delete
            $(document).on('click', '#btn-delete-entreprise-importatrice-confirm', function () {
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
                        let url = '{{ route("admin.entreprises_importatrices.destroy", ":id") }}'.replace(':id', encryptedId);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_method: 'DELETE'},
                            success: function (res) {
                                table.ajax.reload(null, false);
                                toastr.success(res.message || 'Entreprise supprimée avec succès.');
                            },
                            error: function () {
                                toastr.error('Impossible de supprimer l’entreprise.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
