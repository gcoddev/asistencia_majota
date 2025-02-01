@extends('layout')

@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Nomina de sueldos</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Panel</a></li>
                        <li class="breadcrumb-item active">Nomina de sueldos</li>
                    </ul>
                </div>
                <div>
                    {{-- <a href="#" class="btn-sm btn-success mr-3">
                        Generar CSV
                        &nbsp;<i class="fa fa-file-excel-o"></i>
                    </a> --}}
                    <a href="{{ route('admin.pdf.sueldos') }}" target="_blank" class="btn-sm btn-danger mr-3">
                        Generar PDF
                        &nbsp;<i class="fa fa-file-pdf-o"></i>
                    </a>
                </div>
                @can('sueldo.create')
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#modal_salary"
                            onclick="resetForm('Agregar')">
                            <i class="fa fa-plus"></i> Agregar salario
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

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
                        <option value=""> -- Select -- </option>
                        <option value="">Employee</option>
                        <option value="1">Manager</option>
                    </select>
                    <label class="focus-label">Role</label>
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
                    <label class="focus-label">Leave Status</label>
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
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Empleado</th>
                                <th>Rol</th>
                                <th>Compensaciones</th>
                                <th>Deducciones</th>
                                <th>Sueldo total</th>
                                <th>Tipo</th>
                                <th>Recibo</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sueldos as $sueldo)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ route('admin.perfil.show', 1) }}" class="avatar">
                                                <img alt=""
                                                    src="{{ asset($sueldo->empleado->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                            </a>
                                            <a href="{{ route('admin.perfil.show', 1) }}">
                                                {{ $sueldo->empleado->usuario->nombres }}
                                                {{ $sueldo->empleado->usuario->apellidos }}
                                                <span>
                                                    {{ $sueldo->empleado->designacion ? $sueldo->empleado->designacion->nombre : '- Sin designación -' }}
                                                </span>
                                            </a>
                                        </h2>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="javascript:void(0)" class="btn btn-white btn-sm btn-rounded">
                                                {{ $sueldo->empleado->usuario->role[0]->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($sueldo->use_compensaciones)
                                            <ul class="list-unstyled">
                                                @foreach ($sueldo->compensaciones as $item)
                                                    <li>
                                                        <b>+ Bs. {{ $item->item->monto }}</b>
                                                        {{ $item->item->nombre }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($sueldo->use_deducciones)
                                            <ul class="list-unstyled">
                                                @foreach ($sueldo->deducciones as $item)
                                                    <li>
                                                        <b>- Bs. {{ $item->item->monto }}</b>
                                                        {{ $item->item->nombre }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>Bs. {{ $sueldo->salario_total }}</td>
                                    <td>{{ $sueldo->tipo }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary"
                                            href="{{ route('admin.sueldos.show', $sueldo->id) }}">
                                            Generar recibo
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        @if (Auth::user()->can('sueldo.edit') || Auth::user()->can('sueldo.delete'))
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @can('sueldo.edit')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#modal_salary" onclick="editSu({{ $sueldo }})">
                                                            <i class="fa fa-pencil m-r-5"></i> Editar
                                                        </a>
                                                    @endcan
                                                    @can('sueldo.delete')
                                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                                            data-target="#delete_salary"
                                                            onclick="$('#sue_id').val({{ $sueldo->id }})">
                                                            <i class="fa fa-trash-o m-r-5"></i> Eliminar
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

    @if (Auth::user()->can('sueldo.create') || Auth::user()->can('sueldo.edit'))
        <!-- Add Salary Modal -->
        <div id="modal_salary" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="title-form"></span> salario al personal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-sueldo">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group status-toggle">
                                        <label>Seleccionar empleado</label>
                                        <select class="select form-control" name="usu_detalle_id" id="usu_detalle_id">
                                            <option value="">-</option>
                                            @foreach ($empleados as $emp)
                                                <option value="{{ $emp->id }}" data-salario="{{ $emp->salario }}"
                                                    data-compensaciones="{{ $emp->compensaciones }}"
                                                    data-deducciones="{{ $emp->deducciones }}">
                                                    {{ $emp->usuario->nombres }}
                                                    {{ $emp->usuario->apellidos }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback" id="usu_detalle_id_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Base salarial <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="tipo" id="tipo" readonly>
                                    <span class="invalid-feedback" id="tipo_error"></span>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Sueldo base <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="salario_neto" id="salario_neto"
                                        readonly>
                                    <span class="invalid-feedback" id="salario_neto_error"></span>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><span id="title-cantidad">Cantidad</span> <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="cantidad" id="cantidad"
                                            min="1">
                                        <span class="invalid-feedback" id="cantidad_error"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Sueldo total <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="salario_total" id="salario_total"
                                        readonly>
                                    <span class="invalid-feedback" id="salario_total_error"></span>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Fecha recibo <span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" name="fecha_recibo"
                                            id="fecha_recibo">
                                        <span class="invalid-feedback" id="fecha_recibo_error"></span>
                                    </div>
                                </div>
                                <div class="col-12 alert alert-warning" role="alert" id="edit-alert">
                                    <strong>Nota: </strong>Al editar se agregan las nuevas compensaciones y deducciones no
                                    registradas al salario total.
                                </div>
                                <div class="col-sm-6 row items" style="display:none">
                                    <div class="status-toggle col-12">
                                        <label class="col-form-label">
                                            Usar compensaciones
                                        </label>
                                        <input class="form-control check" type="checkbox" id="use_compensaciones"
                                            name="use_compensaciones">
                                        <label for="use_compensaciones" class="checktoggle">checkbox</label>
                                    </div>
                                    <div class="col-12 mx-3 row" id="compensaciones" style="display:none">
                                    </div>
                                </div>
                                <div class="col-sm-6 row items" style="display:none">
                                    <div class="status-toggle col-12">
                                        <label class="col-form-label">
                                            Usar deducciones
                                        </label>
                                        <input class="form-control check" type="checkbox" id="use_deducciones"
                                            name="use_deducciones">
                                        <label for="use_deducciones" class="checktoggle">checkbox</label>
                                    </div>
                                    <div class="col-12 mx-3 row" id="deducciones" style="display:none">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" id="btn-form"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Salary Modal -->
    @endif

    @can('sueldo.delete')
        <!-- Delete Salary Modal -->
        <div class="modal custom-modal fade" id="delete_salary" role="dialog">
            <div class="modal-dialog modal-dialog-centered">z
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Eliminar sueldo</h3>
                            <p>¿Esta seguro de eliminar el sueldo?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="deleteSu()">
                                        Eliminar
                                    </a>
                                    <input type="hidden" name="sue_id" id="sue_id">
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
        <!-- /Delete Salary Modal -->
    @endcan
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#usu_detalle_id').on('change', function() {
                const select = $(this).find(':selected');
                const salario = select.data('salario');

                if (select.val()) {
                    if (salario) {
                        $('#tipo').val(salario.base)
                        $('#salario_total').removeClass('is-invalid');
                        $('#salario_total_error').text('');

                        $('#salario_neto').val(salario.salario_base)
                        $('#salario_total').val(salario.salario_base)
                        switch (salario.base) {
                            case "Horas":
                                $('#title-cantidad').text('Cantidad de horas');
                                break
                            case "Diario":
                                $('#title-cantidad').text('Cantidad de días');
                                break
                            case "Semanal":
                                $('#title-cantidad').text('Cantidad de semanas');
                                break
                            case "Mensual":
                                $('#title-cantidad').text('Cantidad de meses');
                                break
                        }
                        $('#cantidad').val(1)
                        $('.items').css('display', 'block');

                        fillItems()
                    } else {
                        $('#tipo').val('')
                        $('#salario_total').addClass('is-invalid');
                        $('#salario_total_error').text('Empleado no tiene información de salario');

                        $('#salario_neto').val('')
                        $('#salario_total').val('')
                        $('.items').css('display', 'none');
                    }
                } else {
                    $('#tipo').val('')
                    $('#salario_total').removeClass('is-invalid');
                    $('#salario_total_error').text('');

                    $('#salario_neto').val('')
                    $('#salario_total').val('')
                    $('.items').css('display', 'none');
                }
            })

            $('#cantidad').on('change', function() {
                const cantidad = $(this).val();
                const salario = $('#salario_neto').val();

                if (salario && cantidad) {
                    $('#salario_total').val(parseFloat(salario) * cantidad);
                }
            })

            $('#use_compensaciones').on('change', function() {
                const salario = $('#salario_total').val();
                const compensaciones = $('#compensaciones').attr('data-compensaciones') ? JSON.parse($(
                    '#compensaciones').attr('data-compensaciones')) : []
                const editable = $('#compensaciones').attr('data-edit');

                if (compensaciones.length > 0) {
                    let suma = 0;
                    if ($(this).is(':checked')) {
                        compensaciones.forEach(item => {
                            suma += parseFloat(item.monto);
                        });
                        $('#salario_total').val(parseFloat(salario) + suma);
                        $('#compensaciones').css('display', 'block')
                    } else if (editable === 'editar') {
                        // No restar nada al no tener el check iniciado al editar
                    } else {
                        compensaciones.forEach(item => {
                            suma += parseFloat(item.monto);
                        });
                        $('#salario_total').val(parseFloat(salario) - suma);
                        $('#compensaciones').css('display', 'none')
                    }
                } else {
                    if ($(this).is(':checked')) {
                        $('#compensaciones').css('display', 'block')
                    } else {
                        $('#compensaciones').css('display', 'none')
                    }
                }
                $('#compensaciones').removeAttr('data-edit')
            })

            $('#use_deducciones').on('change', function() {
                const salario = $('#salario_total').val();
                const deducciones = $('#deducciones').attr('data-deducciones') ? JSON.parse($(
                    '#deducciones').attr('data-deducciones')) : []
                const editable = $('#deducciones').attr('data-edit');

                if (deducciones.length > 0) {
                    let suma = 0;
                    if ($(this).is(':checked')) {
                        deducciones.forEach(item => {
                            suma += parseFloat(item.monto);
                        });
                        $('#salario_total').val(parseFloat(salario) + suma);
                        $('#deducciones').css('display', 'block')
                    } else if (editable === 'editar') {
                        // No restar nada al no tener el check iniciado al editar
                    } else {
                        deducciones.forEach(item => {
                            suma += parseFloat(item.monto);
                        });
                        $('#salario_total').val(parseFloat(salario) - suma);
                        $('#deducciones').css('display', 'none')

                        $('#cantidad').removeAttr('readonly');
                    }
                } else {
                    if ($(this).is(':checked')) {
                        $('#deducciones').css('display', 'block')
                    } else {
                        $('#deducciones').css('display', 'none')
                    }
                }
                $('#deducciones').removeAttr('data-edit')
            })

            $('#use_compensaciones, #use_deducciones').on('change', function() {
                if ($('#use_compensaciones').is(':checked') || $('#use_deducciones').is(':checked')) {
                    $('#cantidad').attr('readonly', 'readonly')
                } else {
                    $('#cantidad').removeAttr('readonly')
                }
            })

            $('#form-sueldo').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#id').val();
                if (id != '') {
                    formData.append('_method', 'PUT');
                }

                $('.invalid-feedback').text('');
                $('.form-control').removeClass('is-invalid');

                // Mostrar formData
                // for (let pair of formData.entries()) {
                //     console.log(pair[0] + ': ' + pair[1]);
                // }

                const url = id ?
                    `{{ url('admin/sueldos') }}/${id}` :
                    '{{ route('admin.sueldos.store') }}';

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
            $('#edit-alert').css('display', 'none');
            $('#title-form').html(title)
            $('#btn-form').removeClass(function(index, className) {
                return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
            });
            $('#btn-form').addClass(`btn btn-${title == 'Agregar' ? 'success' : 'warning'}`);
            $('#btn-form').html(title == 'Agregar' ? 'Agregar' : 'Actualizar')

            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            $('#compensaciones').css('display', 'none');
            $('#deducciones').css('display', 'none');

            $('#usu_detalle_id').removeAttr('disabled');
            $('#cantidad').removeAttr('readonly');

            $('#usu_detalle_id').val('').trigger('change');
            $('#form-sueldo').trigger('reset')
        }

        function editSu(data) {
            resetForm('Editar')
            $('#edit-alert').css('display', 'block');

            $('#id').val(data.id)
            $('#usu_detalle_id').val(data.usu_detalle_id).trigger('change')
            $('#usu_detalle_id').attr('disabled', 'disabled');
            $('#use_compensaciones').prop('checked', data.use_compensaciones).trigger('change');
            $('#use_deducciones').prop('checked', data.use_deducciones).trigger('change');
            $('#usu_detalle_id').trigger('change')
            $('#compensaciones').attr('data-edit', 'editar')
            $('#use_compensaciones').attr('data-edit', true).trigger('change');
            $('#deducciones').attr('data-edit', 'editar')
            $('#use_deducciones').trigger('change');
            // fillItems()
            // $('#salario_neto').val(data.salario_neto)
            // $('#salario_total').val(data.salario_total)
            $('#fecha_recibo').val(formatDateToDDMMYYYY(data.fecha_recibo));
            $('#tipo').val(data.tipo)
            $('#cantidad').val(data.cantidad)
        }

        function deleteSu() {
            const id = $('#sue_id').val()

            $.ajax({
                url: `{{ url('admin/sueldos') }}/${id}`,
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

        function fillItems() {
            const select = $('#usu_detalle_id').find(':selected');
            const id = $('#id').val()
            const use_com = $('#use_compensaciones').is(':checked')
            const use_ded = $('#use_deducciones').is(':checked')

            const compensaciones = select.data('compensaciones');
            $('#compensaciones').empty()
            if (compensaciones && compensaciones.length > 0) {
                const compen = [];
                compensaciones.forEach(item => {
                    const existe = item.items.some(obj => obj.recibo_id == id);
                    if (use_com && (existe || item.use == 0)) {
                        $('#compensaciones').append(`<div class="form-group mt-3 row">
                            <input type="hidden" name="compensaciones[]" value="${item.id}">
                            <input type="text" class="col-6 form-control" readonly
                                value="${item.nombre}">
                            <div class="input-group col-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bs</span>
                                </div>
                                <input type="text" class="form-control" readonly value="+${item.monto}">
                            </div>
                        </div>`)
                        compen.push(item)
                    } else if (!use_com && item.use == 0) {
                        $('#compensaciones').append(`<div class="form-group mt-3 row">
                            <input type="hidden" name="compensaciones[]" value="${item.id}">
                            <input type="text" class="col-6 form-control" readonly
                                value="${item.nombre}">
                            <div class="input-group col-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bs</span>
                                </div>
                                <input type="text" class="form-control" readonly value="+${item.monto}">
                            </div>
                        </div>`)
                        compen.push(item)
                    }
                });
                $('#compensaciones').attr('data-compensaciones', JSON.stringify(compen))
            }
            if ($('#compensaciones').children().length < 1) {
                $('#compensaciones').append('<div class="form-group mt-3 text-center">Sin compensaciones</div>')
            }
            const deducciones = select.data('deducciones');
            $('#deducciones').empty()
            if (deducciones && deducciones.length > 0) {
                const compen = [];
                deducciones.forEach(item => {
                    const existe = item.items.some(obj => obj.recibo_id == id);
                    if (use_com && (existe || item.use == 0)) {
                        $('#deducciones').append(`<div class="form-group mt-3 row">
                            <input type="hidden" name="deducciones[]" value="${item.id}">
                            <input type="text" class="col-6 form-control" readonly
                                value="${item.nombre}">
                            <div class="input-group col-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bs</span>
                                </div>
                                <input type="text" class="form-control" readonly value="+${item.monto}">
                            </div>
                        </div>`)
                        compen.push(item)
                    } else if (!use_com && item.use == 0) {
                        $('#deducciones').append(`<div class="form-group mt-3 row">
                            <input type="hidden" name="deducciones[]" value="${item.id}">
                            <input type="text" class="col-6 form-control" readonly
                                value="${item.nombre}">
                            <div class="input-group col-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bs</span>
                                </div>
                                <input type="text" class="form-control" readonly value="+${item.monto}">
                            </div>
                        </div>`)
                        compen.push(item)
                    }
                });
                $('#deducciones').attr('data-deducciones', JSON.stringify(compen))
            }
            if ($('#deducciones').children().length < 1) {
                $('#deducciones').append('<div class="form-group mt-3 text-center">Sin deducciones</div>')
            }
        }
    </script>
@endpush
