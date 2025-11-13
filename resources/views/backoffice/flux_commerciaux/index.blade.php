@extends('backoffice.admin')

@section('titre', __('sidebar.flux_commercials') ?? 'Flux commerciaux')

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path').'vendor/datatable/css/datatable.min.css') }}" />
    <link href="{{ asset(config('public_path.public_path').'vendor/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.flux_commerciaux.show')
    @include('backoffice.flux_commerciaux.form')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-success btn-sm" id="btn-add-flux">
                <i class="fa fa-plus"></i> {{ __('form.add') }} Flux commercial
            </button>
        </div>
    </div>

    <div class="row mb-2 mt-3">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables-flux" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">Type</th>
                            <th class="text-center">Produit</th>
                            <th class="text-center">{{ __('form.year') ?? 'Année' }}</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-center">{{ __('form.value') ?? 'Valeur (MGA)' }}</th>
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

            let table = $('#datatables-flux').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.flux_commerciaux.index') }}',
                columns: [
                    {
                        data: 'type',
                        name: 'type',
                        className: 'text-center',
                        render: function (data) {
                            if (data === 'import') return '<span class="badge bg-primary">Import</span>';
                            if (data === 'export') return '<span class="badge bg-success">Export</span>';
                            return data ?? '';
                        }
                    },
                    {data: 'produit_nom', name: 'produit.nom', className: 'text-center'},
                    {data: 'annee', name: 'annee', className: 'text-center'},
                    {data: 'quantite', name: 'quantite', className: 'text-end'},
                    {data: 'valeur', name: 'valeur', className: 'text-end'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
                ],
                order: [[2, 'desc']]
            });

            // Nouveau
            $('#btn-add-flux').on('click', function () {
                $('#fluxForm')[0].reset();
                $('#flux_id').val('');
                $('#fluxModalLabel').text('Nouveau flux commercial');
                $('#fluxForm input, #fluxForm select').prop('disabled', false);
                $('#btn-save-flux').show();
                $('#fluxModal').modal('show');
            });

            // Submit (create/update)
            $('#fluxForm').on('submit', function (e) {
                e.preventDefault();

                let id = $('#flux_id').val();
                let formData = $(this).serialize();
                let url;

                if (id === '') {
                    url = '{{ route('admin.flux_commerciaux.store') }}';
                } else {
                    url = '{{ route("admin.flux_commerciaux.update", ":id") }}'.replace(':id', id);
                    formData += '&_method=PUT';
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        $('#fluxModal').modal('hide');
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
            $(document).on('click', '#btn-show-flux', function () {
                let id = $(this).data('id');
                let url = '{{ route("admin.flux_commerciaux.show", ":flux_commercial") }}'
                    .replace(':flux_commercial', id);

                $.get(url, function (data) {
                    $('#show_type').text(data.type === 'import' ? 'Import' : 'Export');
                    $('#show_produit').text(data.produit ? data.produit.nom : '');
                    $('#show_annee').text(data.annee);

                    let q = data.quantite !== null
                        ? new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(data.quantite)
                        : '';
                    $('#show_quantite').text(q);

                    let v = data.valeur !== null
                        ? new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(data.valeur) + ' MGA'
                        : '';
                    $('#show_valeur').text(v);

                    $('#fluxShowModal').modal('show');
                }).fail(function () {
                    toastr.error('Impossible de charger le flux commercial.');
                });
            });

            // Edit
            $(document).on('click', '#btn-edit-flux', function () {
                let id = $(this).data('id');
                let url = '{{ route("admin.flux_commerciaux.show", ":flux_commercial") }}'
                    .replace(':flux_commercial', id);

                $.get(url, function (data) {
                    $('#fluxModalLabel').text('Modifier le flux commercial');
                    $('#flux_id').val(id);

                    $('#type').val(data.type);
                    $('#produit_id').val(data.produit_id);
                    $('#annee').val(data.annee);
                    $('#quantite').val(data.quantite);
                    $('#valeur').val(data.valeur);

                    $('#fluxForm input, #fluxForm select').prop('disabled', false);
                    $('#btn-save-flux').show();
                    $('#fluxModal').modal('show');
                }).fail(function () {
                    toastr.error('Impossible de charger le flux commercial.');
                });
            });

            // Delete
            $(document).on('click', '#btn-delete-flux-confirm', function () {
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
                        let url = '{{ route("admin.flux_commerciaux.destroy", ":flux_commercial") }}'
                            .replace(':flux_commercial', id);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_method: 'DELETE'},
                            success: function (res) {
                                table.ajax.reload(null, false);
                                toastr.success(res.message || 'Flux commercial supprimé avec succès.');
                            },
                            error: function () {
                                toastr.error('Impossible de supprimer le flux commercial.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
