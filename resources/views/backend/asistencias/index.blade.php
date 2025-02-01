@extends('layout')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-md-8 col-12">
                    <h3 class="page-title">Asistencias</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('inicio') }}">Panel</a>
                        </li>
                        <li class="breadcrumb-item active">Asistencias</li>
                    </ul>
                </div>
                <div class="col-md-4 col-12">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa fa-check text-success"></i>
                            Asiste
                        </div>
                        <div class="col-6">
                            <i class="fa fa-close text-danger"></i>
                            Falta
                        </div>
                        <div class="col-6">
                            <i class="fa fa-check text-info"></i>
                            Atraso
                        </div>
                        <div class="col-6">
                            <i class="fa fa-info text-warning"></i>
                            Observación
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        @include('components.alerts')

        <!-- Search Filter -->
        <form class="row filter-row" action="{{ route('admin.asistencias.index') }}" method="GET">
            <div class="col-sm-12 col-md-3">
                @if (Auth::user()->role[0]->name == 'admin')
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="usu_detalle_id">
                            <option value="">-</option>
                            @foreach ($empleados as $em)
                                <option value="{{ $em->id }}" {{ $em->id == $usu_detalle_id ? 'selected' : '' }}>
                                    {{ $em->usuario->nombres }}
                                    {{ $em->usuario->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        <label class="focus-label">Nombre de empleado</label>
                    </div>
                @endif
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="mes">
                        <option value="">-</option>
                        <option value="1" {{ $mes == 1 ? 'selected' : '' }}>Enero</option>
                        <option value="2" {{ $mes == 2 ? 'selected' : '' }}>Febrero</option>
                        <option value="3" {{ $mes == 3 ? 'selected' : '' }}>Marzo</option>
                        <option value="4" {{ $mes == 4 ? 'selected' : '' }}>Abril</option>
                        <option value="5" {{ $mes == 5 ? 'selected' : '' }}>Mayo</option>
                        <option value="6" {{ $mes == 6 ? 'selected' : '' }}>Junio</option>
                        <option value="7" {{ $mes == 7 ? 'selected' : '' }}>Julio</option>
                        <option value="8" {{ $mes == 8 ? 'selected' : '' }}>Agosto</option>
                        <option value="9" {{ $mes == 9 ? 'selected' : '' }}>Septiembre</option>
                        <option value="10" {{ $mes == 10 ? 'selected' : '' }}>Octubre</option>
                        <option value="11" {{ $mes == 11 ? 'selected' : '' }}>Noviembre</option>
                        <option value="12" {{ $mes == 12 ? 'selected' : '' }}>Diciembre</option>
                    </select>
                    <label class="focus-label">Seleccionar mes</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="anio">
                        <option>-</option>
                        @for ($i = $oldYear; $i <= $latestYear; $i++)
                            <option value="{{ $i }}" {{ $i == $anio ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <label class="focus-label">Seleccionar año</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <button type="submit" class="btn btn-success btn-block"> Buscar </button>
            </div>
            <div class="col-sm-6 col-md-2">
                <a href="{{ route('admin.asistencias.index') }}" class="btn btn-secondary btn-block"> Reset </a>
            </div>
        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Empleado</th>
                                @foreach ($diasDelMes as $dia)
                                    <th>{{ $dia }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $emp)
                                @if ($usu_detalle_id == '' || $usu_detalle_id == $emp->id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a class="avatar avatar-xs"
                                                    href="{{ route('admin.perfil.show', $emp->usu_id) }}">
                                                    <img alt=""
                                                        src="{{ asset($emp->usuario->imagen ?? 'assets/img/user.jpg') }}">
                                                </a>
                                                <a href="{{ route('admin.perfil.show', $emp->usu_id) }}">
                                                    {{ $emp->usuario->nombres }}
                                                    {{ $emp->usuario->apellidos }}
                                                </a>
                                            </h2>
                                        </td>
                                        @foreach ($diasDelMes as $dia)
                                            @php
                                                $fecha =
                                                    $anio .
                                                    '-' .
                                                    str_pad($mes, 2, '0', STR_PAD_LEFT) .
                                                    '-' .
                                                    str_pad($dia, 2, '0', STR_PAD_LEFT);
                                            @endphp
                                            @if ($emp->buscarAsistencia($dia, $mes, $anio))
                                                @php
                                                    $ini = $emp->buscarAsistencia($dia, $mes, $anio)->asistencias[0]
                                                        ->hora_ini;
                                                    $fin = $emp->buscarAsistencia($dia, $mes, $anio)->asistencias[0]
                                                        ->hora_fin;
                                                    $estado = $emp->buscarAsistencia($dia, $mes, $anio)->asistencias[0]
                                                        ->estado;
                                                    // foreach (
                                                    //     $emp
                                                    //         ->buscarAsistencia($dia, $mes, $anio)
                                                    //         ->asistencias->reverse()
                                                    //     as $asis
                                                    // ) {
                                                    //     if ($asis->hora_fin) {
                                                    //         $fin = $asis->hora_fin;
                                                    //         break;
                                                    //     }
                                                    // }
                                                @endphp
                                                @if ($ini <= $emp->departamento->hora_ini && $fin >= $emp->departamento->hora_fin)
                                                    <td>
                                                        <a href="javascript:void(0);" data-toggle="modal"
                                                            data-target="#attendance_info_{{ $dia }}{{ $emp->id }}"
                                                            class="asis-info" data-ini="{{ $ini }}"
                                                            data-fin="{{ $fin }}"
                                                            data-id="{{ $dia }}{{ $emp->id }}"
                                                            data-date="{{ $anio }}-{{ $mes }}-{{ $dia }}"
                                                            title="Asiste">
                                                            <i class="fa fa-check text-success"></i>
                                                        </a>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="half-day">
                                                            @if ($ini <= $emp->departamento->hora_ini)
                                                                <span class="first-off"><a href="javascript:void(0);"
                                                                        data-toggle="modal"
                                                                        data-target="#attendance_info_{{ $dia }}{{ $emp->id }}"
                                                                        class="asis-info" data-ini="{{ $ini }}"
                                                                        data-fin="{{ $fin }}"
                                                                        data-id="{{ $dia }}{{ $emp->id }}"
                                                                        data-date="{{ $anio }}-{{ $mes }}-{{ $dia }}"
                                                                        title="Asiste"><i
                                                                            class="fa fa-check text-success"></i></a></span>
                                                            @else
                                                                <span class="first-off"><a href="javascript:void(0);"
                                                                        data-toggle="modal"
                                                                        data-target="#attendance_info_{{ $dia }}{{ $emp->id }}"
                                                                        class="asis-info" data-ini="{{ $ini }}"
                                                                        data-fin="{{ $fin }}"
                                                                        data-id="{{ $dia }}{{ $emp->id }}"
                                                                        data-date="{{ $anio }}-{{ $mes }}-{{ $dia }}"
                                                                        title="Atraso"><i
                                                                            class="fa fa-check text-info"></i></a></span>
                                                            @endif
                                                            @if ($fin)
                                                                @if ($fin >= $emp->departamento->hora_fin)
                                                                    <span class="first-off"><a href="javascript:void(0);"
                                                                            data-toggle="modal"
                                                                            data-target="#attendance_info_{{ $dia }}{{ $emp->id }}"
                                                                            class="asis-info"
                                                                            data-ini="{{ $ini }}"
                                                                            data-fin="{{ $fin }}"
                                                                            data-id="{{ $dia }}{{ $emp->id }}"
                                                                            data-date="{{ $anio }}-{{ $mes }}-{{ $dia }}"
                                                                            title="Asiste"><i
                                                                                class="fa fa-check text-success"></i></a></span>
                                                                @else
                                                                    <span class="first-off"><a href="javascript:void(0);"
                                                                            data-toggle="modal"
                                                                            data-target="#attendance_info_{{ $dia }}{{ $emp->id }}"
                                                                            class="asis-info"
                                                                            data-ini="{{ $ini }}"
                                                                            data-fin="{{ $fin }}"
                                                                            data-id="{{ $dia }}{{ $emp->id }}"
                                                                            data-date="{{ $anio }}-{{ $mes }}-{{ $dia }}"
                                                                            title="Observación"><i
                                                                                class="fa fa-info text-warning"></i></a></span>
                                                                @endif
                                                            @else
                                                                @if (date('Y-m-d') != $fecha)
                                                                    <span class="first-off"><a href="javascript:void(0);"
                                                                            data-toggle="modal"
                                                                            data-target="#attendance_info_{{ $dia }}{{ $emp->id }}"
                                                                            class="asis-info"
                                                                            data-ini="{{ $ini }}"
                                                                            data-fin="{{ $fin }}"
                                                                            data-id="{{ $dia }}{{ $emp->id }}"
                                                                            data-date="{{ $anio }}-{{ $mes }}-{{ $dia }}"
                                                                            title="Observación"><i
                                                                                class="fa fa-close text-{{ $estado === null ? 'warning' : ($estado === 1 ? 'info' : 'danger') }}"></i></a></span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                            <a href="javascript:void(0);" data-toggle="modal"
                                                                data-target="#attendance_info_{{$dia}}{{$mes}}{{$anio}}"
                                                                title="Atraso">
                                                                <i class="fa fa-check text-info"></i>
                                                            </a>
                                                        </td> --}}
                                                @endif

                                                <!-- Attendance Modal -->
                                                <div class="modal custom-modal fade"
                                                    id="attendance_info_{{ $dia }}{{ $emp->id }}"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Información de asistencia</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="card att-statistics">
                                                                    <div class="card-body p-0 pt-3">
                                                                        @if ($emp->departamento)
                                                                            <h3 class="card-title text-center">
                                                                                {{ $emp->usuario->nombres }}
                                                                                {{ $emp->usuario->apellidos }}
                                                                                <br>
                                                                                <span class="text-muted">
                                                                                    {{ $emp->departamento->nombre }}
                                                                                </span>
                                                                            </h3>
                                                                            <div class="row">
                                                                                <div class="col-6 text-center">
                                                                                    <p>
                                                                                        Entrada<br>
                                                                                        <span
                                                                                            class="text-muted">{{ $emp->departamento->hora_ini }}</span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-6 text-center">
                                                                                    <p>
                                                                                        Salida<br>
                                                                                        <span
                                                                                            class="text-muted">{{ $emp->departamento->hora_fin }}</span>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <h5 class="card-title text-center">Sin
                                                                                departamento</h5>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="card punch-status">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">Horas <small
                                                                                        class="text-muted">
                                                                                        {{ fecha_literal($emp->buscarAsistencia($dia, $mes, $anio)->fecha) }}
                                                                                    </small></h5>
                                                                                <div class="punch-det">
                                                                                    <h6>Entrada</h6>
                                                                                    <p>
                                                                                        {{ $emp->buscarAsistencia($dia, $mes, $anio)->asistencias->first()->hora_ini }}
                                                                                    </p>
                                                                                </div>
                                                                                @if ($ini > $emp->departamento->hora_ini)
                                                                                    <div class="alert alert-info">
                                                                                        Atraso de
                                                                                        {{ obtener_horas_segundos(obtener_horas($emp->departamento->hora_ini, $ini)) }}
                                                                                    </div>
                                                                                @endif
                                                                                <div class="punch-info">
                                                                                    @php
                                                                                        $horasCumplidas =
                                                                                            $emp->horas(
                                                                                                $emp->buscarAsistencia(
                                                                                                    $dia,
                                                                                                    $mes,
                                                                                                    $anio,
                                                                                                )->fecha,
                                                                                            ) >= 8;
                                                                                    @endphp
                                                                                    <div
                                                                                        class="punch-hours {{ $fin ? 'border-success' : 'border-warning' }}">
                                                                                        <span
                                                                                            id="timer_{{ $dia }}{{ $emp->id }}">
                                                                                            {{ obtener_horas_segundos($emp->horas($emp->buscarAsistencia($dia, $mes, $anio)->fecha)) }}
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($fin)
                                                                                    <div
                                                                                        class="alert alert-{{ $horasCumplidas ? 'success' : 'warning' }}">
                                                                                        {{ $horasCumplidas ? 'Horas cumplidas' : 'Horas faltantes' }}
                                                                                    </div>
                                                                                @endif
                                                                                <div class="punch-det">
                                                                                    <h6>Salida</h6>
                                                                                    <p>
                                                                                        @php
                                                                                            $fin = '-';
                                                                                            foreach (
                                                                                                $emp
                                                                                                    ->buscarAsistencia(
                                                                                                        $dia,
                                                                                                        $mes,
                                                                                                        $anio,
                                                                                                    )
                                                                                                    ->asistencias->reverse()
                                                                                                as $asis
                                                                                            ) {
                                                                                                if ($asis->hora_fin) {
                                                                                                    $fin =
                                                                                                        $asis->hora_fin;
                                                                                                    break;
                                                                                                }
                                                                                            }
                                                                                        @endphp
                                                                                        {{ $fin }}
                                                                                    </p>
                                                                                </div>
                                                                                @if ($fin != '-' && $fin < $emp->departamento->hora_fin)
                                                                                    <div class="alert alert-warning">
                                                                                        Se fue antes de la hora
                                                                                        {{ obtener_horas_segundos(obtener_horas($fin, $emp->departamento->hora_fin)) }}
                                                                                    </div>
                                                                                @endif
                                                                                @if ($fin == '-' && date('Y-m-d') != $fecha)
                                                                                    @if ($asis->estado === null)
                                                                                        <div class="alert alert-danger">
                                                                                            No marco salida
                                                                                        </div>
                                                                                    @else
                                                                                        <div
                                                                                            class="alert alert-{{ $asis->estado ? 'success' : 'danger' }}">
                                                                                            {{ $asis->estado ? 'Motivo permitido' : 'Motivo rechazado' }}
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                                {{-- <div class="statistics">
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>Break</p>
                                                                                                <h6>1.21 hrs</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>Overtime</p>
                                                                                                <h6>3 hrs</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card recent-activity">
                                                                            <div class="card-body activity-wrapper">
                                                                                <h5 class="card-title">Actividad de hoy
                                                                                </h5>
                                                                                <ul class="res-activity-list">
                                                                                    @if ($emp->buscarAsistencia($dia, $mes, $anio))
                                                                                        @foreach ($emp->buscarAsistencia($dia, $mes, $anio)->asistencias->reverse() as $asis)
                                                                                            @if ($asis->hora_fin != null)
                                                                                                <li>
                                                                                                    <p class="mb-0">
                                                                                                        Salida</p>
                                                                                                    <p
                                                                                                        class="res-activity-time">
                                                                                                        <i
                                                                                                            class="fa fa-clock-o"></i>
                                                                                                        {{ $asis->hora_fin }}
                                                                                                    </p>
                                                                                                </li>
                                                                                            @endif
                                                                                            <li>
                                                                                                <p class="mb-0">Entrada
                                                                                                </p>
                                                                                                <p
                                                                                                    class="res-activity-time">
                                                                                                    <i
                                                                                                        class="fa fa-clock-o"></i>
                                                                                                    {{ $asis->hora_ini }}
                                                                                                </p>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        @if ($asis->note)
                                                                            <div class="card recent-activity">
                                                                                <div class="card-body activity-wrapper">
                                                                                    <h5 class="card-title">Motivo
                                                                                    </h5>
                                                                                    <p>
                                                                                        {{ $asis->note }}
                                                                                    </p>
                                                                                    @if ($asis->estado === null && Auth::user()->role[0]->name == 'admin')
                                                                                        <br>
                                                                                        <form id="form-note">
                                                                                            @csrf
                                                                                            <input type="hidden"
                                                                                                name="note_id"
                                                                                                id="note_id"
                                                                                                value="{{ $asis->id }}">
                                                                                            <input type="hidden"
                                                                                                name="note"
                                                                                                id="note"
                                                                                                value="{{ $asis->note }}">
                                                                                            <input type="hidden"
                                                                                                name="note_estado"
                                                                                                id="note_estado">
                                                                                            <button type="submit"
                                                                                                class="btn btn-sm btn-success"
                                                                                                onclick="$('#note_estado').val('1')">Permitir
                                                                                                motivo</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-sm btn-danger"
                                                                                                onclick="$('#note_estado').val('0')">Rechazar
                                                                                                motivo</button>
                                                                                        </form>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Attendance Modal -->
                                            @else
                                                <td>
                                                    <i class="fa fa-close text-danger" title="Falta"></i>
                                                </td>
                                            @endif
                                        @endforeach
                                        {{-- <td>
                                        <div class="half-day">
                                            <span class="first-off"><a href="javascript:void(0);" data-toggle="modal"
                                                    data-target="#attendance_info"><i
                                                        class="fa fa-check text-success"></i></a></span>
                                            <span class="first-off"><i class="fa fa-close text-danger"></i></span>
                                        </div>
                                    </td>

                                    <td><i class="fa fa-close text-danger"></i> </td>
                                </tr> --}}
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.asis-info').on('click', function() {
                const id = $(this).data('id')
                const ini = $(this).data('ini')
                const fin = $(this).data('fin')

                const date = $(this).data('date')
                const today = new Date().toISOString().split('T')[0]
                const [year, month, day] = date.split('-').map(num => num.padStart(2, '0'));
                const dateNow = `${year}-${month}-${day}`;
                if (!fin && today == dateNow) {
                    let inicioSegundos = convertirAHorasASegundos(ini);
                    activeInterval = setInterval(() => actualizarTimer(inicioSegundos, id), 1000);
                }
            })

            $('.modal').on('hidden.bs.modal', function() {
                clearInterval(activeInterval);
                activeInterval = null
            });

            $('#form-note').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                const id = $('#note_id').val();
                formData.append('_method', 'PUT');
                const url = `{{ url('admin/asistencias/nota') }}/${id}`

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
            })
        });

        let activeInterval = null;

        function convertirAHorasASegundos(hora) {
            if (!hora) return 0;
            const [h, m, s] = hora.split(':').map(Number);
            return h * 3600 + m * 60 + s;
        }

        function obtenerHoraActual() {
            const d = new Date();
            const h = d.getHours().toString().padStart(2, '0');
            const m = d.getMinutes().toString().padStart(2, '0');
            const s = d.getSeconds().toString().padStart(2, '0');
            return `${h}:${m}:${s}`;
        }

        function actualizarTimer(inicioSegundos, id) {
            const ahoraSegundos = convertirAHorasASegundos(obtenerHoraActual()); // Hora actual en segundos
            const totalSegundos = ahoraSegundos - inicioSegundos; // Segundos transcurridos

            // Si los segundos son negativos, no mostrar nada (por ejemplo, si la hora inicial no es válida)
            if (totalSegundos < 0) {
                $('#timer_' + id).text('-');
                return;
            }

            const horas = Math.floor(totalSegundos / 3600); // Horas completas
            const minutos = Math.floor((totalSegundos % 3600) / 60); // Minutos restantes
            const segundos = totalSegundos % 60; // Segundos restantes

            // Crear el formato dinámico
            let formato = '';
            if (horas > 0) formato += `${horas.toString().padStart(2, '0')}h `;
            if (minutos > 0 || horas > 0) formato += `${minutos.toString().padStart(2, '0')}m `;
            formato += `${segundos.toString().padStart(2, '0')}s`;

            $('#timer_' + id).text(formato.trim());
        }
    </script>
@endpush
