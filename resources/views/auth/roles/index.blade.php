@extends('layout')

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Roles & permisos</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Roles & permisos</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

        <div class="row">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                @can('roles.create')
                    <a href="javascript:void(0)" class="btn btn-primary btn-block" data-toggle="modal"
                        data-target="#modal_roles" onclick="resetForm('Agregar')">
                        <i class="fa fa-plus"></i> Crear rol
                    </a>
                @endcan

                <div class="roles-menu">
                    <ul>
                        @foreach ($roles as $role)
                            <li class="items" id="item-{{ $role->id }}">
                                <a href="javascript:void(0)" style="cursor:auto">
                                    <span>
                                        {{ $role->name }}
                                    </span>
                                    <span class="role-action">
                                        <span class="action-circle large view-permission" data-bs-toggle="tooltip"
                                            title="Ver permisos" data-data="{{ json_encode($role) }}">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        @if ($role->id != 1)
                                            @can('roles.edit')
                                                <span class="action-circle large" data-bs-toggle="tooltip"
                                                    title="Guardar cambios" onclick="editRol({{ $role }})"
                                                    data-toggle="modal" data-target="#modal_roles">
                                                    <i class="material-icons">edit</i>
                                                </span>
                                            @endcan
                                            @can('roles.delete')
                                                <span class="action-circle large delete-btn deleteBtn" data-bs-toggle="tooltip"
                                                    title="Eliminar rol" data-toggle="modal" data-target="#delete_role"
                                                    onclick="$('#rol_id').val({{ $role->id }})">
                                                    <i class="material-icons">delete</i>
                                                </span>
                                            @endcan
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
                <div class="table-responsive">
                    <form method="POST" action="{{ route('admin.permission.update') }}" id="form-permisos">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="role_id" id="role_id">
                        <table class="table table-striped custom-table">
                            <thead>
                                <tr>
                                    <th>Modulo</th>
                                    <th class="text-center">Leer</th>
                                    <th class="text-center">Crear</th>
                                    <th class="text-center">Editar</th>
                                    <th class="text-center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $module => $permission)
                                    <tr>
                                        <td>{{ $module }}</td>
                                        @foreach (['show', 'create', 'edit', 'delete'] as $action)
                                            <td class="text-center">
                                                @foreach ($permission as $item)
                                                    @if (str_ends_with($item, ".$action"))
                                                        <label class="custom_check">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $item }}" class="check-permission"
                                                                id="{{ str_replace('.', '-', $item) }}">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @can('roles.edit')
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit" id="btn-submit" disabled>
                                    Actualizar rol <span id="text-btn"></span>
                                </button>
                            </div>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->can('roles.create') || Auth::user()->can('roles.edit'))
        <!-- Add Department Modal -->
        <div id="modal_roles" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-form"></span> rol</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-roles">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" id="name">
                                <span class="invalid-feedback" id="name_error"></span>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn" id="btn-form"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Department Modal -->
    @endif

    @can('roles.delete')
        <!-- Delete Department Modal -->
        <div class="modal custom-modal fade" id="delete_role" role="dialog">
            <div class="modal-dialog modal-dialog-centered">z
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Eliminar rol</h3>
                            <p>¿Esta seguro de eliminar el rol?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="deleteRol()">
                                        Eliminar
                                    </a>
                                    <input type="hidden" name="rol_id" id="rol_id">
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Department Modal -->
    @endcan
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.view-permission').on('click', function() {
                $('#btn-submit').removeAttr('disabled');
                const rol = $(this).data('data');
                $('#text-btn').html(rol.name)
                $('#role_id').val(rol.id)

                $('.items').each(function() {
                    $(this).removeClass('active')
                })

                $('#item-' + rol.id).addClass('active')

                $('.check-permission').each(function() {
                    $(this).removeAttr('checked').trigger('change');
                })

                for (let permiso of rol.permissions) {
                    const id = permiso.name.replace('.', '-')
                    $('#' + id).attr('checked', 'checked').trigger('change');
                }
            })

            $('#form-roles').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                }

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                const url = id ?
                    `{{ url('admin/roles') }}/${id}` :
                    '{{ route('admin.roles.store') }}';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        for (let campo in errors) {
                            let errorField = $(`#${campo}`);
                            errorField.addClass('is-invalid');
                            $(`#${campo}_error`).text(errors[campo][0]);
                        }
                    }
                });
            });
        });

        function resetForm(title) {
            $('#title-form').html(title)
            $('#btn-form').removeClass(function(index, className) {
                return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
            });
            $('#btn-form').addClass(`btn btn-${title == 'Agregar' ? 'success' : 'warning'}`);
            $('#btn-form').html(title == 'Agregar' ? 'Agregar' : 'Actualizar')

            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            $('#form-roles').trigger('reset')
        }

        function editRol(data) {
            resetForm('Editar')

            $('#id').val(data.id)
            $('#name').val(data.name)
        }

        function deleteRol() {
            const id = $('#rol_id').val()

            $.ajax({
                url: `{{ url('admin/roles') }}/${id}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(err) {
                    console.log(err);

                    alert('Error al eliminar.');
                }
            });
        }
    </script>
@endpush
