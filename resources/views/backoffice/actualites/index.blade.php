@extends('backoffice.admin')

@section('titre', __('sidebar.actualites'))

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path').'vendor/datatable/css/datatable.min.css') }}" />
    <link href="{{ asset(config('public_path.public_path').'vendor/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    @include('backoffice.actualites.show')
    @include('backoffice.actualites.form')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <button class="btn btn-success btn-sm" id="btn-add-actualite">
                <i class="fa fa-plus"></i> {{ __('form.add') }} Actualité
            </button>
        </div>
    </div>

    <div class="row mb-2 mt-3">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables-actualites" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <tr>
                            <th class="text-center">Image</th>
                            <th class="text-center">{{ __('form.name') }}</th>
                            <th class="text-center">À la une</th>
                            <th class="text-center">{{ __('form.date') }}</th>
                            <th class="text-center">{{ __('form.description') }}</th>
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
        // --- utils réutilisables ---
        function resetImageInputAndPreview() {
            const $input = $('#image');
            // vider le champ fichier (tous navigateurs)
            $input.val('');
            if ($input.get(0)) $input.get(0).value = null;

            // révoquer un éventuel blob précédent
            const oldBlob = $('#image-preview').data('blob-url');
            if (oldBlob) {
                URL.revokeObjectURL(oldBlob);
                $('#image-preview').removeData('blob-url');
            }

            // cacher l’aperçu
            $('#image-preview-container').hide();
            $('#image-preview').attr('src', '');
        }

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Aperçu live dès qu’on choisit un nouveau fichier
            $('#image').on('change', function () {
                const file = this.files && this.files[0];
                // révoquer le blob précédent si besoin
                const oldBlob = $('#image-preview').data('blob-url');
                if (oldBlob) {
                    URL.revokeObjectURL(oldBlob);
                    $('#image-preview').removeData('blob-url');
                }

                if (file) {
                    const url = URL.createObjectURL(file);
                    $('#image-preview').attr('src', url).data('blob-url', url);
                    $('#image-preview-container').show();
                } else {
                    $('#image-preview-container').hide();
                    $('#image-preview').attr('src', '');
                }
            });

            // Nettoyer à la fermeture de la modale
            $('#actualiteModal').on('hidden.bs.modal', function () {
                resetImageInputAndPreview();
            });

            let table = $('#datatables-actualites').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.actualites.index') }}',
                columns: [
                    {
                        data: 'image',
                        name: 'image',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            let url;
                            if (data) {
                                url = '{{ asset(config('public_path.public_path').'images/actualites') }}/' + data + '?v=' + Date.now();
                            } else {
                                url = '{{ asset(config('public_path.public_path').'images/empty.png') }}';
                            }
                            return '<img src="'+url+'" alt="Image" style="max-height:50px;width:50px;">';
                        }
                    },
                    {data: 'titre', name: 'titre', className: 'text-center'},
                    {
                        data: 'ala_une',
                        name: 'ala_une',
                        className: 'text-center',
                        render: function (data) {
                            if (data) {
                                return '<span class="badge bg-success">Oui</span>';
                            }
                            return '<span class="badge bg-secondary">Non</span>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center',
                        render: function (data) {
                            return data ? new Date(data).toLocaleString() : '';
                        }
                    },
                    {
                        data: 'contenu',
                        name: 'contenu',
                        className: 'text-center',
                        render: function (data) {
                            if (!data) return '';
                            return data.length > 80 ? data.substring(0, 80) + '…' : data;
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
                ],
                order: [[3, 'desc']]
            });

            // Nouveau
            $('#btn-add-actualite').on('click', function () {
                $('#actualiteForm')[0].reset();
                $('#actualite_id').val('');
                $('#actualiteModalLabel').text('Nouvelle actualité');
                $('#image-preview-container').hide();
                $('#image-preview').attr('src', '');
                $('#actualiteForm input, #actualiteForm textarea').prop('disabled', false);
                $('#btn-save-actualite').show();
                $('#actualiteModal').modal('show');
            });

            // Submit (create / update) avec FormData
            $('#actualiteForm').on('submit', function (e) {
                e.preventDefault();

                let encryptedId = $('#actualite_id').val();
                let form = document.getElementById('actualiteForm');
                let formData = new FormData(form);
                let url;

                if (encryptedId === '') {
                    url = '{{ route('admin.actualites.store') }}';
                } else {
                    url = '{{ route("admin.actualites.update", ":id") }}'.replace(':id', encryptedId);
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        $('#actualiteModal').modal('hide');
                        resetImageInputAndPreview();
                        document.getElementById('actualiteForm').reset();
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

            // Show détail
            $(document).on('click', '#btn-show-actualite', function () {
                let encryptedId = $(this).data('id');
                let url = '{{ route("admin.actualites.show", ":id") }}'.replace(':id', encryptedId);

                $.get(url, function (data) {
                    $('#show_titre').text(data.titre);
                    $('#show_contenu').text(data.contenu || '');
                    $('#show_ala_une').text(data.ala_une ? 'Oui' : 'Non');

                    if (data.image) {
                        let url = '{{ asset(config('public_path.public_path').'images/actualites') }}/' + data.image + '?v=' + Date.now();
                        $('#show_image').attr('src', url).show();
                    } else {
                        $('#show_image').hide();
                    }

                    $('#actualiteShowModal').modal('show');
                }).fail(function () {
                    toastr.error('Impossible de charger l’actualité.');
                });
            });

            // Edit
            $(document).on('click', '#btn-edit-actualite', function () {
                let encryptedId = $(this).data('id');
                let url = '{{ route("admin.actualites.show", ":id") }}'.replace(':id', encryptedId);

                // on repart d'une base propre
                resetImageInputAndPreview();

                $.get(url, function (data) {
                    $('#actualiteModalLabel').text('Modifier l’actualité');
                    $('#actualite_id').val(encryptedId);

                    $('#titre').val(data.titre);
                    $('#contenu').val(data.contenu);
                    $('#ala_une').prop('checked', !!data.ala_une);

                    if (data.image) {
                        // Anti-cache : on force le refresh de l’image
                        let base = '{{ asset(config('public_path.public_path').'images/actualites') }}/' + data.image;
                        let bust = base + '?v=' + Date.now();
                        $('#image-preview').attr('src', bust);
                        $('#image-preview-container').show();
                    } else {
                        $('#image-preview-container').hide();
                        $('#image-preview').attr('src', '');
                    }

                    // IMPORTANT: le champ fichier reste vide tant que l'utilisateur ne choisit rien
                    const input = document.getElementById('image');
                    if (input) input.value = null;

                    $('#actualiteForm input, #actualiteForm textarea').prop('disabled', false);
                    $('#btn-save-actualite').show();
                    $('#actualiteModal').modal('show');
                }).fail(function () {
                    toastr.error('Impossible de charger l’actualité.');
                });
            });

            // Delete
            $(document).on('click', '#btn-delete-actualite-confirm', function () {
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
                        let url = '{{ route("admin.actualites.destroy", ":id") }}'.replace(':id', encryptedId);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_method: 'DELETE'},
                            success: function (res) {
                                table.ajax.reload(null, false);
                                toastr.success(res.message || 'Actualité supprimée avec succès.');
                            },
                            error: function () {
                                toastr.error('Impossible de supprimer l’actualité.');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
