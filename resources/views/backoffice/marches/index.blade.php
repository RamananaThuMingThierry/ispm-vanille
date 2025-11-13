@extends('backoffice.admin')

@section('titre', __('sidebar.marches'))

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path').'vendor/datatable/css/datatable.min.css') }}" />
    <link href="{{ asset(config('public_path.public_path').'vendor/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.marches.show')
    @include('backoffice.marches.form')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-success btn-sm" id="btn-add-marche">
                <i class="fa fa-plus"></i> {{ __('form.add') }} Marché
            </button>
        </div>
    </div>

    <div class="row mb-2 mt-3">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables-marches" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">{{ __('form.date') }}</th>
                            <th class="text-center">Produit</th>
                            <th class="text-center">{{ __('form.price') }} (MGA)</th>
                            <th class="text-center">Disponibilité</th>
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
            // CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // DataTable
            let table = $('#datatables-marches').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '{{ route('admin.marches.index') }}',
                    dataSrc: 'data'
                },
                columns: [
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center',
                    },
                    { data: 'produit', name: 'produit', className: 'text-center'},
                    {
                        data: 'prix',
                        name: 'prix',
                        className: 'text-center',
                        render: function (data) {
                            if (data === null) return '';
                            return parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'disponibilite',
                        name: 'disponibilite',
                        className: 'text-center',
                        render: function (data) {
                            return data !== null ? data : '';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [[0, 'desc']]
            });

            // Nouveau marché
            $('#btn-add-marche').on('click', function () {
                $('#marcheForm')[0].reset();
                $('#marche_id').val('');
                $('#marcheModalLabel').text('Nouveau marché');
                $('#marcheForm input').prop('disabled', false);
                $('#btn-save-marche').show();
                $('#marcheModal').modal('show');
            });

            // Submit (create / update)
            $('#marcheForm').on('submit', function (e) {
                e.preventDefault();

                let encryptedId = $('#marche_id').val();
                let formData    = $(this).serialize();
                let url;

                if (encryptedId === '') {
                    url = '{{ route('admin.marches.store') }}';
                } else {
                    url = '{{ route("admin.marches.update", ":id") }}'.replace(':id', encryptedId);
                    formData += '&_method=PUT';
                }


                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        $('#marcheModal').modal('hide');
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

// Voir détail
$(document).on('click', '#btn-show-marche', function () {
    let id = $(this).data('id');
    let url = '{{ route("admin.marches.show", ":id") }}'.replace(':id', id);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            $('#show_date').text(data.date_formatted || '');
            $('#show_produit').text(data.produit || '');
            $('#show_prix').text(data.prix_formatted || '');
            $('#show_disponibilite').text(data.disponibilite ?? '');
            $('#marcheShowModal').modal('show');
        },
        error: function (xhr) {
            if (xhr.status === 404) {
                toastr.error('Marché introuvable.');
            } else {
                toastr.error('Impossible de charger le marché.');
            }
        }
    });
});


            // Éditer
            $(document).on('click', '#btn-edit-marche', function () {
                let id = $(this).data('id');
                let url = '{{ route("admin.marches.show", ":id") }}'.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#marcheModalLabel').text('Modifier le marché');
                        $('#marche_id').val(id);

                        // data.date = 'YYYY-MM-DD'
                        $('#date').val(data.date);
                        $('#produit_id').val(data.produit_id); // SELECT
                        $('#prix').val(data.prix); // valeur numérique
                        $('#disponibilite').val(data.disponibilite);

                        $('#marcheForm input, #marcheForm select').prop('disabled', false);
                        $('#btn-save-marche').show();
                        $('#marcheModal').modal('show');
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            toastr.error('Marché introuvable.');
                        } else {
                            toastr.error('Impossible de charger le marché.');
                        }
                    }
                });
            });


            // Supprimer
            $(document).on('click', '#btn-delete-marche-confirm', function () {
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
                        let url = '{{ route("admin.marches.destroy", ":id") }}'.replace(':id', encryptedId);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_method: 'DELETE'},
                            success: function (res) {
                                table.ajax.reload(null, false);
                                toastr.success(res.message || 'Marché supprimé avec succès.');
                            },
                            error: function () {
                                toastr.error('Impossible de supprimer le marché.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
