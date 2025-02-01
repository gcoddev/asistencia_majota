@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">
                        Gestión de asistencia
                        {{ Auth::user()->role[0]->name == 'admin' ? '(Administración)' : '(Empleado)' }}
                    </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Gestión de asistencias</li>
                    </ul>
                </div>
                <div>
                    {{-- <a href="#" class="btn-sm btn-success mr-3">
                        Generar CSV
                        &nbsp;<i class="fa fa-file-excel-o"></i>
                    </a> --}}
                    <a href="{{ route('admin.pdf.permisos') }}" target="_blank" class="btn-sm btn-danger mr-3">
                        Generar PDF
                        &nbsp;<i class="fa fa-file-pdf-o"></i>
                    </a>
                </div>
                @can('permiso.create')
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#modal_leave"
                            onclick="resetForm('Nuevo')">
                            <i class="fa fa-plus"></i> Nuevo permiso
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

        <!-- Leave Statistics -->
        {{-- <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Today Presents</h6>
                    <h4>12 / 60</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Planned Leaves</h6>
                    <h4>8 <span>Today</span></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Unplanned Leaves</h6>
                    <h4>0 <span>Today</span></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Pending Requests</h6>
                    <h4>12</h4>
                </div>
            </div>
        </div> --}}
        <!-- /Leave Statistics -->

        <!-- Search Filter -->
        {{-- <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option> -- Select -- </option>
                        <option>Casual Leave</option>
                        <option>Medical Leave</option>
                        <option>Loss of Pay</option>
                    </select>
                    <label class="focus-label">Leave Type</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option> -- Select -- </option>
                        <option> Pending </option>
                        <option> Approved </option>
                        <option> Rejected </option>
                    </select>
                    <label class="focus-label">Leave Estado</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div> --}}
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <caption>
                        <h2>Permisos</h2>
                    </caption>
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>Tipo</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Numero de Dias (hábiles)</th>
                                <th>Razones</th>
                                <th class="text-center">Estado</th>
                                <th>Aprobado/rechazado por</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $per)
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar">
                                                <img alt=""
                                                    src="{{ asset($per->detalle->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                            </a>
                                            <a href="#">
                                                {{ $per->detalle->usuario->nombres }}
                                                {{ $per->detalle->usuario->apellidos }}
                                                <span>
                                                    {{ $per->detalle->departamento ? $per->detalle->departamento->nombre : '- Sin departamento -' }}
                                                </span>
                                                <span>
                                                    {{ $per->detalle->designacion ? $per->detalle->designacion->nombre : '- Sin designación -' }}
                                                </span>
                                            </a>
                                        </h2>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-light">{{ $per->tipo }}</span>
                                    </td>
                                    <td>{{ fecha_literal($per->fecha_ini) }}</td>
                                    <td>{{ fecha_literal($per->fecha_fin) }}</td>
                                    <td class="text-center">{{ $per->dias }}</td>
                                    <td>{!! nl2br(e($per->razones)) !!}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role[0]->name == 'admin')
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded px-2 {{ $per->estado == 'pendiente' ? 'dropdown-toggle' : '' }}"
                                                    href="javascript:void(0)"
                                                    data-toggle="{{ $per->estado == 'pendiente' ? 'dropdown' : '' }}"
                                                    aria-expanded="false">
                                                    <i
                                                        class="fa fa-dot-circle-o
                                                    {{ $per->estado == 'aprobado' ? 'text-success' : ($per->estado == 'rechazado' ? 'text-danger' : 'text-info') }}"></i>
                                                    {{ $per->estado }}
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#approve_leave"
                                                        onclick="$('#per_id_estado').val({{ $per->id }});$('#per_estado').val('aprobado')">
                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                        Aprobar
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#decline_leave"
                                                        onclick="$('#per_id_estado').val({{ $per->id }});$('#per_estado').val('rechazado')">
                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                        Rechazar
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class=" action-label">
                                                <a class="btn btn-white btn-sm btn-rounded px-2" href="javascript:void(0)"
                                                    aria-expanded="false">
                                                    <i
                                                        class="fa fa-dot-circle-o
                                                {{ $per->estado == 'aprobado' ? 'text-success' : ($per->estado == 'rechazado' ? 'text-danger' : 'text-info') }}"></i>
                                                    {{ $per->estado }}
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($per->usuario)
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt=""
                                                        src="{{ asset($per->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                                </a>
                                                <a href="#">
                                                    {{ $per->usuario->nombres }}
                                                    {{ $per->usuario->apellidos }}
                                                    @if ($per->usuario->detalle)
                                                        <span>
                                                            {{ $per->usuario->departamento ? $per->usuario->departamento->nombre : '- Sin departamento -' }}
                                                        </span>
                                                        <span>
                                                            {{ $per->usuario->designacion ? $per->usuario->designacion->nombre : '- Sin designación -' }}
                                                        </span>
                                                    @endif
                                                </a>
                                            </h2>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($per->estado == 'pendiente')
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('permiso.edit')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#modal_leave" onclick="editPer({{ $per }})">
                                                            <i class="fa fa-pencil m-r-5"></i>
                                                            Editar
                                                        </a>
                                                    @endcan
                                                    @can('permiso.delete')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_approve"
                                                            onclick="$('#per_id').val({{ $per->id }})">
                                                            <i class="fa fa-trash-o m-r-5"></i>
                                                            Eliminar
                                                        </a>
                                                    @endcan
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
        <br>
        <hr><br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <caption>
                        <h2>Vacaciones</h2>
                    </caption>
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Empleado</th>
                                <th>Tipo</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Numero de Dias (hábiles)</th>
                                <th>Razones</th>
                                <th class="text-center">Estado</th>
                                <th>Aprobado/rechazado por</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vacaciones as $vac)
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar">
                                                <img alt=""
                                                    src="{{ asset($vac->detalle->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                            </a>
                                            <a href="#">
                                                {{ $vac->detalle->usuario->nombres }}
                                                {{ $vac->detalle->usuario->apellidos }}
                                                <span>
                                                    {{ $vac->detalle->departamento ? $vac->detalle->departamento->nombre : '- Sin departamento -' }}
                                                </span>
                                                <span>
                                                    {{ $vac->detalle->designacion ? $vac->detalle->designacion->nombre : '- Sin designación -' }}
                                                </span>
                                            </a>
                                        </h2>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-white">{{ $vac->tipo }}</span>
                                    </td>
                                    <td>{{ fecha_literal($vac->fecha_ini) }}</td>
                                    <td>{{ fecha_literal($vac->fecha_fin) }}</td>
                                    <td class="text-center">{{ $vac->dias }}</td>
                                    <td>{!! nl2br(e($vac->razones)) !!}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role[0]->name == 'admin')
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded px-2 {{ $vac->estado == 'pendiente' ? 'dropdown-toggle' : '' }}"
                                                    href="javascript:void(0)"
                                                    data-toggle="{{ $vac->estado == 'pendiente' ? 'dropdown' : '' }}"
                                                    aria-expanded="false">
                                                    <i
                                                        class="fa fa-dot-circle-o
                                                    {{ $vac->estado == 'aprobado' ? 'text-success' : ($vac->estado == 'rechazado' ? 'text-danger' : 'text-info') }}"></i>
                                                    {{ $vac->estado }}
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#approve_leave"
                                                        onclick="$('#per_id_estado').val({{ $vac->id }});$('#per_estado').val('aprobado')">
                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                        Aprobar
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#decline_leave"
                                                        onclick="$('#per_id_estado').val({{ $vac->id }});$('#per_estado').val('rechazado')">
                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                        Rechazar
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class=" action-label">
                                                <a class="btn btn-white btn-sm btn-rounded px-2" href="javascript:void(0)"
                                                    aria-expanded="false">
                                                    <i
                                                        class="fa fa-dot-circle-o
                                                {{ $vac->estado == 'aprobado' ? 'text-success' : ($vac->estado == 'rechazado' ? 'text-danger' : 'text-info') }}"></i>
                                                    {{ $vac->estado }}
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($vac->usuario)
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt=""
                                                        src="{{ asset($vac->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                                </a>
                                                <a href="#">
                                                    {{ $vac->usuario->nombres }}
                                                    {{ $vac->usuario->apellidos }}
                                                    @if ($vac->usuario)
                                                        <span>
                                                            {{ $vac->usuario->departamento ? $vac->usuario->departamento->nombre : '- Sin departamento -' }}
                                                        </span>
                                                        <span>
                                                            {{ $vac->usuario->designacion ? $vac->usuario->designacion->nombre : '- Sin designación -' }}
                                                        </span>
                                                    @endif
                                                </a>
                                            </h2>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (Auth::user()->can('permiso.delete') || Auth::user()->can('permiso.edit'))
                                            @if ($vac->estado == 'pendiente')
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"><i
                                                            class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @can('permiso.edit')
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#modal_leave"
                                                                onclick="editPer({{ $vac }})">
                                                                <i class="fa fa-pencil m-r-5"></i>
                                                                Editar
                                                            </a>
                                                        @endcan
                                                        @can('permiso.delete')
                                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                                data-target="#delete_approve"
                                                                onclick="$('#per_id').val({{ $vac->id }})">
                                                                <i class="fa fa-trash-o m-r-5"></i>
                                                                Eliminar
                                                            </a>
                                                        </div>
                                                    @endcan
                                                </div>
                                            @endif
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

    @if (Auth::user()->can('permiso.create') || Auth::user()->can('permiso.edit'))
        <!-- Add Leave Modal -->
        <div id="modal_leave" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-form"></span> permiso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('components.alerts')
                        <form id="form-permiso">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="usu_detalle_id" id="usu_detalle_id"
                                @if (Auth::user()->detalle) value="{{ Auth::user()->detalle->id }}" @endif>
                            <span class="invalid-feedback" id="usu_detalle_id_error"></span>
                            <div class="form-group">
                                <label>Tipo <span class="text-danger">*</span></label>
                                <select class="select" name="tipo" id="tipo">
                                    <option value="permiso">Permiso</option>
                                    <option value="vacacion">Vacación</option>
                                </select>
                                <span class="invalid-feedback" id="tipo_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Desde <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="fecha_ini"
                                        id="fecha_ini">
                                    <span class="invalid-feedback" id="fecha_ini_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Hasta <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="fecha_fin"
                                        id="fecha_fin">
                                    <span class="invalid-feedback" id="fecha_fin_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Numero de Dias (hábiles) <span class="text-danger">*</span></label>
                                <input class="form-control" readonly type="text" name="dias" id="dias">
                                <span class="invalid-feedback" id="dias_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Razón del permiso <span class="text-danger">*</span></label>
                                <textarea rows="4" class="form-control" name="razones" id="razones"></textarea>
                                <span class="invalid-feedback" id="razones_error"></span>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn" id="btn-form"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Leave Modal -->
    @endif

    @can('permiso.edit')
        <input type="hidden" name="per_id_estado" id="per_id_estado">
        <input type="hidden" name="per_estado" id="per_estado">
        <!-- Approve Leave Modal -->
        <div class="modal custom-modal fade" id="approve_leave" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Aprobar permiso</h3>
                            <p>¿Esta seguro de aprobar el permiso?</p>
                            <h5>Esta acción no se puede deshacer</h5>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn continue-btn btn-success" onclick="estadoPer()">
                                        Aprobar
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn cancel-btn btn-secondary">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Approve Leave Modal -->

        <!-- Decline Leave Modal -->
        <div class="modal custom-modal fade" id="decline_leave" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Rechazar permiso</h3>
                            <p>¿Esta seguro de rechazar el permiso?</p>
                            <h5>Esta acción no se puede deshacer</h5>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="estadoPer()">
                                        Rechazar
                                    </a>
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
        <!-- /Decline Leave Modal -->
    @endcan

    @can('permiso.delete')
        <!-- Delete Leave Modal -->
        <div class="modal custom-modal fade" id="delete_approve" role="dialog">
            <div class="modal-dialog modal-dialog-centered">z
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Eliminar permiso</h3>
                            <p>¿Esta seguro de eliminar el permiso?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="deletePer()">
                                        Eliminar
                                    </a>
                                    <input type="hidden" name="per_id" id="per_id">
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
        <!-- /Delete Leave Modal -->
    @endcan
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('dp.change', '#fecha_ini, #fecha_fin', function() {
                calcularDiasHabiles();
            });

            $('#form-permiso').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                }

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                const url = id ?
                    `{{ url('admin/permisos') }}/${id}` :
                    '{{ route('admin.permisos.store') }}';

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
            $('#btn-form').addClass(`btn btn-${title == 'Nuevo' ? 'success' : 'warning'}`);
            $('#btn-form').html(title == 'Nuevo' ? 'Nuevo' : 'Actualizar')

            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            $('#form-permiso').trigger('reset')
            $('#tipo').val('permiso').trigger('change')
        }

        function editPer(data) {
            resetForm('Editar')

            $('#id').val(data.id)
            $('#usu_detalle_id').val(data.usu_detalle_id)
            $('#tipo').val(data.tipo).trigger('change')
            $('#fecha_ini').val(formatDateToDDMMYYYY(data.fecha_ini));
            $('#fecha_fin').val(formatDateToDDMMYYYY(data.fecha_fin));
            $('#dias').val(data.dias)
            $('#razones').val(data.razones)
        }

        function deletePer() {
            const id = $('#per_id').val()

            $.ajax({
                url: `{{ url('admin/permisos') }}/${id}`,
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

        function estadoPer() {
            id = $('#per_id_estado').val();
            estado = $('#per_estado').val();

            $.ajax({
                url: `{{ url('admin/permisos') }}/${id}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    estado: estado
                },
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(err) {
                    console.log(err);

                    alert('Error al actualizar.');
                }
            });
        }

        function calcularDiasHabiles() {
            const fechaInicio = $('#fecha_ini').val();
            const fechaFin = $('#fecha_fin').val();

            if (fechaInicio) {
                $('#fecha_fin').attr('min', fechaInicio);
            }

            if (fechaInicio && fechaFin) {
                let inicio = moment(fechaInicio, "DD/MM/YYYY");
                let fin = moment(fechaFin, "DD/MM/YYYY");
                let diasHabiles = 0;

                while (inicio <= fin) {
                    if (inicio.isoWeekday() !== 6 && inicio.isoWeekday() !== 7) {
                        diasHabiles++;
                    }
                    inicio.add(1, 'days');
                }

                if (diasHabiles > 0) {
                    $('#dias').removeClass('is-invalid');
                    $('#dias').val(diasHabiles);
                    $('#dias_error').html('')
                } else {
                    $('#dias').val(0);
                    $('#dias').addClass('is-invalid');
                    $('#dias_error').html('El rango de fechas es invalida')
                }
            }
        }
    </script>
@endpush
