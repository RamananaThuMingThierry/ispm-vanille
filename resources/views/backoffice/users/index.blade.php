@extends('backoffice.admin')

@section('titre', __('title.users'))

@push('styles')
    <link rel="stylesheet" href="{{ asset(config('public_path.public_path') . 'vendor/datatable/css/datatable.min.css') }}" />
@endpush

@section('content')
    @include('backoffice.users.details')
    @include('backoffice.users.update')

    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-12">
            <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">{{ __('form.avatar') }}</th>
                                <th class="text-center">{{ __('form.pseudo') }}</th>
                                <th class="text-center">{{ __('form.email') }}</th>
                                <th class="text-center">{{ __('form.contact') }}</th>
                                <th class="text-center">{{ __('form.address') }}</th>
                                <th class="text-center">{{ __('form.status') }}</th>
                                <th class="text-center">{{ __('form.role') }}</th>
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
    <script src="{{ asset('vendor/datatable/js/datatable.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatables').DataTable({
                ajax: "{{ route('admin.users.index') }}",
                processing: true,
                serverSide: false,
                responsive: true,
                columns: [{
                        data: 'avatar',
                        className: 'text-center'
                    },
                    {
                        data: 'pseudo',
                        className: 'text-center'
                    },
                    {
                        data: 'email',
                        className: 'text-center'
                    },
                    {
                        data: 'contact',
                        className: 'text-center'
                    },
                    {
                        data: 'address',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'role',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    url: "{{ asset(config('public_path.public_path') . 'lang/datatables/' . app()->getLocale() . '.json') }}"
                }
            });

            // 📥 Ouvrir le modal avec les données
            $(document).on('click', '#btn-edit-user', function() {
                const id = $(this).data('id');
                const role = $(this).data('role');
                const status = $(this).data('status');

                $('#edit-user-id').val(id);
                $('#edit-user-role').val(role);
                $('#edit-user-status').val(status);
                $('#editUserModal').modal('show');
            });

            // ✅ Soumission du formulaire
            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#edit-user-id').val();
                let role = $('#edit-user-role').val();
                let status = $('#edit-user-status').val();
                let $btn = $('#btn-update-user');

                $btn.prop('disabled', true);
                $btn.find('.spinner-border').removeClass('d-none');
                $btn.find('.btn-text').text('{{ __('form.in_progress') }}');

                $.ajax({
                    url: `/backoffice/users/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        role: role,
                        status: status
                    },
                    success: function(res) {
                        $('#editUserModal').modal('hide');
                        $('#datatables').DataTable().ajax.reload(null, false);
                        toastr.options.positionClass = 'toast-middle-center';
                        toastr.success(res.message);
                    },
                    error: function(xhr) {
                        toastr.error('{{ __('form.error_update') }}');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                        $btn.find('.spinner-border').addClass('d-none');
                        $btn.find('.btn-text').text('{{ __('form.save') }}');
                    }
                });
            });

            $(document).on('click', '#btn-delete-user', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: '{{ __('alerts.confirm_title') }}',
                    text: '{{ __('alerts.confirm_text') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-sm btn-dark',
                        cancelButton: 'btn btn-sm btn-danger ms-1'
                    },
                    buttonsStyling: false,
                    confirmButtonText: '{{ __('alerts.confirm_button') }}',
                    cancelButtonText: '{{ __('alerts.cancel_button') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/backoffice/users/${id}`,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                $('#datatables').DataTable().ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __('alerts.deleted') }}',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ __('alerts.error') }}',
                                    text: '{{ __('alerts.delete_failed') }}'
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#btn-show-user', function() {
                const id = $(this).data('id');

                $.get(`/backoffice/users/${id}`, function(res) {
                    if (res.status) {
                        const user = res.data;
                        $('#show-avatar').attr('src', user.avatar_url);
                        $('#show-pseudo').text(user.pseudo);
                        $('#show-email').text(user.email);
                        $('#show-contact').text(user.contact ?? '-');
                        $('#show-address').text(user.address ?? '-');

                        // Rôle
                        $('#show-role')
                            .removeClass()
                            .addClass('badge bg-info')
                            .text(user.role === 'admin' ? 'Admin' : 'Utilisateur');

                        // Statut
                        $('#show-status')
                            .removeClass()
                            .addClass(user.status === 'active' ? 'badge bg-success' :
                                'badge bg-secondary')
                            .text(user.status === 'active' ? 'Actif' : 'Inactif');

                        $('#showUserModal').modal('show');
                    }
                });
            });
        });
    </script>
@endpush
