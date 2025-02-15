@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Departamentos</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Departamentos</li>
                    </ul>
                </div>
                @can('departamento.create')
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#modal_departamento"
                            onclick="resetForm('Agregar')">
                            <i class="fa fa-plus"></i> Agregar departamento
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

        <div class="row">
            <div class="col-md-12">
                <div>
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th>Nombre departamento</th>
                                <th>Descripción</th>
                                <th>Horario</th>
                                <th>Coordenadas</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departamentos as $dep)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dep->nombre }}</td>
                                    <td>{!! nl2br(e($dep->descripcion)) !!}</td>
                                    <td>{{ $dep->hora_ini }} - {{ $dep->hora_fin }}</td>
                                    <td>
                                        @if ($dep->latitud && $dep->longitud)
                                            <a href="https://www.google.com/maps?q={{ $dep->latitud }},{{ $dep->longitud }}&hl=es&z=15"
                                                target="_blank">
                                                {{ $dep->latitud }}, {{ $dep->longitud }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (Auth::user()->can('departamento.delete') || Auth::user()->can('designacion.edit'))
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('departamento.edit')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#modal_departamento"
                                                            onclick="editDep({{ $dep }})">
                                                            <i class="fa fa-pencil m-r-5"></i>
                                                            Editar
                                                        </a>
                                                    @endcan
                                                    @can('departamento.delete')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_department"
                                                            onclick="$('#dep_id').val({{ $dep->id }})">
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
    </div>
    <!-- /Page Content -->

    @if (Auth::user()->can('departamento.create') || Auth::user()->can('departamento.edit'))
        <!-- Add Department Modal -->
        <div id="modal_departamento" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-form"></span> departamento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-departamento" class="row">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="form-group col-12">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="nombre" id="nombre">
                                <span class="invalid-feedback" id="nombre_error"></span>
                            </div>
                            <div class="form-group col-12">
                                <label>Descripción</label>
                                <input class="form-control" type="text" name="descripcion" id="descripcion">
                                <span class="invalid-feedback" id="descripcion_error"></span>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Hora de entrada <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="hora_ini" id="hora_ini"
                                        value="08:00:00">
                                    <span class="invalid-feedback" id="hora_ini_error"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Hora de salida <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="hora_fin" id="hora_fin"
                                        value="18:00:00">
                                    <span class="invalid-feedback" id="hora_fin_error"></span>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-md-6 col-12">
                                <label>Latitud</label>
                                <input class="form-control" type="text" name="latitud" id="latitud">
                                <span class="invalid-feedback" id="latitud_error"></span>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Longitud</label>
                                <input class="form-control" type="text" name="longitud" id="longitud">
                                <span class="invalid-feedback" id="longitud_error"></span>
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

    @can('departamento.delete')
        <!-- Delete Department Modal -->
        <div class="modal custom-modal fade" id="delete_department" role="dialog">
            <div class="modal-dialog modal-dialog-centered">z
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Eliminar departamento</h3>
                            <p>¿Esta seguro de eliminar el departamento?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="deleteDep()">
                                        Eliminar
                                    </a>
                                    <input type="hidden" name="dep_id" id="dep_id">
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
        $('.datetimepicker').datetimepicker({
            format: 'HH:mm:ss'
        })
        $(document).ready(function() {

            $('#form-departamento').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                }

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                const url = id ?
                    `{{ url('admin/departamentos') }}/${id}` :
                    '{{ route('admin.departamentos.store') }}';

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

            $('#form-departamento').trigger('reset')
        }

        function editDep(data) {
            resetForm('Editar')

            $('#id').val(data.id)
            $('#nombre').val(data.nombre)
            $('#descripcion').val(data.descripcion)
            $('#hora_ini').val(data.hora_ini)
            $('#hora_fin').val(data.hora_fin)
            $('#latitud').val(data.latitud)
            $('#longitud').val(data.longitud)
        }

        function deleteDep() {
            const id = $('#dep_id').val()

            $.ajax({
                url: `{{ url('admin/departamentos') }}/${id}`,
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
