@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Descuentos</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Descuentos</li>
                    </ul>
                </div>
                @can('deduccion.create')
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#modal_descuento"
                            onclick="resetForm('Nuevo')">
                            <i class="fa fa-plus"></i> Agregar descuento
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

        <!-- Overtime Statistics -->
        {{-- <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stats-info">
                    <h6>Overtime Employee</h6>
                    <h4>12 <span>this month</span></h4>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stats-info">
                    <h6>Overtime Hours</h6>
                    <h4>118 <span>this month</span></h4>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stats-info">
                    <h6>Pending Request</h6>
                    <h4>23</h4>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stats-info">
                    <h6>Rejected</h6>
                    <h4>5</h4>
                </div>
            </div>
        </div> --}}
        <!-- /Overtime Statistics -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Empleado</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th class="text-center">Horas</th>
                                <th class="text-center">Monto</th>
                                <th>Descripción</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($descuentos as $des)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar">
                                                <img alt=""
                                                    src="{{ asset($des->detalle->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                            </a>
                                            <a href="#">
                                                {{ $des->detalle->usuario->nombres }}
                                                {{ $des->detalle->usuario->apellidos }}
                                                <span>
                                                    {{ $des->detalle->departamento ? $des->detalle->departamento->nombre : '- Sin departamento -' }}
                                                </span>
                                                <span>
                                                    {{ $des->detalle->designacion ? $des->detalle->designacion->nombre : '- Sin designación -' }}
                                                </span>
                                            </a>
                                        </h2>
                                    </td>
                                    <td>{{ $des->nombre }}</td>
                                    <td>{{ fecha_literal($des->fecha) }}</td>
                                    <td class="text-center">{{ $des->horas }}</td>
                                    <td class="text-center">{{ $des->monto }}</td>
                                    <td>{!! nl2br(e($des->descripcion)) !!}</td>
                                    <td class="text-right">
                                        @if (Auth::user()->can('deduccion.edit') || Auth::user()->can('deduccion.delete'))
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('deduccion.edit')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#modal_descuento"
                                                            onclick="editDes({{ $des }})">
                                                            <i class="fa fa-pencil m-r-5"></i>
                                                            Editar
                                                        </a>
                                                    @endcan
                                                    @can('deduccion.delete')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_overtime"
                                                            onclick="$('#des_id').val({{ $des->id }})">
                                                            <i class="fa fa-trash-o m-r-5"></i>
                                                            Eliminar
                                                        </a>
                                                    </div>
                                                @endcan
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

    @if (Auth::user()->can('deduccion.create') || Auth::user()->can('deduccion.edit'))
        <!-- Add Overtime Modal -->
        <div id="modal_descuento" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-form"></span> descuento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-descuento">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Seleccionar empleado <span class="text-danger">*</span></label>
                                <select class="select form-control" name="usu_detalle_id" id="usu_detalle_id">
                                    <option value="">-</option>
                                    @foreach ($empleados as $emp)
                                        <option value="{{ $emp->id }}">
                                            {{ $emp->usuario->nombres }}
                                            {{ $emp->usuario->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" id="usu_detalle_id_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="nombre" id="nombre">
                                <span class="invalid-feedback" id="nombre_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Fecha <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="fecha" id="fecha">
                                    <span class="invalid-feedback" id="fecha_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Horas <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="horas" id="horas">
                                <span class="invalid-feedback" id="horas_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Monto <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="monto" id="monto">
                                <span class="invalid-feedback" id="monto_error"></span>
                            </div>
                            <div class="form-group">
                                <label>Descripción <span class="text-danger">*</span></label>
                                <textarea rows="4" class="form-control" name="descripcion" id="descripcion"></textarea>
                                <span class="invalid-feedback" id="descripcion_error"></span>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" id="btn-form"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Overtime Modal -->
    @endif

    @can('deduccion.delete')
        <!-- Delete Overtime Modal -->
        <div class="modal custom-modal fade" id="delete_overtime" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Eliminar descuento</h3>
                            <p>¿Esta seguro de eliminar el descuento?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="deleteDes()">
                                        Eliminar
                                    </a>
                                    <input type="hidden" name="des_id" id="des_id">
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
        <!-- /Delete Overtime Modal -->
    @endcan
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#form-descuento').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                }

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                const url = id ?
                    `{{ url('admin/deducciones') }}/${id}` :
                    '{{ route('admin.deducciones.store') }}';

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

            $('#form-descuento').trigger('reset')
            $('#usu_detalle_id').val('').trigger('change')
        }

        function editDes(data) {
            resetForm('Editar')

            $('#id').val(data.id)
            $('#usu_detalle_id').val(data.usu_detalle_id).trigger('change')
            $('#nombre').val(data.nombre)
            $('#descripcion').val(data.descripcion)
            $('#fecha').val(formatDateToDDMMYYYY(data.fecha))
            $('#horas').val(data.horas)
            $('#monto').val(data.monto)
        }

        function deleteDes() {
            const id = $('#des_id').val()

            $.ajax({
                url: `{{ url('admin/deducciones') }}/${id}`,
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
