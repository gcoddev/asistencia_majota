@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Gestión de usuarios</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ul>
                </div>
                @can('usuario.create')
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#modal_usuario"
                            onclick="resetForm('Agregar')">
                            <i class="fa fa-plus"></i> Agregar usuario
                        </a>
                        <div class="view-icons">
                            <a href="#" class="grid-view btn btn-link" data-name="grid"><i class="fa fa-th"></i></a>
                            <a href="#" class="list-view btn btn-link active" data-name="list"><i
                                    class="fa fa-bars"></i></a>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /Page Header -->
        @include('components.alerts')
        <!-- Search Filter -->
        {{-- <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">ID de empleado</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Nombre del empleado</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        @foreach ($designaciones as $des)
                            <option value="{{ $des->id }}">{{ $des->nombres }}</option>
                        @endforeach
                    </select>
                    <label class="focus-label">Designaciones</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Buscar </a>
            </div>
        </div> --}}
        <!-- Search Filter -->

        <div class="row staff-grid-row" id="grid-users" style="display:none">
            @foreach ($usuarios as $user)
                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                    <div class="profile-widget">
                        <div class="profile-img">
                            <a href="{{ route('admin.perfil.show', $user->id) }}" class="avatar">
                                <img src="{{ asset($user->imagen ?? 'assets/img/user.jpg') }}" alt="">
                            </a>
                        </div>
                        @if (Auth::user()->can('usuario.delete') || Auth::user()->can('usuario.edit'))
                            <div class="dropdown profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @can('usuario.edit')
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_usuario"
                                            onclick="editUser({{ $user }})">
                                            <i class="fa fa-pencil m-r-5"></i> Editar
                                        </a>
                                    @endcan
                                    @if ($user->id != 1)
                                        @can('usuario.delete')
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#delete_employee" onclick="$('#usu_id').val({{ $user->id }})">
                                                <i class="fa fa-trash-o m-r-5"></i> Eliminar
                                            </a>
                                        @endcan
                                    @endif
                                </div>
                            </div>
                        @endif
                        <h4 class="user-name m-t-10 mb-0 text-ellipsis">
                            <a href="{{ route('admin.perfil.show', $user->id) }}">
                                {{ $user->nombres }}
                                {{ $user->apellidos }}
                            </a>
                        </h4>
                        @if ($user->detalle)
                            <div class="small text-muted">
                                {{ $user->detalle->departamento ? $user->detalle->departamento->nombre : '- Sin departamento -' }}
                            </div>
                            <div class="small text-muted">
                                {{ $user->detalle->designacion ? $user->detalle->designacion->nombre : '- Sin designación -' }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row" id="list-users" style="display:flex">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>CI</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Unido el</th>
                                <th>Estado</th>
                                <th class="text-right no-sort">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ route('admin.perfil.show', $user->id) }}" class="avatar">
                                                <img alt=""
                                                    src="{{ asset($user->imagen ?? 'assets/img/user.jpg') }}">
                                            </a>
                                            <a href="{{ route('admin.perfil.show', $user->id) }}">
                                                {{ $user->nombres }} {{ $user->apellidos }}
                                                @if ($user->detalle)
                                                    <span>
                                                        {{ $user->detalle->departamento ? $user->detalle->departamento->nombre : '- Sin departamento -' }}
                                                    </span>
                                                    <span>
                                                        {{ $user->detalle->designacion ? $user->detalle->designacion->nombre : '- Sin designación -' }}
                                                    </span>
                                                @endif
                                            </a>
                                        </h2>
                                    </td>
                                    <td>{{ $user->ci }}</td>
                                    <td>{{ $user->email ?? '-' }}</td>
                                    <td>{{ $user->role[0]->name }}</td>
                                    <td>{{ $user->detalle ? fecha_literal($user->detalle->fecha_ingreso) : '-' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            @php
                                                $canEditUser = Auth::user()->can('usuario.edit');
                                            @endphp
                                            <a href="#"
                                                class="btn btn-white btn-sm btn-rounded {{ $user->id != 1 && $canEditUser ? 'dropdown-toggle' : '' }}"
                                                data-toggle="{{ $user->id != 1 && $canEditUser ? 'dropdown' : '' }}"
                                                aria-expanded="false">
                                                <span>
                                                    <i
                                                        class="fa fa-circle m-r-5 {{ $user->activo == '1' ? 'text-success' : 'text-danger' }}"></i>
                                                    <span id="status-{{ $user->id }}">
                                                        {{ $user->activo == '1' ? 'Activo' : 'Inactivo' }}
                                                    </span>
                                                </span>
                                            </a>
                                            @if ($user->id != 1 && $canEditUser)
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item change-status" href="#"
                                                        data-id="{{ $user->id }}" data-status="1">
                                                        <i class="fa fa-circle m-r-5 text-success"></i>
                                                        Activo
                                                    </a>
                                                    <a class="dropdown-item change-status" href="#"
                                                        data-id="{{ $user->id }}" data-status="0">
                                                        <i class="fa fa-circle m-r-5 text-danger"></i>
                                                        Inactivo
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        @if (Auth::user()->can('usuario.delete') || Auth::user()->can('usuario.edit'))
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#modal_usuario"
                                                        onclick="editUser({{ $user }})">
                                                        <i class="fa fa-pencil m-r-5"></i>
                                                        Editar
                                                    </a>
                                                    @if ($user->id != 1)
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_employee"
                                                            onclick="$('#usu_id').val({{ $user->id }})">
                                                            <i class="fa fa-trash-o m-r-5"></i>
                                                            Eliminar
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    @if (Auth::user()->can('usuario.create') || Auth::user()->can('usuario.edit'))
        <!-- Employee Modal -->
        <div id="modal_usuario" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-form"></span> usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-usuario" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Imagen de perfil</label>
                                        <div class="profile-img profile-input">
                                            <label class="avatar" for="imagen">
                                                <div class="overlay">
                                                    <i class="fa fa-camera"></i>
                                                </div>
                                                <img src="{{ asset('assets/img/user.jpg') }}" alt=""
                                                    id="imagen-prev">
                                            </label>
                                        </div>
                                        <input type="file" name="imagen" id="imagen" class="d-none form-control"
                                            accept="image/png,image/jpg,image/jpeg">
                                        <span class="invalid-feedback" id="imagen_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Fecha de ingreso <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" name="fecha_ingreso"
                                            id="fecha_ingreso">
                                        <span class="invalid-feedback" id="fecha_ingreso_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombres <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="nombres" id="nombres">
                                        <span class="invalid-feedback" id="nombres_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellidos</label>
                                        <input class="form-control" type="text" name="apellidos" id="apellidos">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Cédula de identidad (CI) <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="ci" id="ci">
                                        <span class="invalid-feedback" id="ci_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" id="email">
                                        <span class="invalid-feedback" id="email_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Celular </label>
                                        <input class="form-control" type="text" name="celular" id="celular">
                                        <span class="invalid-feedback" id="celular_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Rol <span class="text-danger">*</span></label>
                                        <select class="select" name="role" id="role">
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback" id="role_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <select class="select" name="dep_id" id="dep_id">
                                            <option value="">-</option>
                                            @foreach ($departamentos as $dep)
                                                <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designación</label>
                                        <select class="select" name="des_id" id="des_id">
                                            <option value="">-</option>
                                            @foreach ($designaciones as $des)
                                                <option value="{{ $des->id }}">{{ $des->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Contraseña <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" id="password">
                                        <span class="invalid-feedback" id="password_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Confirmar contraseña <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            id="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-success submit-btn" id="btn-form"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Employee Modal -->
    @endif

    @can('usuario.delete')
        <!-- Delete Employee Modal -->
        <div class="modal custom-modal fade" id="delete_employee" role="dialog">
            <div class="modal-dialog modal-dialog-centered">z
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Eliminar usuario</h3>
                            <p>¿Esta seguro de eliminar el usuario?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn"
                                        onclick="deleteUser()">
                                        Eliminar
                                    </a>
                                    <input type="hidden" name="usu_id" id="usu_id">
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
        <!-- /Delete Employee Modal -->
    @endcan
@endsection

@push('styles')
    <style>
        .profile-input {
            position: relative;
            /* width: 100px; */
            /* Ajusta según el tamaño deseado */
            /* height: 100px; */
            /* Ajusta según el tamaño deseado */
            overflow: hidden;
            border-radius: 50%;
            /* Para hacerlo circular */
        }

        .profile-input img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .overlay {
            cursor: pointer;
        }

        .profile-input .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Oscurecimiento */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            opacity: 0;
            /* Oculto inicialmente */
            transition: opacity 0.3s ease;
            border-radius: 50%;
        }

        .profile-input:hover .overlay {
            opacity: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#form-usuario').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                }

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                const url = id ?
                    `{{ url('admin/usuarios') }}/${id}` :
                    '{{ route('admin.usuarios.store') }}';

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


            $('.change-status').click(function(e) {
                e.preventDefault();

                const userId = $(this).data('id');
                const newStatus = $(this).data('status');

                $.ajax({
                    url: `{{ url('admin/usuarios') }}/${userId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        activo: newStatus
                    },
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    },
                    error: function() {
                        alert('Error al actualizar.');
                    }
                });
            });

            $('.view-icons a').click(function(e) {
                e.preventDefault();

                $('.view-icons a').removeClass('active');
                $(this).addClass('active');
                switch ($(this).data('name')) {
                    case 'grid':
                        $('#list-users').css('display', 'none');
                        $('#grid-users').css('display', 'flex');
                        break;
                    case 'list':
                        $('#grid-users').css('display', 'none');
                        $('#list-users').css('display', 'flex');
                        break;
                }
            });

            $('#imagen').on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#imagen-prev').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(file);
                }
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

            $('#imagen-prev').attr('src', `{{ asset('assets/img/user.jpg') }}`);
            $('#form-usuario').trigger('reset')
            $('#role').val('empleado').trigger('change');
            $('#dep_id').val('').trigger('change')
            $('#des_id').val('').trigger('change')

            $('#role').removeAttr('disabled');
            $('#dep_id').removeAttr('disabled');
            $('#des_id').removeAttr('disabled');
        }

        function editUser(data) {
            resetForm('Editar')
            $('#id').val(data.id)
            $('#imagen-prev').attr('src',
                data.imagen ? `{{ asset('${data.imagen}') }}` : `{{ asset('assets/img/user.jpg') }}`
            );
            $('#imagen').val('');
            $('#nombres').val(data.nombres)
            $('#apellidos').val(data.apellidos)
            $('#ci').val(data.ci)
            $('#email').val(data.email)
            $('#password').val('')
            $('#password_confirmation').val('')
            $('#celular').val(data.celular)
            $('#role').val(data.role[0].name).trigger('change')
            $('#fecha_ingreso').val(data.detalle ? formatDateToDDMMYYYY(data.detalle.fecha_ingreso) : '');
            $('#dep_id').val(data.detalle ? data.detalle.dep_id : '').trigger('change')
            $('#des_id').val(data.detalle ? data.detalle.des_id : '').trigger('change')

            if (data.id == 1) {
                $('#role').attr('disabled', 'disabled');
                $('#dep_id').attr('disabled', 'disabled');
                $('#des_id').attr('disabled', 'disabled');
            }
        }

        function deleteUser() {
            const id = $('#usu_id').val()

            $.ajax({
                url: `{{ url('admin/usuarios') }}/${id}`,
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
